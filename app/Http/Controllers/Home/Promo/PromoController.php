<?php

namespace App\Http\Controllers\Home\Promo;

use App\Models\SectionContent;
use Illuminate\Http\Request;

class PromoController
{
    public function index()
    {
        try {
            $contents = SectionContent::where('section_id', 3)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.home.promo.index-promo', compact('section'));
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
}
