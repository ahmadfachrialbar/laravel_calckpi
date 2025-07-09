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

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'nip' => 'required|string|max:20|unique:users',
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|string|min:8|',
    //         'jabatan' => 'required|string|max:100',
    //         'departemen' => 'required|string|max:100',
    //         'role' => 'required|string|max:50',
    //         'join_date' => 'required|date',

    //     ]);

    //     User::create($validated);
    //     return redirect('/user')->with('success', 'Data user berhasil ditambahkan');
    // }

    public function storeMultiple(Request $request)
    {
        $data = $request->input('users');

        foreach ($data as $userData) {
            \App\Models\User::create([
                'nip' => $userData['nip'],
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => bcrypt($userData['password']),
                'jabatan' => $userData['jabatan'],
                'departemen' => $userData['departemen'],
                'role' => $userData['role'],
                'join_date' => $userData['join_date'],
            ]);
        }

        return redirect()->route('user.index')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $users = user::findOrFail($id);
        return view('pages.user.edit', [
            'user' => $users,
        ]);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nip' => 'required|string|max:20|unique:users,nip,' . $user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'jabatan' => 'required|string|max:100',
            'departemen' => 'required|string|max:100',
            'role' => 'required|in:admin,karyawan',
            'join_date' => 'required|date',
            // password tidak wajib
        ]);

        $data = $request->only(['nip', 'name', 'email', 'jabatan', 'departemen', 'role', 'join_date']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'Data berhasil diperbarui');
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
