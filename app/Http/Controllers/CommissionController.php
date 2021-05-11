<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Wallet;
use App\Models\AddBalance;

class CommissionController extends Controller
{
   
    public function indexCommissions(){
        
        $wallet = Wallet::all();

        return view('content.commissions.index')->with('wallet', $wallet);
    }

    public function indexRequest(){
        $balance = AddBalance::all();

        return view('content.commissions.request')->with('balance', $balance);
    }

}