<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posyandu;
use App\Models\TbStuntingStandar;
use Carbon\Carbon;

class RekapSartikaController extends Controller
{
     public function index()
    {
    //    $bulan = request()->get('bulan') ?? date('m');
    //     $tahun = request()->get('tahun') ?? date('Y');
        $periode = request()->get('periode') ?? date('Y-m');
        [$tahun, $bulan] = explode('-', $periode);

        $rekap = [];

        $posyandus = Posyandu::with(['anak.laporanAnak'])->get();

        foreach ($posyandus as $posyandu) {
            $data = [
                'nama' => $posyandu->nama,
                'sangat_pendek' => 0,
                'pendek' => 0,
                'normal' => 0,
                'tinggi' => 0,
            ];

            foreach ($posyandu->anak as $anak) {
                $laporan = $anak->laporanAnak()
                    ->whereMonth('tanggal_pemeriksaan', $bulan)
                    ->whereYear('tanggal_pemeriksaan', $tahun)
                    ->first();

                if ($laporan && $laporan->tinggi_badan) {
                    $tinggi = floatval($laporan->tinggi_badan);
                    $umur = Carbon::parse($anak->tanggal_lahir)
                        ->diffInMonths(Carbon::parse($laporan->tanggal_pemeriksaan));

                    $standar = TbStuntingStandar::where('jenis_kelamin', $anak->kelamin)
                        ->where('umur_bulan', $umur)
                        ->first();

                    if ($standar && $standar->median && $standar->sd_min_1) {
                        $sd = $standar->median - $standar->sd_min_1;
                        if ($sd > 0) {
                            $z = ($tinggi - $standar->median) / $sd;

                            if ($z < -3) {
                                $data['sangat_pendek']++;
                            } elseif ($z < -2) {
                                $data['pendek']++;
                            } elseif ($z <= 2) {
                                $data['normal']++;
                            } else {
                                $data['tinggi']++;
                            }
                        }
                    }
                }
            }

            $data['total_balita'] = $data['sangat_pendek'] + $data['pendek'] + $data['normal'] + $data['tinggi'];
            $data['balita_stunting'] = $data['sangat_pendek'] + $data['pendek'];
            $data['angka_stunting'] = $data['total_balita'] > 0
                ? round(($data['balita_stunting'] / $data['total_balita']) * 100, 2)
                : 0;

            $rekap[] = $data;
        }

        return view('RekapSartika', compact('rekap','bulan','tahun'));
    }
}
