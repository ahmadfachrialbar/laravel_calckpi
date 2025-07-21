<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPosition;




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
        $jobPositions = JobPosition::all();
        $user = new \App\Models\User();

        return view('pages.user.create', compact('jobPositions', 'user'));
    }


    public function storeMultiple(Request $request)
    {
        $data = $request->input('users');

        foreach ($data as $userData) {
            $user = User::create([
                'nip' => $userData['nip'],
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => bcrypt($userData['password']),
                'job_position_id' => $request->job_position_id,
                'role' => $userData['role'],
                'join_date' => $userData['join_date'],
            ]);

            // ✅ Tambahkan assignRole per user yang baru dibuat
            $user->assignRole($userData['role']);
            // atau jika semua pasti karyawan, bisa langsung: $user->assignRole('karyawan');
        }

        notify()->success('Data karyawan berhasil ditambahkan', 'Sukses');
        return redirect()->route('user.index');
    }


    public function edit($id)
    {
        $users = user::findOrFail($id);
        $jobPositions = \App\Models\JobPosition::all(); // Ambil semua jabatan
        return view('pages.user.edit', compact('users', 'jobPositions'), [
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
            'job_position_id' => 'required|exists:job_positions,id', // validasi relasi
            'role' => 'required|in:admin,karyawan',
            'join_date' => 'required|date',
        ]);

        $data = $request->only([
            'nip',
            'name',
            'email',
            'job_position_id',
            'role',
            'join_date'
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        // Debug: cek apakah berhasil
        if (!$user->wasChanged()) {
            return back()->with('error', 'Tidak ada data yang diubah.');
        }

        notify()->success('Data karyawan berhasil diperbarui', 'Sukses');
        return redirect()->route('user.index');
    }



    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.show', [
            'user' => $user,
        ]);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        notify()->success('Data karyawan berhasil dihapus', 'Sukses');
        return redirect('/user');
    }
}
