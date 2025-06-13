<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\Faq;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class DashboardController
{
    public function index(){
        try {
            $countTestimoni = Testimoni::count();
            $countFaq = Faq::count();
            $countBenefit = Benefit::count();
            return view('index-dashboard', ['testimoni' => $countTestimoni, 'faq' => $countFaq, 'benefit' => $countBenefit]);
        } catch (\Exception $err){

        }
    }
}
