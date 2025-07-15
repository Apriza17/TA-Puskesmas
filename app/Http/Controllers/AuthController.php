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
            'password'=>'required',
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
            return redirect('/')->withErrors('Email atau Password salah!')->withInput();
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
        Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'email|required',
            'password'=>'required',
            'posyandu_id'=>'required',
        ])->validate();

        user::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'kader',
            'posyandu_id'=>$request->posyandu_id,
        ]);
        return redirect('/Pengguna');
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
