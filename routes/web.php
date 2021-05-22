<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RangeController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\ReferredController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\LiquidactionController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\ProductWarehouseController;

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
    Route::get('/', [DashboardController::class,'dashboardAnalyticsUser'])->name('dashboard-analytics-user');
  });
 
   // store user
   Route::prefix('store')->group(function(){
    Route::get('store', [ProductWarehouseController::class,'index'])->name('store.index');
    Route::post('store/save', [ProductWarehouseController::class,'saveOrden'])->name('store.save');
    Route::get('list-user', [ProductWarehouseController::class,'listUser'])->name('store.list-user');
    Route::get('show/{id}', [ProductWarehouseController::class,'showUser'])->name('store.show');
  });

  // Ruta para agregar saldo
  // Route::prefix('addsaldo')->group(function ()
  // {
  //     Route::get('/', 'AddBalanceController@index')->name('addsaldo.index');
  //     // Rutas para el pago stripe
  //     Route::post('/stripe', 'AddBalanceController@stripe')->name('addsaldo.stripe');
  //     // Rutas para el pago payulatam
  //     Route::prefix('payu')->group(function ()
  //     {
  //        Route::post('/generate_orden', 'AddBalanceController@generate_orden_payu')->name('addsaldo.payu.generate');
  //        Route::get('/{orden}/response_orden', 'AddBalanceController@response_orden_payu')->name('addsaldo.payu.response');
  //        Route::post('/{orden}/confirmation_orden', 'AddBalanceController@confimation_orden_payu')->name('addsaldo.payu.confirmation');
  //     });
  //     // Rutas para el Coinbase
  //     Route::post('/coinbase', 'AddBalanceController@generate_orden_coinbase')->name('addsaldo.coinbase');
  //     Route::get('{status}/status_coinbase', 'AddBalanceController@status_coinbase')->name('addsaldo.coinbase.status');
  // });


  Route::prefix('wallet')->group(function ()
  {
    Route::get('index', [WalletController::class,'index'])->name('wallet.index');
  });

  // referred user
  Route::group(['prefix' => 'referred'], function () {

    Route::get('tree/{type}', [ReferredController::class,'index'])->name('tree_type');
    Route::get('{type}/{id}', [ReferredController::class,'moretree'])->name('tree_type_id');
    
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
    Route::get('/', [DashboardController::class,'dashboardAnalytics'])->name('dashboard-analytics')->middleware('auth', 'checkrole:1');
    Route::get('ecommerce', [DashboardController::class,'dashboardEcommerce'])->name('dashboard-ecommerce')->middleware('auth', 'checkrole:1');
  });
 
    // store admin
    Route::prefix('store')->group(function(){
      Route::get('create', [ProductWarehouseController::class,'create'])->name('store.create');
      Route::post('store', [ProductWarehouseController::class,'store'])->name('store');
      Route::get('edit-admin/{id}', [ProductWarehouseController::class,'editAdmin'])->name('store.edit');
      Route::patch('update-admin/{id}', [ProductWarehouseController::class,'updateAdmin'])->name('store.update');
      Route::get('list-admin', [ProductWarehouseController::class,'listAdmin'])->name('store.list-admin');
      Route::get('list-orders', [ProductWarehouseController::class,'orders'])->name('store.list-orders');
      Route::get('attend-order/{id}', [ProductWarehouseController::class,'orderAttend'])->name('store.attend');
      Route::patch('update-order/{id}', [ProductWarehouseController::class,'updateOrder'])->name('store.order');
      Route::delete('delete/{id}', [ProductWarehouseController::class,'destroy'])->name('store.destroy');
    });
    
  // user admin
  Route::group(['prefix' => 'users'], function () {
    Route::get('user-list', [UserController::class,'list'])->name('user.list')->middleware('auth', 'checkrole:1');
    Route::get('user-edit/{id}', [UserController::class,'editUser'])->name('user.edit')->middleware('auth', 'checkrole:1');
    Route::patch('user-edit/{id}', [UserController::class,'updateUser'])->name('user.update')->middleware('auth', 'checkrole:1');
   });

   Route::group(['prefix' => 'range'], function () {
    Route::get('index', [RangeController::class,'index'])->name('range.index');
   });

   Route::group(['prefix' => 'profit'], function () {
    Route::get('index', [ProfitController::class,'index'])->name('profit.index');
   });

  Route::prefix('commissions')->group(function ()
  {
    Route::get('index', [CommissionController::class,'indexCommissions'])->name('commission.index');
    Route::get('request', [CommissionController::class,'indexRequest'])->name('commissions.request');
  });

  Route::prefix('liquidaction')->group(function() 
  {
      //Ruta liquidaciones realizadas
    Route::get('index', [LiquidactionController::class,'index'])->name('liquidaction.index');
    Route::get('pending', [LiquidactionController::class,'indexPendings'])->name('liquidaction.pending');
    Route::post('process', [LiquidactionController::class,'ProcessLiquidation'])->name('liquidaction.process');
    Route::get('history', [LiquidactionController::class,'indexHistory'])->name('liquidaction.history.status');
    Route::get('edit/{id}', [LiquidactionController::class,'edit'])->name('liquidaction.edit');
    Route::get('show/{id}', [LiquidactionController::class,'show'])->name('liquidaction.show');
    Route::post('store', [LiquidactionController::class,'store'])->name('liquidaction.store');
 
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
