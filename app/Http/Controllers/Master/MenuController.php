<?php

namespace App\Http\Controllers\Master;

use App\Models\MenuHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MenuController
{
    public function index()
    {
        try {
            $data = MenuHeader::all();
            return view('pages.master.menu.index-menu', compact('data'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:bkl_menu_header,name',
            ]);

            MenuHeader::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            return redirect()->route('master.menu.index')->with('success', 'Menu berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating menu: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $menu = MenuHeader::findOrFail($id);
            $request->validate([
                'name' => 'required|string|max:255|unique:bkl_menu_header,name,' . $menu->id,
            ]);

            $menu->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);
            if ($menu->metaContents) {
                $menu->metaContents->update([
                    'meta_title' => sanitize_and_validate_typography($request->name),
                ]);
            }

            return redirect()->route('master.menu.index')->with('success', 'Menu dan meta title berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Error updating menu ID $id: " . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $menu = MenuHeader::findOrFail($id);

            if ($menu->metaContents) {
                return back()->with('error', 'Menu tidak dapat dihapus karena masih digunakan pada Meta.');
            }

            $menu->delete();

            return redirect()->route('master.menu.index')->with('success', 'Menu berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Error deleting menu ID $id: " . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }
}
