<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogLiquidation extends Model
{
    //
    protected $table = 'log_liquidations';

    protected $fillable = [
        'id_liquidation', 'commentary', 'action'
    ];

    /**
     * Permite la informacion de la liquidacion asociada
     *
     * @return void
     */
    public function getLiquidation()
    {
        return $this->belongsTo('App\Models\Liquidaction', 'idliquidation', 'id');
    }
}
