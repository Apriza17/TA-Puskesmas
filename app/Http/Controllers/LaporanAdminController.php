<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanBulananPosyandu;
use App\Models\Posyandu;
use App\Models\Anak;
use App\Models\LaporanAnak;
use App\Models\TbStuntingStandar;
use Carbon\Carbon;

class LaporanAdminController extends Controller
{
    public function index(Request $request)
    {
        // Tentukan bulan yang ingin ditampilkan, default: bulan ini
        $tanggal = $request->input('tanggal')
        ? Carbon::parse($request->tanggal)->startOfMonth()
        : Carbon::now()->startOfMonth();

        // Ambil semua posyandu
        $posyanduList = Posyandu::withCount('anak', 'bumil')->get();

        // Ambil laporan yang sudah ada untuk bulan ini
        $laporan = LaporanBulananPosyandu::where('tanggal_laporan', $tanggal->toDateString())->get()->keyBy('posyandu_id');
        return view('Laporan', compact('posyanduList', 'laporan', 'tanggal'));
    }

    public function show($id)
    {
        $laporanBulanan = LaporanBulananPosyandu::with('posyandu')->findOrFail($id);

        $tahun = Carbon::parse($laporanBulanan->tanggal_laporan)->year;

        $anakList = Anak::where('posyandu_id', $laporanBulanan->posyandu_id)->get();

        $laporanAnak = LaporanAnak::with('anak')
            ->whereYear('tanggal_pemeriksaan', $tahun)
            ->whereIn('anak_id', $anakList->pluck('id'))
            ->get();

        foreach ($laporanAnak as $lap) {
            $umurBulan = Carbon::parse($lap->anak->tanggal_lahir)->diffInMonths($lap->tanggal_pemeriksaan);
            $standar = TbStuntingStandar::where('jenis_kelamin', $lap->anak->kelamin)
                ->where('umur_bulan', $umurBulan)
                ->first();

            if ($standar && $lap->tinggi_badan < $standar->sd_min_1) {
                $lap->status_stunting = 'Stunting';
            } else {
                $lap->status_stunting = 'Normal';
            }
        }

        $laporanAnak = $laporanAnak->groupBy(function ($item) {
            return $item->anak_id . '-' . Carbon::parse($item->tanggal_pemeriksaan)->month;
        });

        return view('LaporanDetail', compact('laporanBulanan', 'anakList','laporanAnak', 'tahun'));
    }
}
