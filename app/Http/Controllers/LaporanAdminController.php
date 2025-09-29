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
        // Bulan yang ingin ditampilkan (dari <input type="month">)
        $tanggal = $request->filled('tanggal')
            ? Carbon::parse($request->tanggal)->startOfMonth()
            : now()->startOfMonth();

        $awalBulan = $tanggal->copy()->startOfMonth();
        $akhirBulan = $tanggal->copy()->endOfMonth();

        // Semua posyandu (plus count jika dipakai di view)
         $posyanduList = Posyandu::withCount('anak', 'bumil')
        ->orderBy('nama')
        ->paginate(10)
        ->withQueryString(); // keep ?tanggal=...

        $posIds = $posyanduList->pluck('id');

        // Ambil ID laporan bulanan (untuk link detail), tetap berdasarkan startOfMonth (penanda periode)
        $bulananMap = LaporanBulananPosyandu::whereDate('tanggal_laporan', $awalBulan->toDateString())
            ->get()
            ->keyBy('posyandu_id'); // -> [posyandu_id => LaporanBulananPosyandu]

        // Ambil TANGGAL PEMERIKSAAN SEBENARNYA per posyandu (min tanggal dalam bulan itu)
        $firstDates = LaporanAnak::join('anak', 'anak.id', '=', 'laporan_anak_bulanan.anak_id')
            ->whereBetween('laporan_anak_bulanan.tanggal_pemeriksaan', [
                $awalBulan->toDateString(),
                $akhirBulan->toDateString(),
            ])
            ->groupBy('anak.posyandu_id')
            ->selectRaw('anak.posyandu_id, MIN(laporan_anak_bulanan.tanggal_pemeriksaan) AS first_tanggal')
            ->get()
            ->keyBy('posyandu_id'); // -> [posyandu_id => { first_tanggal }]

        // Gabungkan ke $posyanduList
        $laporan = collect();
        foreach ($posyanduList as $pos) {
            $bulanan = $bulananMap->get($pos->id);       // boleh null
            $first   = $firstDates->get($pos->id);       // boleh null

            if (!$first) {                // belum ada pemeriksaan di bulan tsb
                $laporan->put($pos->id, null);
                continue;
            }

            $laporan->put($pos->id, (object)[
                'id' => optional($bulanan)->id,          // untuk /Laporan/{id} jika ada
                'tanggal_laporan' => $first->first_tanggal, // tampilkan tanggal nyata di tabel
            ]);
        }
         $totalPosAll = Posyandu::count();

        $sudahAll = LaporanAnak::join('anak', 'anak.id', '=', 'laporan_anak_bulanan.anak_id')
            ->whereBetween('laporan_anak_bulanan.tanggal_pemeriksaan', [$awalBulan->toDateString(), $akhirBulan->toDateString()])
            ->distinct('anak.posyandu_id')
            ->count('anak.posyandu_id');

        $belumAll = $totalPosAll - $sudahAll;

        return view('Laporan', compact('posyanduList', 'laporan', 'tanggal', 'totalPosAll', 'sudahAll', 'belumAll'));
    }


    public function show($id, Request $request)
    {
        $laporanBulanan = LaporanBulananPosyandu::with('posyandu')->findOrFail($id);

        // Tahun yang dipilih: ?tahun=2024 (fallback ke tahun tanggal_laporan)
        $tahun = (int) ($request->query('tahun') ?: Carbon::parse($laporanBulanan->tanggal_laporan)->year);

        $startYear = Carbon::create($tahun, 1, 1)->startOfDay();
        $endYear   = Carbon::create($tahun, 12, 31)->endOfDay();

        // === daftar anak yang SUDAH LAHIR pada akhir tahun tsb ===
        $perPage = 5; // silakan sesuaikan
        $anakList = Anak::where('posyandu_id', $laporanBulanan->posyandu_id)
            ->whereDate('tanggal_lahir', '<=', $endYear->toDateString())
            ->orderBy('nama')
            ->paginate($perPage)
            ->withQueryString();            // supaya ?tahun ikut saat pindah halaman

        // Ambil laporan anak HANYA untuk anak di halaman ini dan HANYA di tahun itu
        $laporanAnak = LaporanAnak::with('anak')
            ->whereBetween('tanggal_pemeriksaan', [$startYear, $endYear])
            ->whereIn('anak_id', $anakList->pluck('id'))
            ->get();

        // ===== optimasi: preload standar stunting, lalu nilai status (tanpa N+1) =====
        $neededKeys = $laporanAnak->map(function ($lap) {
            $umur = Carbon::parse($lap->anak->tanggal_lahir)->diffInMonths($lap->tanggal_pemeriksaan);
            return $lap->anak->kelamin.'|'.$umur;
        })->unique()->values();

        $kelamins = $neededKeys->map(fn($k)=>explode('|',$k)[0])->unique()->values();
        $umurs    = $neededKeys->map(fn($k)=>(int)explode('|',$k)[1])->unique()->values();

        $standarMap = TbStuntingStandar::whereIn('jenis_kelamin', $kelamins)
            ->whereIn('umur_bulan', $umurs)
            ->get()
            ->keyBy(fn($r) => $r->jenis_kelamin.'|'.$r->umur_bulan);

        foreach ($laporanAnak as $lap) {
            $umurBulan = Carbon::parse($lap->anak->tanggal_lahir)->diffInMonths($lap->tanggal_pemeriksaan);
            $std = $standarMap->get($lap->anak->kelamin.'|'.$umurBulan);
            $lap->status_stunting = ($std && $lap->tinggi_badan < $std->sd_min_1) ? 'Stunting' : 'Normal';
        }

        // Group: "anak_id-bulan"
        $laporanAnak = $laporanAnak->groupBy(function ($item) {
            return $item->anak_id.'-'.Carbon::parse($item->tanggal_pemeriksaan)->month;
        });

        return view('LaporanDetail', compact('laporanBulanan', 'anakList', 'laporanAnak', 'tahun'));
    }

}
