<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posyandu;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\LaporanAnak;
use App\Models\TbStuntingStandar;
use App\Models\Pesan;

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

        $awal  = now()->startOfMonth();
        $akhir = now()->endOfMonth();

        $laporan = LaporanAnak::with('anak')
        ->whereBetween('tanggal_pemeriksaan', [$awal->toDateString(), $akhir->toDateString()])
        ->get();

        $agg = []; // [posyandu_id => ['ditimbang'=>n, 'stunted'=>m]]
        foreach ($laporan as $lap) {
            $anak = $lap->anak;
            if (!$anak || !$anak->posyandu_id) continue;

            // hitung umur (bulan) pada TANGGAL PEMERIKSAAN
            $umurBulan = Carbon::parse($anak->tanggal_lahir)
                ->diffInMonths(Carbon::parse($lap->tanggal_pemeriksaan));

            // ambil standar TB/U
            $std = TbStuntingStandar::where('jenis_kelamin', $anak->kelamin)
                ->where('umur_bulan', $umurBulan)
                ->first();

            $isStunted = $std && ($lap->tinggi_badan < $std->sd_min_1);

            $pos = $anak->posyandu_id;
            if (!isset($agg[$pos])) $agg[$pos] = ['ditimbang' => 0, 'stunted' => 0];

            $agg[$pos]['ditimbang']++;
            if ($isStunted) $agg[$pos]['stunted']++;
        }

        // angka stunting per posyandu -> rata-rata
        $rates = [];
        foreach ($agg as $row) {
            if ($row['ditimbang'] > 0) {
                $rates[] = ($row['stunted'] / $row['ditimbang']) * 100;
            }
        }

        $posIds   = array_keys($agg);
        $posNames = Posyandu::whereIn('id', $posIds)->pluck('nama', 'id');

        // Susun rate per posyandu
        $posRates = [];
        foreach ($agg as $pid => $row) {
            if ($row['ditimbang'] > 0) {
                $rate = round(($row['stunted'] / $row['ditimbang']) * 100, 2);
                $posRates[] = [
                    'id'        => $pid,
                    'nama'      => $posNames[$pid] ?? ("Posyandu #".$pid),
                    'rate'      => $rate,
                    'ditimbang' => $row['ditimbang'],
                    'stunted'   => $row['stunted'],
                ];
            }
        }


        $top3 = collect($posRates)->sortBy('rate')->take(3)->values()->all();
        $avgStunting = count($rates) ? round(array_sum($rates) / count($rates), 2) : null;



        return view('Dashboard', compact('user','unreadNotifications', 'jumlahBelumMelapor', 'avgStunting', 'top3'));

    }

    public function belumMelapor(Request $request)
    {
        $periode = $request->input('periode', now()->format('Y-m'));
        [$tahun, $bulan] = explode('-', $periode);

        $awal  = Carbon::createFromDate((int)$tahun, (int)$bulan, 1)->startOfMonth();
        $akhir = $awal->copy()->endOfMonth();

        // Posyandu yang BELUM melapor (cek ke laporan anak bulan tsb)
        $belumMelapor = Posyandu::whereDoesntHave('anak.laporanAnak', function ($q) use ($awal,$akhir) {
                $q->whereBetween('tanggal_pemeriksaan', [$awal,$akhir]);
            })
            ->withCount('anak')
            ->leftJoinSub(
                Pesan::select('posyandu_id',
                    DB::raw('MAX(created_at) as last_sent'),
                    DB::raw('MAX(CASE WHEN terbaca = 1 THEN 1 ELSE 0 END) as any_read')
                )
                ->whereYear('created_at', $awal->year)
                ->whereMonth('created_at', $awal->month)
                ->groupBy('posyandu_id'),
                'ps',
                fn($j)=>$j->on('posyandu.id','=','ps.posyandu_id')
            )
            ->select('posyandu.*','ps.last_sent','ps.any_read')
            ->paginate(10);

        return view('BelumLapor', [
            'awal'          => $awal,
            'periode'       => $periode,
            'bulan'         => (int)$bulan,
            'tahun'         => (int)$tahun,
            'belumMelapor'  => $belumMelapor,
        ]);
    }

    public function kirimPesanBelumMelapor(Request $request)
    {
        $request->validate([
            'periode' => ['required','date_format:Y-m'],
            'pesan'   => ['required','string','max:500'],
        ]);

        [$tahun,$bulan] = explode('-', $request->periode);
        $awal  = Carbon::createFromDate((int)$tahun,(int)$bulan,1)->startOfMonth();
        $akhir = $awal->copy()->endOfMonth();

        // Target posyandu (belum melapor)
        $posyandus = Posyandu::whereDoesntHave('anak.laporanAnak', function ($q) use ($awal,$akhir) {
                $q->whereBetween('tanggal_pemeriksaan', [$awal,$akhir]);
            })->get();

        $judul = 'Pengingat Pelaporan';
        $isi   = $request->pesan;

        $sent = 0;
        foreach ($posyandus as $p) {
            // cegah dobel kirim untuk periode yang sama (berdasarkan created_at)
            $exists = Pesan::where('posyandu_id', $p->id)
                ->where('judul', $judul)
                ->whereYear('created_at', $awal->year)
                ->whereMonth('created_at', $awal->month)
                ->exists();

            if (!$exists) {
                Pesan::create([
                    'posyandu_id' => $p->id,
                    'judul'       => $judul,
                    'isi'         => $isi,
                    'terbaca'     => false,
                ]);
                $sent++;
            }
        }

        return back()->with('success', "Pesan dikirim ke {$sent} posyandu untuk ".$awal->translatedFormat('F Y').".");
    }



}
