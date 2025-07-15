<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posyandu;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard(){

        $user = Auth::user();
        $unreadNotifications = $user->unreadNotifications;
        // $notifications = Auth::user()->notifications; // Ambil semua notifikasi admin

        $now = Carbon::now();
        $bulan = $now->format('m');
        $tahun = $now->format('Y');

        $jumlahBelumMelapor = Posyandu::whereDoesntHave('anak.laporanAnak', function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tanggal_pemeriksaan', $bulan)
                ->whereYear('tanggal_pemeriksaan', $tahun);
        })->count();

        return view('Dashboard', compact('user','unreadNotifications', 'jumlahBelumMelapor'));

    }

    public function kirimPesanBelumMelapor()
    {
        $bulan = now()->format('m');
        $tahun = now()->format('Y');

        $posyandus = Posyandu::whereDoesntHave('anak.laporanAnak', function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggal_pemeriksaan', $bulan)
            ->whereYear('tanggal_pemeriksaan', $tahun);
        })->get();

        DB::beginTransaction();

        try {
            foreach ($posyandus as $posyandu) {
                $posyandu->pesan()->create([
                    'judul' => 'Pengingat Pelaporan',
                    'isi' => 'Mohon segera melaporkan data bulan ' . now()->translatedFormat('F Y'),
                ]);
            }

            DB::commit();
            return back()->with('success', 'Pesan berhasil dikirim ke semua posyandu yang belum melapor.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengirim pesan: ' . $e->getMessage());
        }
    }

    public function belumMelapor()
    {
        $bulan = now()->format('m');
        $tahun = now()->format('Y');

        // Ambil ID posyandu yang sudah melapor bulan ini
        $posyanduSudahMelapor = DB::table('laporan_bulanan_posyandu')
            ->whereMonth('tanggal_laporan', $bulan)
            ->whereYear('tanggal_laporan', $tahun)
            ->pluck('posyandu_id');

        // Cari posyandu yang TIDAK ADA di data laporan
        $belumMelapor = Posyandu::whereNotIn('id', $posyanduSudahMelapor)->get();

        return view('BelumLapor', compact('belumMelapor', 'bulan', 'tahun'));
    }


    public function viewData(){
        return view('Data Sartika.index');
    }

    public function viewPengguna(){
        return view('Kader');
    }



}
