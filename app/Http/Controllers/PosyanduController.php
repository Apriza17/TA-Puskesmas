<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posyandu;
use App\Models\User;
use App\Imports\AnakPosyanduImport;
use Maatwebsite\Excel\Facades\Excel;

class PosyanduController extends Controller
{
    public function index()
    {
        $posyandu = Posyandu::with(['kader','anak', 'bumil'])->get();
        $users = User::where('role','kader')->get();
        return view('Data Sartika.index', compact('posyandu','users'));
    }

    public function show($id)
    {
        $posyandu = Posyandu::with(['anak', 'bumil'])->findOrFail($id);
        return view('Data Sartika.Detail', compact('posyandu'));
    }

    public function showEdit($id)
    {
        $posyandu = Posyandu::find($id);

        return view('Data Sartika.Edit', compact('posyandu'));
    }

    public function update($id, Request $request)
    {
        $posyandu = Posyandu::find($id);
        $posyandu->update($request->except(['_token','submit']));
        return redirect ('/Data-Sartika');
    }

    public function simpanDS(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Posyandu::create([
            'nama' => $request->nama,
        ]);

        return redirect('/Data-Sartika')->with('Posyandu Berhasil Ditambahkan');
    }

    public function hapusPos($id) {
        $posyandu = Posyandu::findOrFail($id);
        $posyandu->delete();
        return redirect('/Data-Sartika')->with('success', 'Posyandu berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt|max:20480',
        ]);

        $import = new AnakPosyanduImport();
        Excel::import($import, $request->file('file'));

        return back()->with(
            'success',
            "Import selesai: {$import->created} data baru, {$import->updated} diperbarui."
        );
    }
}
