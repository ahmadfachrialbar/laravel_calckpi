<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{
    public function index()
    {
        $positions = JobPosition::all();
        return view('pages.jobpositions.index', compact('positions'));
    }

    public function create()
    {
        return view('pages.jobpositions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:job_positions,name'
        ]);

        JobPosition::create(['name' => $request->name]);

        return redirect()->route('jobpositions.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $position = JobPosition::findOrFail($id);
        return view('pages.jobpositions.edit', compact('position'));
    }

    public function update(Request $request, $id)
    {
        $position = JobPosition::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:job_positions,name,' . $position->id
        ]);

        $position->update(['name' => $request->name]);

        return redirect()->route('jobpositions.index')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $position = JobPosition::findOrFail($id);
        $position->delete();

        return redirect()->route('jobpositions.index')->with('success', 'Jabatan berhasil dihapus.');
    }
}