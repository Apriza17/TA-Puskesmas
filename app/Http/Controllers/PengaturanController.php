<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StuntingStandarImport;
use Illuminate\Support\Facades\Hash;
use Exception;
use Maatwebsite\Excel\Validators\ValidationException;

class PengaturanController extends Controller
{
    public function index()
    {
        return view ('Pengaturan');
    }

    public function templateIMT()
    {
        $filePath = storage_path('app/templates/Format_IMT.xlsx');
        return response()->download($filePath, 'Format_IMT.xlsx');
    }

    public function templates()
    {
        $filePath = storage_path('app/templates/Format_Posyandu & Anak.xlsx');
        return response()->download($filePath, 'Format_Posyandu & Anak.xlsx');
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    try {
        // Coba jalankan kode impor di sini
        Excel::import(new StuntingStandarImport, $request->file('file'));

        // Jika impor berhasil, redirect dengan pesan sukses
        return redirect()->route('stunting.import.form')->with('success', 'Data berhasil diimport!');

    } catch (ValidationException $e) {
        // Tangkap error validasi spesifik dari Laravel Excel
        $failures = $e->failures();
        $errorMessages = [];

        foreach ($failures as $failure) {
            $errorMessages[] = "Error di baris <strong>" . $failure->row() . "</strong>: " . implode(", ", $failure->errors());
        }

        return redirect()->route('stunting.import.form')->with('error', 'Terdapat kesalahan pada data Excel: <br>' . implode('<br>', $errorMessages));

    } catch (Exception $e) {
        // Tangkap semua jenis error lainnya (misal: error koneksi database)
        // Pesan error $e->getMessage() akan memberikan detail errornya
        return redirect()->route('stunting.import.form')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:8', 'max:72', 'confirmed'],
            'logout_others'    => ['nullable', 'boolean'],
        ],[
            'current_password.current_password' => 'Password saat ini tidak cocok.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.max' => 'Password baru maksimal 72 karakter.',
            'confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        $user = $request->user();

        // update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui. Silahkan login kembali.');
    }
}
