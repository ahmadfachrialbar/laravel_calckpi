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

        notify()->success('Data jabatan/Dept berhasil ditambahkan', 'Sukses');
        return redirect()->route('jobpositions.index');
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

         notify()->success('Data jabatan/Dept berhasil diperbarui', 'Sukses');
        return redirect()->route('jobpositions.index');
    }

    public function destroy($id)
    {
        $position = JobPosition::findOrFail($id);
        $position->delete();

        notify()->success('Data jabatan/Dept berhasil dihapus', 'Sukses');
        return redirect()->route('jobpositions.index');
    }
}