<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController
{
    public function index(){
        try {
            return view('index-dashboard');
        } catch (\Exception $err){

        }
    }
}
