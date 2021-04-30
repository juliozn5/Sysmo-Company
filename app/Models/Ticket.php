<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $dates = ['created_at','updated_at'];

    protected $fillable = [
        'user_id', 'whatsapp', 'email', 'issue', 'description', 'status'
    ];

    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}