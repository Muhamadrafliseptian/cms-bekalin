<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Faq\FaqController;
use App\Http\Controllers\Home\Banner\BannerController;
use App\Http\Controllers\Home\BatchMenu\BatchMenuController;
use App\Http\Controllers\Home\Benefit\BenefitController;
use App\Http\Controllers\Home\Diskon\DiskonController;
use App\Http\Controllers\Home\Promo\PromoController;
use App\Http\Controllers\Home\Testimoni\TestimoniController;
use App\Http\Controllers\Home\WhatsInside\WhatsInsideController;
use App\Http\Controllers\Home\WhyUs\WhyUsController;
use App\Http\Controllers\Master\MasterBatchController;
use App\Http\Controllers\Master\SectionContentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard.index');
    }
    return redirect()->route('login');
});
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::prefix('')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::prefix('home')->group(function () {
        Route::prefix('banner')->group(function () {
            Route::get('/', [BannerController::class, 'index'])->name('home.banner.index');
        });
        Route::prefix('diskon')->group(function () {
            Route::get('/', [DiskonController::class, 'index'])->name('home.diskon.index');
        });
        Route::prefix('promo')->group(function () {
            Route::get('/', [PromoController::class, 'index'])->name('home.promo.index');
        });
        Route::prefix('testimoni')->group(function () {
            Route::get('/', [TestimoniController::class, 'index'])->name('home.testimoni.index');
            Route::post('store', [TestimoniController::class, 'store'])->name('home.testimoni.store');
            Route::post('put/{id}', [TestimoniController::class, 'update'])->name('home.testimoni.put');
            Route::delete('destroy/{id}', [TestimoniController::class, 'destroy'])->name('home.testimoni.destroy');
        });
        Route::prefix('benefit')->group(function () {
            Route::get('/', [BenefitController::class, 'index'])->name('home.benefit.index');
            Route::post('store', [BenefitController::class, 'store'])->name('home.benefit.store');
            Route::post('put/{id}', [BenefitController::class, 'update'])->name('home.benefit.put');
            Route::delete('destroy/{id}', [BenefitController::class, 'destroy'])->name('home.benefit.destroy');
        });
        Route::prefix('why-us')->group(function () {
            Route::get('/', [WhyUsController::class, 'index'])->name('home.why-us.index');
            Route::post('store', [WhyUsController::class, 'store'])->name('home.why-us.store');
            Route::post('put/{id}', [WhyUsController::class, 'update'])->name('home.why-us.put');
            Route::delete('destroy/{id}', [WhyUsController::class, 'destroy'])->name('home.why-us.destroy');
        });
        Route::prefix('whats-inside')->group(function () {
            Route::get('/', [WhatsInsideController::class, 'index'])->name('home.whats-inside.index');
            Route::post('store', [WhatsInsideController::class, 'store'])->name('home.whats-inside.store');
            Route::post('put/{id}', [WhatsInsideController::class, 'update'])->name('home.whats-inside.put');
            Route::delete('destroy/{id}', [WhatsInsideController::class, 'destroy'])->name('home.whats-inside.destroy');
        });
        Route::prefix('batch-menu')->group(function () {
            Route::get('/', [BatchMenuController::class, 'index'])->name('home.batch-menu.index');
            Route::post('store', [BatchMenuController::class, 'store'])->name('home.batch-menu.store');
            Route::post('put/{id}', [BatchMenuController::class, 'update'])->name('home.batch-menu.put');
        });
    });
    Route::prefix('faq')->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('faq.index');
        Route::post('store', [FaqController::class, 'store'])->name('faq.store');
        Route::post('put/{id}', [FaqController::class, 'update'])->name('faq.put');
        Route::delete('destroy/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');
    });
    Route::prefix('master')->group(function () {
        Route::prefix('section-contents')->group(function () {
            Route::post('store/{id}', [SectionContentController::class, 'store'])->name('master.section-contents.store');
        });
        Route::prefix('batch')->group(function(){
            Route::get('/', [MasterBatchController::class, 'index'])->name('master.batch.index');
        });
    });
});
