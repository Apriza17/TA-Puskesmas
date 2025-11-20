<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posyandu;
use App\Models\User;
use App\Imports\AnakPosyanduImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Anak;
use Illuminate\Validation\Rule;
use Exception;
use Maatwebsite\Excel\Validators\ValidationException;

class PosyanduController extends Controller
{
    public function index()
    {
        $posyandu = Posyandu::with(['kader', 'anak', 'bumil'])
        ->paginate(10);
        $users = User::where('role','kader')->get();

        return view('Data Sartika.index', compact('posyandu','users'));
    }

    public function show($id)
    {
        $posyandu = Posyandu::with(['anak', 'bumil'])->findOrFail($id);
        return view('Data Sartika.Detail', compact('posyandu'));
    }

     public function updateAnak(Request $request, Anak $anak)
    {
        $validated = $request->validate([
            'nama'          => ['required', 'string', 'max:100'],
            'nik'           => ['nullable', 'digits_between:8,20',
                                Rule::unique('anak','nik')->ignore($anak->id)],
            'kelamin'       => ['required', Rule::in(['L','P'])],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $anak->update($validated);

        return back()->with('success', 'Data anak berhasil diperbarui.');
    }

     public function destroy(Anak $anak)
    {
        // jika ada FK dari laporan -> pastikan ON DELETE CASCADE,
        // atau soft delete di model Anak bila diperlukan.
        $anak->delete();

        return back()->with('success', 'Data anak berhasil dihapus.');
    }

    public function showEdit($id)
    {
        $posyandu = Posyandu::find($id);
        return view('Data Sartika.index', compact('posyandu'));
    }

    public function update($id, Request $request)
    {
        $posyandu = Posyandu::find($id);
        $posyandu->update($request->except(['_token','submit']));
        return redirect ('/Data-Sartika')->with('success','Posyandu Berhasil Dirubah');
    }

    public function simpanDS(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Posyandu::create([
            'nama' => $request->nama,
        ]);

        return redirect('/Data-Sartika')->with('success','Posyandu Berhasil Ditambahkan');
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

        try {
            $import = new AnakPosyanduImport();
            Excel::import($import, $request->file('file'));

            return back()->with(
                'success',
                "Import selesai: {$import->created} data baru, {$import->updated} diperbarui."
            );

        } catch (ValidationException $e) {
            // Ini menangkap error spesifik jika data di Excel tidak valid
           $failures = $e->failures();

            $messages = [];

            foreach ($failures as $failure) {
                $row = $failure->row();  // baris ke-
                $attr = $failure->attribute(); // nama kolom
                $errors = implode(', ', $failure->errors());

                // buat pesan mudah dibaca
                $messages[] = "Baris {$row} – Kolom '{$attr}': {$errors}";
            }

            return back()->with('error', implode("<br>", $messages));
            
        } catch (Exception $e) {
            // Ini menangkap error umum lainnya (misal: koneksi db putus)
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
