<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddBalance extends Model
{
    protected $table = 'add_balance';

    protected $fillable = [
        'user_id', 'balance', 'payment_method', 'id_transacion', 'status'
    ];

    /**
     * Permite obtener la informacion de un usuario asociado a una orden de saldo
     *
     * @return void
     */
    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
