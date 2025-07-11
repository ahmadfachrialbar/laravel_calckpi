<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPosition;


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
        $jobPositions = JobPosition::all();
        return view('pages.auth.register', compact('jobPositions'));
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = new User();
        $user->nip = $request->nip;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->job_position_id = $request->job_position_id;
        $user->role = 'karyawan';
        $user->join_date = $request->join_date;

        // Tambahkan logika ini untuk mengisi kolom jabatan
        $jabatan = JobPosition::find($request->job_position_id);
        
        

        $user->save();
        $user->assignRole('karyawan');

        return redirect('/')->with('success', 'Registrasi berhasil, silakan masuk.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
