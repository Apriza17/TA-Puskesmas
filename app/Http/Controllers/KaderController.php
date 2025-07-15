<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posyandu;
use App\Models\Anak;
use App\Models\Bumil;
use App\Models\Pesan;
use Illuminate\Support\Carbon;
use App\Models\LaporanAnak;
use App\Models\LaporanBulananPosyandu;
use App\Notifications\TambahNotifikasi;
use Illuminate\Support\Facades\Auth;

class KaderController extends Controller
{
    public function index(){
        $user = Auth::User();
        return view('Kader.Dash',compact('user'));
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
        $bulanDipilih = $request->input('bulan_laporan')
            ? Carbon::parse($request->input('bulan_laporan'))->startOfMonth()
            : Carbon::now()->startOfMonth();

        // Ambil semua anak dari posyandu kader
        $anakPosyandu = Anak::where('posyandu_id', $user->posyandu_id)->get();

        // Ambil anak yang belum dilaporkan di bulan yang dipilih
        $anakList = $anakPosyandu->filter(function ($anak) use ($bulanDipilih) {
            return !$anak->laporanBulanan()
                ->where('tanggal_pemeriksaan', '>=', $bulanDipilih->toDateString())
                ->where('tanggal_pemeriksaan', '<', $bulanDipilih->copy()->addMonth()->toDateString())
                ->exists();
        });

        // Cek apakah bulan ini sudah dilaporkan
        $laporanBulanIni = LaporanBulananPosyandu::where('posyandu_id', $user->posyandu_id)
            ->where('tanggal_laporan', $bulanDipilih->toDateString())
            ->first();

        $totalAnak = $anakPosyandu->count();
        $totalDilaporkan = LaporanAnak::whereIn('anak_id', $anakPosyandu->pluck('id'))
            ->whereMonth('tanggal_pemeriksaan', $bulanDipilih->month)
            ->whereYear('tanggal_pemeriksaan', $bulanDipilih->year)
            ->count();

        return view('Kader.Laporan', compact('anakList', 'bulanDipilih', 'laporanBulanIni','totalAnak','totalDilaporkan'));
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

    public function viewPesan()
    {
        $pesan = auth()->user()->posyandu->pesan()->latest()->take(5)->get();
        return view('Kader.Pesan', compact('pesan'));
    }

}
