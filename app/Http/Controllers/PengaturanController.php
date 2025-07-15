<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StuntingStandarImport;

class PengaturanController extends Controller
{
    public function index()
    {
        return view ('Pengaturan');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new StuntingStandarImport, $request->file('file'));

        return redirect()->route('stunting.import.form')->with('success', 'Data berhasil diimport!');
    }
}
