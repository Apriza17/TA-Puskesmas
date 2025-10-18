<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\LaporanAnak;
use App\Models\Posyandu;
use App\Models\TbStuntingStandar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapSartikaExport;

class RekapSartikaController extends Controller
{
    public function index(Request $request)
    {
        // Bulan yang dipilih (default: bulan ini)
        $tanggal = $request->filled('tanggal')
            ? Carbon::parse($request->tanggal)->startOfMonth()
            : now()->startOfMonth();

        $awal  = $tanggal->copy()->startOfMonth();
        $akhir = $tanggal->copy()->endOfMonth();

        // Semua posyandu untuk ditampilkan
        $posyanduList = Posyandu::orderBy('nama')->get();

        // Ambil laporan anak pada bulan tsb, lalu ambil 1 (terbaru) per anak
        $laporanRaw = LaporanAnak::with(['anak:id,posyandu_id,kelamin,tanggal_lahir'])
            ->whereBetween('tanggal_pemeriksaan', [$awal->toDateString(), $akhir->toDateString()])
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get()
            ->unique('anak_id'); // 1 laporan terakhir per anak di bulan tsb

        // Kelompokkan per posyandu
        $laporanByPos = $laporanRaw->groupBy(fn ($r) => optional($r->anak)->posyandu_id);

        // Hasil akhir per posyandu (untuk tabel)
        $rows = [];
        $persenList = []; // untuk hitung rata-rata stunting di footer

        foreach ($posyanduList as $p) {
            $totalBalita = Anak::where('posyandu_id', $p->id)->count();

            $laporanPos = $laporanByPos->get($p->id, collect());
            $ditimbang  = $laporanPos->count();
            $tdkTimbang = max($totalBalita - $ditimbang, 0);

            // Hitung kategori TB/U
            $sangatPendek = 0; $pendek = 0; $normal = 0; $tinggi = 0;

            foreach ($laporanPos as $lap) {
                if (!$lap->anak) continue;

                $kelamin = $lap->anak->kelamin;
                $tglLahir = Carbon::parse($lap->anak->tanggal_lahir);
                $tglPeriksa = Carbon::parse($lap->tanggal_pemeriksaan);

                // Umur bulan presisi (jika tanggal periksa < tgl lahir, minus 1)
                $umur = ($tglPeriksa->year - $tglLahir->year) * 12
                      + ($tglPeriksa->month - $tglLahir->month);
                if ($tglPeriksa->day < $tglLahir->day) $umur--;

                $umur = max($umur, 0);

                $std = TbStuntingStandar::where('jenis_kelamin', $kelamin)
                    ->where('umur_bulan', $umur)
                    ->first();

                if (!$std) { $normal++; continue; }

                $tb = (float) $lap->tinggi_badan;

                // WHO TB/U:
                // Sangat Pendek: < -3 SD
                // Pendek        : -3 SD s.d < -2 SD
                // Normal        : -2 SD s.d +3 SD
                // Tinggi        : > +3 SD
                // Kolom standar silakan sesuaikan dg tabelmu:
                // sd_min_3, sd_min_2, sd_plus_3 (atau nama yang ada di tabel)
                $min3 = $std->sd_min_3 ?? ($std->sd_min3 ?? null);
                $min2 = $std->sd_min_2 ?? ($std->sd_min2 ?? null);
                $plus3 = $std->sd_plus_3 ?? ($std->sd_plus3 ?? null);

                if ($min3 !== null && $tb < $min3) {
                    $sangatPendek++;
                } elseif ($min2 !== null && $tb < $min2) {
                    $pendek++;
                } elseif ($plus3 !== null && $tb > $plus3) {
                    $tinggi++;
                } else {
                    $normal++;
                }
            }

            // Angka Stunting: (Sangat Pendek + Pendek) / DITIMBANG * 100
            $stunted = $sangatPendek + $pendek;
            $persenStunting = $ditimbang > 0 ? round(($stunted / $ditimbang) * 100, 2) : null;
            if (!is_null($persenStunting)) $persenList[] = $persenStunting;

            $rows[] = (object)[
                'posyandu'        => $p->nama,
                'total_balita'    => $totalBalita,
                'sangat_pendek'   => $sangatPendek,
                'pendek'          => $pendek,
                'normal'          => $normal,
                'tinggi'          => $tinggi,
                'ditimbang'       => $ditimbang,
                'tdk_ditimbang'   => $tdkTimbang,
                'persen_stunting' => $persenStunting,
            ];
        }

        // Rata-rata (simple mean dari % posyandu yang punya data)
        $rataRata = count($persenList) ? round(collect($persenList)->avg(), 2) : null;

        $page = request()->get('page', 1);
        $perPage = 10;
        $rowsPaginated = new LengthAwarePaginator(
            collect($rows)->forPage($page, $perPage)->values(),
            count($rows),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('RekapSartika', [
            'rows'       => $rowsPaginated, // ubah jadi $rowsPaginated
            'tanggal'    => $tanggal,
            'rataRata'   => $rataRata,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $tanggal = $request->filled('tanggal')
            ? Carbon::parse($request->tanggal)->startOfMonth()
            : now()->startOfMonth();

        [$rows, $rataRata] = $this->buildRekap($tanggal); // TANPA paginate

        $filename = 'Rekap_Sartika_'.$tanggal->format('Y_m').'.xlsx';
        return Excel::download(new RekapSartikaExport($rows, $tanggal, $rataRata), $filename);
    }

    // === PRIVATE: logic perhitungan rekap (copy dari index-mu) ===
    private function buildRekap(Carbon $tanggal): array
    {
        $awal  = $tanggal->copy()->startOfMonth();
        $akhir = $tanggal->copy()->endOfMonth();

        $posyanduList = Posyandu::orderBy('nama')->get();

        $laporanRaw = LaporanAnak::with(['anak:id,posyandu_id,kelamin,tanggal_lahir'])
            ->whereBetween('tanggal_pemeriksaan', [$awal->toDateString(), $akhir->toDateString()])
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get()
            ->unique('anak_id');

        $laporanByPos = $laporanRaw->groupBy(fn ($r) => optional($r->anak)->posyandu_id);

        $rows = [];
        $persenList = [];

        foreach ($posyanduList as $p) {
            $totalBalita = Anak::where('posyandu_id', $p->id)->count();

            $laporanPos = $laporanByPos->get($p->id, collect());
            $ditimbang  = $laporanPos->count();
            $tdkTimbang = max($totalBalita - $ditimbang, 0);

            $sangatPendek = 0; $pendek = 0; $normal = 0; $tinggi = 0;

            foreach ($laporanPos as $lap) {
                if (!$lap->anak) continue;

                $kelamin    = $lap->anak->kelamin;
                $tglLahir   = Carbon::parse($lap->anak->tanggal_lahir);
                $tglPeriksa = Carbon::parse($lap->tanggal_pemeriksaan);

                $umur = ($tglPeriksa->year - $tglLahir->year) * 12
                      + ($tglPeriksa->month - $tglLahir->month);
                if ($tglPeriksa->day < $tglLahir->day) $umur--;
                $umur = max($umur, 0);

                $std = TbStuntingStandar::where('jenis_kelamin', $kelamin)
                    ->where('umur_bulan', $umur)
                    ->first();

                if (!$std) { $normal++; continue; }

                $tb = (float) $lap->tinggi_badan;
                $min3  = $std->sd_min_3  ?? ($std->sd_min3  ?? null);
                $min2  = $std->sd_min_2  ?? ($std->sd_min2  ?? null);
                $plus3 = $std->sd_plus_3 ?? ($std->sd_plus3 ?? null);

                if ($min3 !== null && $tb < $min3)       $sangatPendek++;
                elseif ($min2 !== null && $tb < $min2)   $pendek++;
                elseif ($plus3 !== null && $tb > $plus3) $tinggi++;
                else                                     $normal++;
            }

            $stunted = $sangatPendek + $pendek;
            $persenStunting = $ditimbang > 0 ? round(($stunted / $ditimbang) * 100, 2) : null;
            if (!is_null($persenStunting)) $persenList[] = $persenStunting;

            $rows[] = (object)[
                'posyandu'        => $p->nama,
                'total_balita'    => $totalBalita,
                'sangat_pendek'   => $sangatPendek,
                'pendek'          => $pendek,
                'normal'          => $normal,
                'tinggi'          => $tinggi,
                'ditimbang'       => $ditimbang,
                'tdk_ditimbang'   => $tdkTimbang,
                'persen_stunting' => $persenStunting,
            ];
        }

        $rataRata = count($persenList) ? round(collect($persenList)->avg(), 2) : null;

        return [$rows, $rataRata];
    }
}

