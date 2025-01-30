<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //function untuk ke halaman login
    public function login_page()
    {
        return view('Auth.login');
    }

    //function untuk ke halaman register
    public function register_page()
    {
        if(auth()->user()->role === 'admin'){
            $cabang = Cabang::all();
        }else{
            $cabang = Cabang::where('id_cabang', '=',auth()->user()->karyawan->cabang->id_cabang)->get();
        }
        return view('auth.register', ['cabang'=>$cabang]);
    }

    //function untuk melakukan register
    public function register(Request $request)
    {
        //validasi inputan
        $validate = $request->validate([
            'email' => 'required|email|min:3',
            'name' => 'required|min:6',
            'alamat' => 'required',
            'no_telp' => 'required|numeric',
            'id_cabang'=> 'required|exists:cabang,id_cabang',
            'posisi' => 'required',
        ]);

        //membuat id user
        $id_user = Str::uuid();

        //membuat user baru
        User::create([
            'id_user' => $id_user,
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->posisi . 'fbms123'),
            'role'=> 'karyawan'
        ]);

        //memasukkan data karyawan baru
        Karyawan::create([
            'id_user' => $id_user,
            'id_karyawan' => Str::uuid(),
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'id_cabang' => $request->id_cabang,
            'posisi' => $request->posisi,
            'nama' => $request->name
        ]);

        //membuat session informasi
        session()->flash('success', 'Berhasil membuat akun baru');

        //redirect ke halaman login
        return redirect()->route('karyawan.index');

    }

    //function untuk melakukan login
    public function login(Request $request){

        //validasi inputan
        $validate = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        session(['email'=>$email]);
        if (Auth::Attempt($data)) {

            return redirect()->route('home');
        }else{
            Session::flash('err', 'Email atau Password Salah');
            return redirect()->route('login');
        }
    }

    //function untuk logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
