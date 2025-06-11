<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SectionContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionContentController
{
    public function store(Request $request, $sectionId)
    {
        try {
            $request->validate([
                'headline'     => 'nullable|string',
                'subheadline'  => 'nullable|string',
                'img'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            ]);

            if ($request->hasFile('img')) {
                $imagePath = $request->file('img')->store('banners', 'public');
                SectionContent::updateOrCreate(
                    ['section_id' => $sectionId, 'key' => 'image'],
                    ['value' => $imagePath]
                );
            }

            if ($request->filled('headline')) {
                SectionContent::updateOrCreate(
                    ['section_id' => $sectionId, 'key' => 'headline'],
                    ['value' => $request->headline]
                );
            }

            if ($request->filled('subheadline')) {
                SectionContent::updateOrCreate(
                    ['section_id' => $sectionId, 'key' => 'subheadline'],
                    ['value' => $request->subheadline]
                );
            }

            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
