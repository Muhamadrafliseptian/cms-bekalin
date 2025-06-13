<?php

namespace App\Http\Controllers\Home\Benefit;

use App\Models\Benefit;
use App\Models\SectionContent;
use Illuminate\Http\Request;

class BenefitController
{
    public function index()
    {
        try {
            $contents = SectionContent::where('section_id', 4)->get();
            $section = $contents->pluck('value', 'key');
            $data = Benefit::all();
            if(request()->wantsJson()){
                return response()->json([
                    'status' => "success",
                    "data" => $data
                ]);
            }
            return view('pages.home.benefit.index-benefit', ['section' => $section, "data" => $data]);
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'headline' => 'required|string',
        ]);

        try {
            Benefit::create([
                'headline' => sanitize_and_validate_typography($request->headline),
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal menambahkan Benefit: ' . $err->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'headline' => 'required|string',
        ]);

        try {
            $whatsinside = Benefit::findOrFail($id);
            $whatsinside->update([
                'headline' => sanitize_and_validate_typography($request->headline),
            ]);

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal memperbarui Benefit: ' . $err->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $whatsinside = Benefit::findOrFail($id);
            $whatsinside->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $err->getMessage());
        }
    }
}
