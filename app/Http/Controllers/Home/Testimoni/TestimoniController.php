<?php

namespace App\Http\Controllers\Home\Testimoni;

use App\Models\SectionContent;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController
{
    public function index()
    {
        try {
            $contents = SectionContent::where('section_id', 7)->get();
            $section = $contents->pluck('value', 'key');
            $data = Testimoni::all();
            return view('pages.home.testimoni.index-testimoni', ['section' => $section, 'data' => $data]);
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string',
                'review' => 'required|string',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);
            $imgPath = null;

            if ($request->hasFile('image')) {
                $imgPath = $request->file('image')->store('testimoni', 'public');
            }

            Testimoni::create([
                'nama' => $request->nama,
                'review' => $request->review,
                'image' => $imgPath,
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal menambahkan Why Us: ' . $err->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'review' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $testimoni = Testimoni::findOrFail($id);
            if ($request->hasFile('image')) {
                if ($testimoni->image && Storage::disk('public')->exists($testimoni->image)) {
                    Storage::disk('public')->delete($testimoni->image);
                }

                $testimoni->image = $request->file('image')->store('testimoni', 'public');
            }
            $testimoni->nama = $request->nama;
            $testimoni->review = $request->review;
            $testimoni->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal memperbarui Testimoni: ' . $err->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $testimoni = Testimoni::findOrFail($id);
            $testimoni->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $err->getMessage());
        }
    }
}
