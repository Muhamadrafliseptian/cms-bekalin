<?php

namespace App\Http\Controllers\Home\WhyUs;

use App\Models\SectionContent;
use App\Models\WhyUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WhyUsController
{
    public function index()
    {
        try {
            $contents = SectionContent::where('section_id', 5)->get();
            $section = $contents->pluck('value', 'key');
            $data = WhyUs::all();
            if(request()->wantsJson()){
                return response()->json([
                    'status' => "success",
                    "data" => $data
                ]);
            }
            return view('pages.home.why-us.index-why-us', ['section' => $section, 'data' => $data]);
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'headline' => 'required|string',
                'subheadline' => 'required|string',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:5048',
            ]);
            $imgPath = null;

            if ($request->hasFile('image')) {
                $imgPath = $request->file('image')->store('whyus', 'public');
            }

            WhyUs::create([
                'headline' => sanitize_and_validate_typography($request->headline),
                'subheadline' => sanitize_and_validate_typography($request->subheadline),
                'image' => $imgPath,
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal menambahkan Why Us: ' . $err->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'headline' => 'required|string',
                'subheadline' => 'required|string',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:5048',
            ]);
            $whyus = WhyUs::findOrFail($id);


            if ($request->hasFile('image')) {
                if ($whyus->image && Storage::disk('public')->exists($whyus->image)) {
                    Storage::disk('public')->delete($whyus->image);
                }

                $whyus->image = $request->file('image')->store('whyus', 'public');
            }
            $whyus->headline = sanitize_and_validate_typography($request->headline);
            $whyus->subheadline = sanitize_and_validate_typography($request->subheadline);
            $whyus->save();


            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal memperbarui WhyUs: ' . $err->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $whyus = WhyUs::findOrFail($id);
            $whyus->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $err->getMessage());
        }
    }
}
