<?php

namespace App\Http\Controllers\Home\WhatsInside;

use App\Models\SectionContent;
use App\Models\WhatsInside;
use Illuminate\Http\Request;

class WhatsInsideController
{
    public function index()
    {
        try {
            $contents = SectionContent::where('section_id', 6)->get();
            $section = $contents->pluck('value', 'key');
            $data = WhatsInside::all();
            return view('pages.home.whats-inside.index-whats-inside', ['section' => $section, 'data' => $data]);
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'headline' => 'required|string',
            'subheadline' => 'required|string',
        ]);

        try {
            WhatsInside::create([
                'headline' => $request->headline,
                'subheadline' => $request->subheadline,
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal menambahkan WhatsInside: ' . $err->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'headline' => 'required|string',
            'subheadline' => 'required|string',
        ]);

        try {
            $whatsinside = WhatsInside::findOrFail($id);
            $whatsinside->update([
                'headline' => $request->headline,
                'subheadline' => $request->subheadline,
            ]);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal memperbarui WhatsInside: ' . $err->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $whatsinside = WhatsInside::findOrFail($id);
            $whatsinside->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $err->getMessage());
        }
    }
}
