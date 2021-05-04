<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControler;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\MiscellaneousController;

// Main Page Route
Route::get('/', [DashboardController::class,'dashboardAnalytics'])->name('dashboard-analytics')->middleware('verified');

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
  return view('dashboard');
})->name('dashboard');

Route::group(['middleware'=>['auth']], function() {

/* Route Dashboards */
Route::group(['prefix' => 'dashboard'], function () {

  Route::get('analytics-user', [DashboardController::class,'dashboardAnalyticsUser'])->name('dashboard-analytics');
  Route::get('analytics', [DashboardController::class,'dashboardAnalytics'])->name('dashboard-analytics')->middleware('auth', 'checkrole:1');
  Route::get('ecommerce', [DashboardController::class,'dashboardEcommerce'])->name('dashboard-ecommerce')->middleware('auth', 'checkrole:1');

});

Route::group(['prefix' => 'admin'], function () {

  Route::get('user-list', [UserControler::class,'list'])->name('user.list')->middleware('auth', 'checkrole:1');

});

Route::prefix('tickets')->group(function(){

  // Para el usuario
  Route::get('create', [TicketsController::class,'create'])->name('ticket.create');
  Route::post('store', [TicketsController::class,'store'])->name('ticket.store');
  Route::get('edit-user/{id}', [TicketsController::class,'editUser'])->name('ticket.edit-user');
  Route::patch('update-user/{id}', [TicketsController::class,'updateUser'])->name('ticket.update-user');
  Route::get('list-user', [TicketsController::class,'listUser'])->name('ticket.list-user');
  Route::get('show-user/{id}', [TicketsController::class,'showUser'])->name('ticket.show-user');
  // Para el Admin
  Route::get('edit-admin/{id}', [TicketsController::class,'editAdmin'])->name('ticket.edit-admin');
  Route::patch('update-admin/{id}', [TicketsController::class,'updateAdmin'])->name('ticket.update-admin');
  Route::get('list-admin', [TicketsController::class,'listAdmin'])->name('ticket.list-admin');
  Route::get('show-admin/{id}', [TicketsController::class,'showAdmin'])->name('ticket.show-admin');
  Route::delete('delete/{id}', [TicketsController::class,'destroy'])->name('ticket.destroy');

});

Route::group(['prefix' => 'inspect'], function () {
  // admin
  Route::post('/impersonate/{user}/start', [ImpersonateController::class,'start'])->name('impersonate.start')->middleware('auth', 'checkrole:1');
  // no admin
  Route::get('/impersonate/stop', [ImpersonateController::class,'stop'])->name('impersonate.stop');
 
 });

 
});

Route::group(['prefix' => 'error'], function () {

  Route::get('/error', [MiscellaneousController::class,'error'])->name('error');
  Route::get('403', [MiscellaneousController::class,'errorAuthorization'])->name('403');
 
 });

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
