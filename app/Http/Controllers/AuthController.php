<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Posyandu;

class AuthController extends Controller
{
    public function viewDaftar()
    {
        return view('Daftar');
    }
    public function prosesDaftar(Request $request)
    {
        Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'email|required',
            'password'=>'required',
        ],[
            'name.required'=>'Nama wajib diisi',
            'email.email'=>'Email tidak valid',
            'email.required'=>'Email wajib diisi',
            'password.required'=>'Password wajib diisi',
        ])->validate();

        user::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'admin',
        ]);
        return redirect('/');
    }

    public function viewLogin()
    {
        return view ('Login');
    }

    public function prosesLogin(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'=>'required',
            'password'=>'required|',

        ],[
            'name.required'=>'Nama wajib diisi',
            'password.required'=>'Password wajib diisi',


        ]);

        $data = [
            'name' =>$request->name,
            'password' =>$request->password,
        ];

        if(Auth::attempt($data)){
            if(Auth::User()->role == 'admin'){
                return redirect('dashboard');
            } elseif (Auth::User()->role == 'kader'){
                return redirect('dashboard1');
            }

        }else{
            return back()->with('error','Login Gagal ! Silahkan Cek Kembali Username dan Password Anda');
        }

    }

    public function Logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function penggunaBaru(Request $request)
    {
        // dd($request->all());
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email', // <-- DIPERBAIKI
            'password' => 'required|string|min:8', // <-- Aturan min:8 dipindah ke sini
            'posyandu_id' => 'required|integer|exists:posyandu,id', // Validasi tambahan
        ], [
            // Pesan error kustom (opsional tapi bagus)
            'email.unique' => 'Email ini sudah digunakan. Silakan gunakan email lain.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',
            'posyandu_id.exists' => 'Posyandu yang dipilih tidak valid.',
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
            'posyandu_id.required' => 'Posyandu wajib dipilih',

        ])->validate();

        User::create([ // <-- DIPERBAIKI (U besar)
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'kader',
            'posyandu_id' => $request->posyandu_id,
        ],);

        return redirect('/Pengguna')->with('success', 'Pengguna baru berhasil ditambahkan');
    }

    public function tabelUser() {
        $users = User::where('role','kader')->get(); // Mengambil semua data user
        $posyandu = Posyandu::all();
        return view('Kader', compact('users','posyandu'));
    }

    public function hapusUser($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/Pengguna')->with('success', 'User berhasil dihapus');
    }
}
