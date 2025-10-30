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
use Maatwebsite\Excel\Exceptions\SheetNotFoundException;
use Throwable;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LaporanWorkbookImport;
use App\Imports\LaporanBulanImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'nik'           => ['required', 'string', 'max:16', Rule::unique('anak', 'nik')->ignore($anak->id)],
            'nama'          => ['required', 'string', 'max:100'],
            'kelamin'       => ['required', Rule::in(['L','P'])],
            'tanggal_lahir' => ['required', 'date'],
            'berat_lahir'   => ['required', 'numeric', 'min:0'],
            'tinggi_lahir'  => ['required', 'numeric', 'min:0'],
        ],[
            'nik.unique' => 'NIK sudah terdaftar untuk anak lain.',
            'nik.max' => 'NIK maksimal 16 karakter.',
            'kelamin.in' => 'Jenis kelamin harus diisi dengan L atau P.',
            'berat_lahir.min' => 'Berat lahir harus bernilai positif.',
            'tinggi_lahir.min' => 'Tinggi lahir harus bernilai positif.',
            'berat_lahir.numeric' => 'Berat lahir harus berupa angka.',
            'tinggi_lahir.numeric' => 'Tinggi lahir harus berupa angka.',
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
        ],[
            'anak_id.exists' => 'Anak yang dipilih tidak valid.',
            'anak_id.required' => 'Anak harus dipilih.',
            'tanggal_pemeriksaan.required' => 'Tanggal pemeriksaan harus diisi.',
            'berat_badan.required' => 'Berat badan harus diisi.',
            'tinggi_badan.required' => 'Tinggi badan harus diisi.',
            'lingkar_kepala.required' => 'Lingkar kepala harus diisi.',
            'lingkar_lengan_atas.required' => 'Lingkar lengan atas harus diisi.',
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
            'file' => ['required','file','mimes:xlsx,xls,csv','max:20480'],
        ]);

        try {
            $import = new LaporanWorkbookImport($request->user());
            Excel::import($import, $request->file('file'));

            $msg = "Import selesai. Berhasil: {$import->successCount}, Duplikat: {$import->duplicateCount}, "
                . "Skipped: {$import->skipCount}, Error: {$import->errorCount}.";
            return back()->with('success', $msg);

        } catch (SheetNotFoundException $e) {
            // mis. tidak ada sheet, sheet corrupt/tersembunyi, atau workbook kosong
            return back()->with('error', 'File tidak memiliki sheet yang valid. Pastikan ada minimal satu sheet berisi data.');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal mengimpor: '.$e->getMessage());
        }
    }


    public function viewPesan(Request $request)
    {
        $items = Pesan::where('posyandu_id', $request->user()->id)
            ->latest('created_at')
            ->paginate(5);

        return view('Kader.Pesan', compact('items'));
    }

    public function showPesan(Pesan $pesan)
    {
       abort_unless($pesan->posyandu_id === auth()->id(), 403);
        return view('Kader.Pesandetail', compact('pesan'));
    }

    public function markRead(Pesan $pesan)
    {
        abort_unless($pesan->posyandu_id === auth()->id(), 403);
       if (!$pesan->terbaca) {
            $pesan->update(['terbaca' => true]);
        }
        return back()->with('success','Pesan ditandai terbaca.');
    }

     public function riwayatLaporan(Request $request)
    {
        $user        = auth()->user();
        $posyanduId  = $user->posyandu_id;

        // filter bulan (opsional): ?periode=YYYY-MM
        $periode = $request->query('periode');
        $awal    = $periode ? Carbon::createFromFormat('Y-m', $periode)->startOfMonth() : null;
        $akhir   = $awal ? $awal->copy()->endOfMonth() : null;

        // subquery: hitung jumlah anak yang dilaporkan per bulan (distinct anak) untuk posyandu ini
        $anakCountSub = LaporanAnak::join('anak', 'anak.id', '=', 'laporan_anak_bulanan.anak_id')
            ->where('anak.posyandu_id', $posyanduId)
            ->selectRaw('DATE_FORMAT(laporan_anak_bulanan.tanggal_pemeriksaan, "%Y-%m-01") AS bulan')
            ->selectRaw('COUNT(DISTINCT laporan_anak_bulanan.anak_id) AS jml_anak')
            ->groupBy('bulan');

        $rows = LaporanBulananPosyandu::where('posyandu_id', $posyanduId)
            ->when($awal && $akhir, function ($q) use ($awal, $akhir) {
                $q->whereBetween('tanggal_laporan', [$awal->toDateString(), $akhir->toDateString()]);
            })
            ->leftJoinSub($anakCountSub, 'ac', function ($join) {
                $join->on('laporan_bulanan_posyandu.tanggal_laporan', '=', 'ac.bulan');
            })
            ->select('laporan_bulanan_posyandu.*', DB::raw('COALESCE(ac.jml_anak,0) AS jml_anak'))
            ->orderBy('tanggal_laporan', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('Kader.RiwayatLaporan', [
            'rows'    => $rows,
            'periode' => $periode,
        ]);
    }

    // DETAIL RIWAYAT untuk satu bulan
    public function detailRiwayat($id)
    {
        $user       = auth()->user();
        $posyanduId = $user->posyandu_id;

        $bulanan = LaporanBulananPosyandu::where('id', $id)
            ->where('posyandu_id', $posyanduId)   // pastikan milik posyandu kader
            ->firstOrFail();

        $awal  = Carbon::parse($bulanan->tanggal_laporan)->startOfMonth();
        $akhir = Carbon::parse($bulanan->tanggal_laporan)->endOfMonth();

        // ambil baris laporan anak bulan tsb (join anak utk nama/kelamin/nik)
        $laporan = LaporanAnak::join('anak', 'anak.id', '=', 'laporan_anak_bulanan.anak_id')
            ->where('anak.posyandu_id', $posyanduId)
            ->whereBetween('laporan_anak_bulanan.tanggal_pemeriksaan', [$awal->toDateString(), $akhir->toDateString()])
            ->orderBy('anak.nama')
            ->select([
                'laporan_anak_bulanan.*',
                'anak.nama as nama_anak',
                'anak.nik',
                'anak.kelamin',
                'anak.tanggal_lahir',
            ])
            ->get();

        return view('Kader.DetailRiwayat', [
            'bulanan' => $bulanan,
            'awal'    => $awal,
            'akhir'   => $akhir,
            'laporan' => $laporan,
        ]);
    }




    public function pengaturan()
    {
        return view('Kader.Pengaturan');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:8', 'max:72', 'confirmed'],
            'logout_others'    => ['nullable', 'boolean'],
        ],[
            'current_password.current_password' => 'Password saat ini tidak cocok.',
            'password.min' => 'Password baru harus terdiri dari minimal 8 karakter.',
            'password.max' => 'Password baru maksimal 72 karakter.',
        ]);

        $user = $request->user();

        // update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function templateLaporan()
    {
        $filePath = storage_path('app/templates/Format_laporan_bulanan.xlsx');
        return response()->download($filePath, 'Format_laporan_bulanan.xlsx');
    }

}
