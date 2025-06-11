<?php

namespace App\Http\Controllers\Home\Diskon;

use App\Models\SectionContent;
use Illuminate\Http\Request;

class DiskonController
{
    public function index()
    {
        try {
            $contents = SectionContent::where('section_id', 2)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.home.diskon.index-diskon', compact('section'));
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
}
