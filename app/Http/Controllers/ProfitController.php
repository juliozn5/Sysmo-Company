<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\Liquidaction;
use App\Models\ProductWarehouse;
use Illuminate\Http\Request;
class ProfitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        $order = Order::all();
        $liquidaction = Liquidaction::all();
        $product_warehouse = ProductWarehouse::all();

// dd($product_warehouse);

        $profit = Wallet::with('id_user')
        ->with('users')
        ->leftJoin('bank_accounts', 'transactions.bank_account_id', '=', 'bank_accounts.id')
        ->leftJoin('users', 'transactions.user_id', '=', 'users.id')
        ->leftJoin('user_payments', 'user_payments.operation_code', '=', 'transactions.operation_code')
        ->leftJoin('orders', 'orders.code_operation', '=', 'transactions.operation_code')
        ->leftJoin('order_category', 'order_category.order_id', '=', 'orders.id')
        ->leftJoin('categories', 'categories.id', '=', 'order_category.category_id')
        ->select(
            'transactions.id as id_transactions', 
            'bank_account_id', 
            'orders.bs_monitor as orders_bs_monitor',
            'orders.created_at as orders_created',
            'orders.updated_at as orders_updated',
        )->orderby('transactions.id','DESC');

        return view('content.profit.index');

    }


    // $codes = Code::select(
    //         'operation_code',
    //         'codes.uid_discord',
    //         'type_currency_buy',
    //         'already_paid',
    //         'category'
    //     )
    //     ->with('user')
    //     ->selectRaw('DATE(codes.created_at) as created_at')
    //     ->selectRaw('ROUND(SUM(price),2) as price')
    //     ->selectRaw('ROUND(SUM(amount_to_buy),2) as amount_to_buy')
    //     ->selectRaw('count(operation_code) as count_code')
    //     ->selectRaw('b.name_discord as admin_pay')
    //     ->leftJoin('users as b', 'b.uid_discord', '=', 'codes.admin_id_pay' )
    //     ->distinct('operation_code')->groupby(
    //         'created_at',
    //         'operation_code',
    //         'codes.uid_discord',
    //         'admin_id_pay',
    //         'admin_pay'
    //     )->orderBy('created_at','desc');




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
