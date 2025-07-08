<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan model User sudah dibuat



class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.user.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:20|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'jabatan' => 'required|string|max:100',
            'departemen' => 'required|string|max:100',
            'role' => 'required|string|max:50',
            'join_date' => 'required|date',

        ]);

        User::create($validated);
        return redirect('/user')->with('success', 'Data user berhasil ditambahkan');
    }

    public function edit($id)
    {
        $users = user::findOrFail($id);
        return view('pages.user.edit', [
            'user' => $users,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'no_telp' => 'nullable|string|max:15',
            'alamat' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'jabatan' => 'required|string|max:100',
            'tanggal_masuk' => 'required|date',
            'gaji_pokok' => 'required|numeric|min:0',

        ]);

        User::create($request->validate());
        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }


    public function show($id)
    {
        $user = user::findOrFail($id);
        return view('pages.user.show', [
            'user' => $user,
        ]);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/user')->with('success', 'User berhasil dihapus');
    }
}
