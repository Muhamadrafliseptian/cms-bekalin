<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\SectionContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Purifier;

class SectionContentController
{
    public function store(Request $request, $sectionId)
    {
        try {
            $rules = [];

            // Validasi manual hanya jika field-nya tersedia di request
            if ($request->has('headline')) {
                $rules['headline'] = 'required|string';
            }

            if ($request->has('subheadline')) {
                $rules['subheadline'] = 'required|string';
            }

            if ($request->hasFile('img')) {
                $rules['img'] = 'required|image|mimes:jpeg,png,jpg,webp|max:5048';
            }

            $request->validate($rules);

            // Simpan image jika ada
            if ($request->hasFile('img')) {
                $existing = SectionContent::where('section_id', $sectionId)
                    ->where('key', 'image')->first();

                if ($existing && Storage::disk('public')->exists($existing->value)) {
                    Storage::disk('public')->delete($existing->value);
                }

                $imagePath = $request->file('img')->store("banners/section_$sectionId", 'public');

                SectionContent::updateOrCreate(
                    ['section_id' => $sectionId, 'key' => 'image'],
                    ['value' => $imagePath]
                );
            }
            dd($imagePath); // setelah store()

            // Sanitize dan validasi konten text
            if ($request->filled('headline')) {
                $cleanHeadline = sanitize_and_validate_typography($request->headline, 'headline');

                SectionContent::updateOrCreate(
                    ['section_id' => $sectionId, 'key' => 'headline'],
                    ['value' => $cleanHeadline]
                );
            }

            if ($request->filled('subheadline')) {
                $cleanSubheadline = sanitize_and_validate_typography($request->subheadline, 'subheadline');

                SectionContent::updateOrCreate(
                    ['section_id' => $sectionId, 'key' => 'subheadline'],
                    ['value' => $cleanSubheadline]
                );
            }

            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function indexHomeApi()
    {
        try {
            if (request()->wantsJson()) {
                $data = Section::with('contents')
                    ->where('menu_id', 1)
                    ->get();

                return response()->json([
                    'status' => "success",
                    'data' => $data
                ]);
            }
        } catch (\Exception $err) {
            return response()->json([
                'status' => 'error',
                'message' => $err->getMessage(),
            ], 500);
        }
    }
}
