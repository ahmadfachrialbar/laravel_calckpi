<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPosition;

class UserController extends Controller
{
    /**
     * Menampilkan semua data karyawan
     */
    public function index()
    {
        $users = User::all();
        return view('pages.user.index', [
            'users' => $users,
        ]);
    }

    /**
     * Menampilkan form create user
     */
    public function create()
    {
        $jobPositions = JobPosition::all();
        $user = new User();

        return view('pages.user.create', compact('jobPositions', 'user'));
    }

    /**
     * Menyimpan banyak data user sekaligus
     */
    public function storeMultiple(Request $request)
    {
        $data = $request->input('users');

        foreach ($data as $index => $userData) {
            // Cek apakah NIP sudah ada
            if (User::where('nip', $userData['nip'])->exists()) {
                return back()->withErrors([
                    "users.{$index}.nip" => "NIP {$userData['nip']} sudah digunakan.",
                ])->withInput();
            }

            // Cek apakah Email sudah ada
            if (User::where('email', $userData['email'])->exists()) {
                return back()->withErrors([
                    "users.{$index}.email" => "Email {$userData['email']} sudah digunakan.",
                ])->withInput();
            }

            // Jika validasi lolos, buat user
            $user = User::create([
                'nip'              => $userData['nip'],
                'name'             => $userData['name'],
                'email'            => $userData['email'],
                'password'         => bcrypt($userData['password']),
                'job_position_id'  => $userData['job_position_id'] ?? null,
                'role'             => $userData['role'],
                'join_date'        => $userData['join_date'],
            ]);

            // Beri role menggunakan Spatie
            $user->assignRole($userData['role']);
        }

        notify()->success('Data karyawan berhasil ditambahkan', 'Sukses');
        return redirect()->route('user.index');
    }


    /**
     * Edit user
     */
    public function edit($id)
    {
        $users = User::findOrFail($id);
        $jobPositions = JobPosition::all();

        return view('pages.user.edit', compact('users', 'jobPositions'), [
            'user' => $users,
        ]);
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nip'             => 'required|string|max:20|unique:users,nip,' . $user->id,
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'job_position_id' => 'nullable|exists:job_positions,id',
            'role'            => 'required|in:admin,karyawan,direksi',
            'join_date'       => 'required|date',
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

        // ✅ Sinkronkan Role di Spatie Permission
        $user->syncRoles([$request->role]);

        notify()->success('Data karyawan berhasil diperbarui', 'Sukses');
        return redirect()->route('user.index');
    }

    /**
     * Show detail user
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.show', [
            'user' => $user,
        ]);
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        notify()->success('Data karyawan berhasil dihapus', 'Sukses');
        return redirect()->route('user.index');
    }
}