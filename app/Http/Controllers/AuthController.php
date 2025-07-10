<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Terjadi kesalahan saat masuk. Silakan periksa email dan kata sandi Anda.',
        ])->onlyInput('email');
    }

    public function RegisterView()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = new User();
        $user->nip = $request->input('nip'); 
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->jabatan = $request->input('jabatan');
        $user->departemen = $request->input('departemen');
        $user->role = 'karyawan'; // Default role
        $user->join_date = $request->input('join_date');
        
        $user->saveOrFail();

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


}
