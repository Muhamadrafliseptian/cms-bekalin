<?php

use App\Http\Controllers\Faq\FaqController;
use App\Http\Controllers\Home\BatchMenu\BatchMenuController;
use App\Http\Controllers\Home\Benefit\BenefitController;
use App\Http\Controllers\Home\Testimoni\TestimoniController;
use App\Http\Controllers\Home\WhatsInside\WhatsInsideController;
use App\Http\Controllers\Home\WhyUs\WhyUsController;
use App\Http\Controllers\Master\SectionContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("home")->group(function(){
    Route::post("section", [SectionContentController::class, 'indexHomeApi']);
});
Route::prefix('konten')->group(function(){
    Route::post('testimoni', [TestimoniController::class, 'index']);
    Route::post('why-us', [WhyUsController::class, 'index']);
    Route::post('benefit', [BenefitController::class, 'index']);
    Route::post('faq', [FaqController::class, 'index']);
    Route::post('whats-inside', [WhatsInsideController::class, 'index']);
    Route::post('batch-menu', [BatchMenuController::class, 'index']);
});
