<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MiscellaneousController;

// Main Page Route
Route::get('/', [DashboardController::class,'dashboardAnalytics'])->name('dashboard-analytics')->middleware('verified');

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
  return view('dashboard');
})->name('dashboard');

//Auth::routes();

Route::group(['middleware'=>['auth']], function() {

/* Route Dashboards */
Route::group(['prefix' => 'dashboard'], function () {
  Route::get('analytics', [DashboardController::class,'dashboardAnalytics'])->name('dashboard-analytics');
  Route::get('ecommerce', [DashboardController::class,'dashboardEcommerce'])->name('dashboard-ecommerce');
});


});

Route::get('/error', [MiscellaneousController::class,'error'])->name('error');
// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
