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
        /* 'role' => 'required|in:admin,karyawan', */
        'join_date' => 'required|date',
    ]);

    $data = $request->only([
        'nip',
        'name',
        'email',
        'job_position_id',
        /* 'role', */
        'join_date'
    ]);

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    $user->update($data);

    return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui');
}
}