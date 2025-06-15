<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\Faq;
use App\Models\Testimoni;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController
{
    public function index(){
        try {
            $countTestimoni = Testimoni::count();
            $countFaq = Faq::count();
            $countBenefit = Benefit::count();
            $countAdmin = User::count();
            return view('index-dashboard', ['testimoni' => $countTestimoni, 'faq' => $countFaq, 'benefit' => $countBenefit, 'admin' => $countAdmin]);
        } catch (\Exception $err){

        }
    }
}
