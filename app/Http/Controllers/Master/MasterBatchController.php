<?php

namespace App\Http\Controllers\Master;

use App\Models\MasterBatch;
use Illuminate\Http\Request;

class MasterBatchController
{
    public function index()
    {
        try {
            $data = MasterBatch::orderBy('start_date', 'asc')->get();
            return view('pages.master.batch.index-master-batch', ['data' => $data]);
        } catch (\Exception $err) {
            return redirect()->back()->with('error', $err->getMessage());
        }
    }
}
