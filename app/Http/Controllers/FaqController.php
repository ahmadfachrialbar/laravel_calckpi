<?php

namespace App\Http\Controllers;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('pages.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('pages.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'pdf_path' => 'nullable|mimes:pdf|max:2048',
        ]);

        $data = $request->only(['judul', 'isi']);

        if ($request->hasFile('pdf_path')) {
            $path = $request->file('pdf_path')->store('faqs', 'public');
            $data['pdf_path'] = $path;
        }

        Faq::create($data);

        return redirect()->route('faq.index')->with('success', 'Panduan berhasil ditambahkan.');
    }

    public function download($id)
    {
        $faq = Faq::findOrFail($id);

        if (!$faq->pdf_path || !Storage::disk('public')->exists($faq->pdf_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($faq->pdf_path);
    }
}
