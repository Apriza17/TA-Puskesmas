<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posyandu;
use App\Models\Anak;
use App\Models\Bumil;
use App\Models\Pesan;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Models\LaporanAnak;
use App\Models\LaporanBulananPosyandu;
use App\Notifications\TambahNotifikasi;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LaporanWorkbookImport;
use App\Imports\LaporanBulanImport;

class KaderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $posyanduId = $user->posyandu_id ?? optional($user->posyandu)->id;

        // Query dasar: anak pada posyandu kader
        $query = Anak::where('posyandu_id', $posyanduId);

        // Pencarian opsional (nama / NIK)
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Urutkan dan paginate
        $anak = $query->orderBy('nama')->paginate(5)->withQueryString();

        return view('Kader.Dash', compact('user','anak', 'search'));
    }

    public function edit(Anak $anak)
{
    // Batasi hanya anak dari posyandu kader yang login
    $this->authorizeAnakForKader($anak);

    return view('Kader.AnakEdit', compact('anak'));
}

    public function update(Request $request, Anak $anak)
    {
        $this->authorizeAnakForKader($anak);

        $validated = $request->validate([
            'nik'           => ['required', 'string', 'max:32', Rule::unique('anak', 'nik')->ignore($anak->id)],
            'nama'          => ['required', 'string', 'max:100'],
            'kelamin'       => ['required', Rule::in(['L','P'])],
            'tanggal_lahir' => ['required', 'date'],
            'berat_lahir'   => ['required', 'numeric', 'min:0'],
            'tinggi_lahir'  => ['required', 'numeric', 'min:0'],
        ]);

        $anak->update($validated);

        return redirect('/dashboard1')->with('success', 'Data anak berhasil diperbarui.');
    }

    public function destroy(Anak $anak)
    {
        $this->authorizeAnakForKader($anak);

        $anak->delete();

        return redirect('/dashboard1')->with('success', 'Data anak berhasil dihapus.');
    }

    protected function authorizeAnakForKader(Anak $anak)
    {
        $user = Auth::user();
        $posyanduId = $user->posyandu_id ?? optional($user->posyandu)->id;

        if ($anak->posyandu_id !== $posyanduId) {
            abort(403, 'Anda tidak berhak mengakses data anak dari posyandu lain.');
        }
    }


    public function viewRegis(){
        $posyandu = Posyandu::all();
        return view('Kader.Regis',compact('posyandu'));
    }

    public function simpanRegis(Request $request){

        $request->validate([
            'nama' => 'required',
            'kelamin' => 'required',
            'nik' => 'required|max:16',
            'tanggal_lahir' => 'required|date',
            'berat_lahir' => 'required|numeric',
            'tinggi_lahir' => 'required|numeric',
        ]);
        $kader = auth()->user();//untuk mengetahui siapa yg login

        $anak = Anak::create([
            'nama' => $request->nama,
            'kelamin' => $request->kelamin,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'berat_lahir' => $request->berat_lahir,
            'tinggi_lahir' => $request->tinggi_lahir,
            'posyandu_id' => $kader->posyandu_id,
        ]);
        $admins = User::where('role','admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new TambahNotifikasi($anak, $kader));
        }

        return redirect('/Regis-anak')->with('success','Data anak ditambahkan');

    }

    public function viewRegis1(){
        $posyandu = Posyandu::all();
        return view('Kader.Regis1',compact('posyandu'));
    }

    public function simpanRegis1(Request $request){

        $kader = auth()->user();//untuk mengetahui siapa yg login

        $request->validate([
            'nama' => 'required',
            'nik' => 'required|max:16',
            'tanggal_lahir' => 'required|date',
        ]);

        Bumil::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'posyandu_id' => $kader->posyandu_id,
        ]);

        return redirect('/Regis-bumil')->with('success','Data Bumil ditambahkan');

    }

   public function viewLaporan(Request $request)
    {
        $user = auth()->user();

        // Gunakan DATE, default hari ini
        $tanggalDipilih = $request->filled('tanggal_laporan')
            ? \Carbon\Carbon::parse($request->input('tanggal_laporan'))->startOfDay()
            : now()->startOfDay();

        $start = $tanggalDipilih->copy()->startOfMonth();
        $end   = $tanggalDipilih->copy()->endOfMonth();

        // Anak eligible = sudah lahir pada tanggal pemeriksaan tsb
        $eligibleIds = \App\Models\Anak::where('posyandu_id', $user->posyandu_id)
            ->whereDate('tanggal_lahir', '<=', $tanggalDipilih->toDateString())
            ->orderBy('nama')
            ->pluck('id');

        // Yang tampil di SELECT = eligible & belum dilaporkan di bulan itu
        $anakList = \App\Models\Anak::whereIn('id', $eligibleIds)
            ->whereDoesntHave('laporanBulanan', function ($q) use ($start, $end) {
                $q->whereBetween('tanggal_pemeriksaan', [$start->toDateString(), $end->toDateString()]);
            })
            ->orderBy('nama')
            ->get();

        // Rekap pakai denominator "eligible"
        $totalAnak       = $eligibleIds->count();
        $totalDilaporkan = \App\Models\LaporanAnak::whereIn('anak_id', $eligibleIds)
            ->whereBetween('tanggal_pemeriksaan', [$start->toDateString(), $end->toDateString()])
            ->count();

        $laporanBulanIni = \App\Models\LaporanBulananPosyandu::where('posyandu_id', $user->posyandu_id)
            ->whereDate('tanggal_laporan', $start->toDateString())
            ->first();

        return view('Kader.Laporan', compact('anakList','tanggalDipilih','laporanBulanIni','totalAnak','totalDilaporkan'));
    }

    public function simpanLaporan(Request $request)
    {
        $request->validate([
            'anak_id' => 'required|exists:anak,id',
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'lingkar_kepala' => 'required|numeric',
            'lingkar_lengan_atas' => 'required|numeric',
        ]);

        // Simpan laporan anak
        LaporanAnak::create([
            'anak_id' => $request->anak_id,
            'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'lingkar_kepala' => $request->lingkar_kepala,
            'lingkar_lengan_atas' => $request->lingkar_lengan_atas,
            'status' => null, // Bisa dihitung otomatis nanti
        ]);

        $anak = Anak::find($request->anak_id);
        $bulanIni = Carbon::parse($request->tanggal_pemeriksaan)->startOfMonth();

        LaporanBulananPosyandu::updateOrCreate(
            [
                'posyandu_id' => $anak->posyandu_id,
                'tanggal_laporan' => $bulanIni->toDateString(),
            ],
            [
                'status' => 'sudah'
            ]
        );
        return redirect('/Laporan-anak')->with('success', 'Laporan berhasil disimpan!');
    }

      public function import(Request $request)
    {
        $request->validate([
            'file' => ['required','file','mimes:xlsx,xls,csv','max:20480'], // 20MB
        ]);

        $import = new LaporanWorkbookImport($request->user()); // kirim user kader
        Excel::import($import, $request->file('file'));

        // ringkasan hasil
        $msg = "Import selesai. Berhasil: {$import->successCount}, Duplikat: {$import->duplicateCount}, " .
               "Skipped (bukan posyandu / NIK tidak cocok / tanggal invalid): {$import->skipCount}, " .
               "Error: {$import->errorCount}.";
        return back()->with('success', $msg);
    }


    public function viewPesan()
    {
        $pesan = auth()->user()->posyandu->pesan()->latest()->take(5)->get();
        return view('Kader.Pesan', compact('pesan'));
    }

}
