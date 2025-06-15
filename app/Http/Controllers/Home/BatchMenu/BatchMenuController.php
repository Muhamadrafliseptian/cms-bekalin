<?php

namespace App\Http\Controllers\Home\BatchMenu;

use App\Models\BatchMenu;
use App\Models\MasterBatch;
use App\Models\SyncBatchLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class BatchMenuController
{
    public function index()
    {
        try {
            $latestBatch = MasterBatch::whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->first();
            if (!$latestBatch) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Batch belum tersedia',
                    'data' => null
                ], 404);
            }

            $menus = BatchMenu::where('batch_id', $latestBatch->id)->orderByRaw("
            FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')
        ")->get();

            if (request()->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data menu batch terbaru berhasil diambil',
                    'batch' => $latestBatch,
                    'menus' => $menus,
                    "latest_batch" => $latestBatch->name
                ], 200);
            }

            $data = MasterBatch::orderBy('start_date', 'asc')->get();
            $dataMenu = BatchMenu::all();
            return view('pages.home.batch-menu.index-batch-menu', ['data' => $data, 'data_menu' => $dataMenu]);
        } catch (\Exception $err) {
            return back()->with('error', $err->getMessage());
        }
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'menus' => 'required|array|min:1',
                'menus.*.day' => 'required|string',
                'menus.*.image' => 'required|image|mimes:jpg,jpeg,png|max:5048',
                'batch_id' => 'required|exists:bkl_master_batch,id',
            ]);

            $existing = BatchMenu::where('batch_id', $request->batch_id)->exists();
            if ($existing) {
                return redirect()->back()->with('error', 'Menu untuk batch ini sudah ada.');
            }

            foreach ($request->menus as $menuData) {
                $imgPath = null;

                if (isset($menuData['image']) && $menuData['image']) {
                    $imgPath = $menuData['image']->store('batch', 'public');
                }

                BatchMenu::create([
                    'batch_id' => $request->batch_id,
                    'day' => $menuData['day'],
                    'image' => $imgPath,
                ]);
            }

            return redirect()->back()->with('success', 'Menu mingguan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'image' => 'image|mimes:jpg,jpeg,png|max:5048',
            ]);
            $menu = BatchMenu::findOrFail($id);
            if ($request->hasFile('image')) {
                if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                    Storage::disk('public')->delete($menu->image);
                }
                $menu->image = $request->file('image')->store('batch', 'public');
            }

            $menu->save();

            return redirect()->back()->with('success', 'Menu berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
