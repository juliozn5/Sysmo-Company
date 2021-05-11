<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('referred_id')->unsigned()->nullable();
            $table->bigInteger('orden_id')->unsigned()->nullable();;
            $table->bigInteger('liquidation_id')->unsigned()->nullable();
            $table->decimal('debit')->default(0)->comment('entrada de cash');
            $table->decimal('credit')->default(0)->comment('salida de cash');
            $table->decimal('balance')->nullable()->comment('balance del cash');
            $table->string('description');
            $table->tinyInteger('status')->default(0)->comment('0 - En espera, 1 - Pagado (liquidado), 2 - Cancelado');
            $table->tinyInteger('type_transaction')->default(0)->comment('0 - comision, 1 - retiro');
            $table->tinyInteger('liquidated')->default(0)->comment('0 - sin liquidar, 1 - liquidado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}
