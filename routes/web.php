<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\ReferredController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\MiscellaneousController;

// Main Page Route
Route::get('/', [DashboardController::class,'dashboardAnalytics'])->name('dashboard-analytics')->middleware('verified');

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
  return view('dashboard');
})->name('dashboard');

// rutas para usuarios logueados
Route::group(['middleware'=>['auth']], function() {

  // rutas para los usuarios normales
Route::group(['prefix' => 'user'], function () {

  // home user
  Route::group(['prefix' => 'dashboard'], function () {
    Route::get('analytics', [DashboardController::class,'dashboardAnalyticsUser'])->name('dashboard-analytics');
  });
 
  // referred user
  Route::group(['prefix' => 'referred'], function () {

    Route::get('tree/{type}', [ReferredController::class,'index'])->name('tree_type');
    Route::get('{type}/{id}', [ReferredController::class,'moretree'])->name('tree_type_id');

    Route::get('tree', [ReferredController::class,'index'])->name('referred.tree');
    Route::get('list-direct', [ReferredController::class,'listDirect'])->name('referred.list.direct');
    Route::get('list-net', [ReferredController::class,'listNet'])->name('referred.list.net');
  });

  // tickets user
  Route::prefix('tickets')->group(function(){
    Route::get('create', [TicketsController::class,'create'])->name('ticket.create');
    Route::post('store', [TicketsController::class,'store'])->name('ticket.store');
    Route::get('edit/{id}', [TicketsController::class,'editUser'])->name('ticket.edit-user');
    Route::patch('update/{id}', [TicketsController::class,'updateUser'])->name('ticket.update-user');
    Route::get('list', [TicketsController::class,'listUser'])->name('ticket.list-user');
    Route::get('show/{id}', [TicketsController::class,'showUser'])->name('ticket.show-user');
  });

  // impersonate user
  Route::group(['prefix' => 'inspect'], function () {
    Route::get('/impersonate/stop', [ImpersonateController::class,'stop'])->name('impersonate.stop');
   });

});

  // rutas para los usuarios admin
Route::group(['prefix' => 'admin'], function () {

  // home admin
  Route::group(['prefix' => 'dashboard'], function () {
    Route::get('analytics', [DashboardController::class,'dashboardAnalytics'])->name('dashboard-analytics')->middleware('auth', 'checkrole:1');
    Route::get('ecommerce', [DashboardController::class,'dashboardEcommerce'])->name('dashboard-ecommerce')->middleware('auth', 'checkrole:1');
  });
 
  // user admin
  Route::group(['prefix' => 'users'], function () {
    Route::get('user-list', [UserController::class,'list'])->name('user.list')->middleware('auth', 'checkrole:1');
   });

  // tickets admin
   Route::prefix('tickets')->group(function(){
    Route::get('edit-admin/{id}', [TicketsController::class,'editAdmin'])->name('ticket.edit-admin');
    Route::patch('update-admin/{id}', [TicketsController::class,'updateAdmin'])->name('ticket.update-admin');
    Route::get('list-admin', [TicketsController::class,'listAdmin'])->name('ticket.list-admin');
    Route::get('show-admin/{id}', [TicketsController::class,'showAdmin'])->name('ticket.show-admin');
    Route::delete('delete/{id}', [TicketsController::class,'destroy'])->name('ticket.destroy');
  });

  // impersonate admin
  Route::group(['prefix' => 'inspect'], function () {
    Route::post('/impersonate/{user}/start', [ImpersonateController::class,'start'])->name('impersonate.start')->middleware('auth', 'checkrole:1');
   });

});

 
});




Route::group(['prefix' => 'error'], function () {

  Route::get('/error', [MiscellaneousController::class,'error'])->name('error');
  Route::get('403', [MiscellaneousController::class,'errorAuthorization'])->name('403');
 
 });

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
