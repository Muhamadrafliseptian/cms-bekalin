<?php

namespace App\Http\Controllers\Home\Banner;

use App\Http\Controllers\Controller;
use App\Models\SectionContent;
use Illuminate\Http\Request;

class BannerController
{
    public function index()
    {
        try {
            $contents = SectionContent::where('section_id', 1)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.home.banner.index-banner', compact('section'));
        } catch (\Exception $err) {
            return abort(500, 'Terjadi kesalahan saat mengambil data banner.');
        }
    }
}
