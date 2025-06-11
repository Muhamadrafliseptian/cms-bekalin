<?php

namespace App\Http\Controllers\Home\BatchMenu;

use Illuminate\Http\Request;

class BatchMenuController
{
    public function index(){
        return view('pages.home.batch-menu.index-batch-menu');
    }
}
