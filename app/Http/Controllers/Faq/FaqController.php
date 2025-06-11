<?php

namespace App\Http\Controllers\Faq;

use App\Models\Faq;
use App\Models\SectionContent;
use Illuminate\Http\Request;

class FaqController
{
    public function index()
    {
        try {
            $contents = SectionContent::where('section_id', 8)->get();
            $section = $contents->pluck('value', 'key');
            $data = Faq::all();
            return view('pages.faq.index-faq', ['section' => $section, 'data' => $data]);
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        try {
            Faq::create([
                'question' => $request->question,
                'answer' => $request->answer,
            ]);

            return redirect()->back()->with('success', 'FAQ berhasil ditambahkan.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal menambahkan FAQ: ' . $err->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        try {
            $faq = Faq::findOrFail($id);
            $faq->update([
                'question' => $request->question,
                'answer' => $request->answer,
            ]);

            return redirect()->back()->with('success', 'FAQ berhasil diperbarui.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal memperbarui FAQ: ' . $err->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();
            return redirect()->back()->with('success', 'Data FAQ berhasil dihapus.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $err->getMessage());
        }
    }
}
