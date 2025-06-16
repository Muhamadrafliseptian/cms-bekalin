<?php

namespace App\Http\Controllers\Master;

use App\Models\MenuHeader;
use App\Models\Meta;
use Illuminate\Http\Request;

class MetaController
{
    public function index()
    {
        try {
            $menu = MenuHeader::all();
            $data = Meta::with('menu')->orderBy('id', 'DESC')->get();
            if (request()->wantsJson()) {
                return response()->json([
                    'data' => $data,
                    "status" => "success",
                ]);
            }
            return view('pages.master.meta.index-meta', compact('menu', 'data'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'menu_id' => 'required|exists:bkl_menu_header,id',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
            ]);

            $nameTitle = MenuHeader::findOrFail($request->menu_id)->name;

            Meta::create([
                'menu_id' => $request->menu_id,
                'meta_title' => sanitize_and_validate_typography($nameTitle),
                'meta_description' => sanitize_and_validate_typography($request->meta_description),
                'meta_keywords' => sanitize_and_validate_typography($request->meta_keywords),
            ]);

            return back()->with('success', 'Meta data berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
            ]);

            $nameTitle = MenuHeader::findOrFail($request->menu_id)->name;

            $meta = Meta::findOrFail($id);
            $meta->update([
                'menu_id' => $request->menu_id,
                'meta_title' => sanitize_and_validate_typography($nameTitle),
                'meta_description' => sanitize_and_validate_typography($request->meta_description),
                'meta_keywords' => sanitize_and_validate_typography($request->meta_keywords),
            ]);

            return back()->with('success', 'Meta data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $meta = Meta::findOrFail($id);
            $meta->delete();

            return back()->with('success', 'Meta data berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getByMenu($id)
    {
        try {
            $meta = Meta::where('menu_id', $id)->first();
            if (!$meta) {
                return response()->json(['status' => 'error', 'message' => 'Meta not found'], 404);
            }

            return response()->json(['status' => 'success', 'data' => $meta]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Internal server error'], 500);
        }
    }
}
