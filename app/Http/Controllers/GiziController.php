<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use App\Models\Anak;
use App\Models\LaporanAnak;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GiziController extends Controller
{
    public function index(Request $request)
    {
        $posyanduId = $request->get('posyandu_id');
        $anakId = $request->get('anak_id');

        $posyanduList = Posyandu::all(); // untuk dropdown Posyandu
        $anakList = $posyanduId ? Anak::where('posyandu_id', $posyanduId)->get() : collect();

        $selectedAnak = $anakId ? Anak::find($anakId) : null;

        $laporan = collect();
        if ($selectedAnak) {
            $laporan = LaporanAnak::where('anak_id', $anakId)
                ->orderBy('tanggal_pemeriksaan')
                ->get()
                ->groupBy(function ($item) {
                    return Carbon::parse($item->tanggal_pemeriksaan)->format('m');
                });
        }

        return view('Gizi', compact(
            'posyanduList', 'anakList', 'selectedAnak', 'laporan', 'posyanduId', 'anakId'
        ));
    }
}
