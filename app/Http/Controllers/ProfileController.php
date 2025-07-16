<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPosition;

class ProfileController extends Controller
{
    public function index()
{
    $user = Auth::user();
    return view('pages.profile.index', compact('user'));
}

public function edit()
{
    $user = Auth::user();
    $jobPositions = JobPosition::all();

    return view('pages.profile.edit', [
        'user' => $user,
        'jobPositions' => $jobPositions
    ]);
}

public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'nip' => 'required|string|max:20|unique:users,nip,' . $user->id,
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'job_position_id' => 'required|exists:job_positions,id',
        'join_date' => 'required|date',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = $request->only([
        'nip',
        'name',
        'email',
        'job_position_id',
        'join_date'
    ]);

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    $photoDeleted = false;

    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/profile'), $filename);

        // Hapus foto lama kalau bukan default
        if ($user->photo && $user->photo != 'defaultProfile.png') {
            $oldPath = public_path('uploads/profile/' . $user->photo);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $data['photo'] = $filename;
    }
    
    // Hapus foto kalau delete_photo di-set 1
    if ($request->delete_photo == 1) {
        if ($user->photo && $user->photo != 'defaultProfile.png') {
            $oldPath = public_path('uploads/profile/' . $user->photo);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        $data['photo'] = null;
        $photoDeleted = true;
    }

    $user->update($data);

    // Tentukan pesan notifikasi berdasarkan aksi
    if ($photoDeleted) {
        notify()->success('Foto profile berhasil dihapus', 'Sukses');
    } elseif ($request->hasFile('photo')) {
        notify()->success('Data profile berhasil diperbarui', 'Sukses');
    } else {
        notify()->success('Data profile berhasil diperbarui', 'Sukses');
    }

    return redirect()->route('profile.index');
}
}