<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{

    protected $table = "orders";

    protected $fillable = [
        'user_id','product_id', 'amount','status'
    ];
  
    public function getUser(){
        return $this->belongsTo('App\Models\User','user_id', 'id');
    }

    public function getProduct(){
        return $this->belongsTo('App\Models\ProductWarehouse','product_id', 'id');
    }
}
