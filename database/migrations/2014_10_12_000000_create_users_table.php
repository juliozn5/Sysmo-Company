<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username')->unique();
            $table->string('whatsapp')->nullable();
            $table->string('email')->unique();
            //$table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', [0, 1])->default(0)->comment('0-Normal, 1-Admin');
            $table->double('range_id')->default(0);
            $table->enum('status', [0, 1])->default(0)->comment('0-inactivo, 1-activo');
            //$table->bigInteger('wallet_id')->default(0);
            $table->bigInteger('balance')->default(0);
            $table->bigInteger('referred_id')->default(1);
            $table->text('profile_photo_path')->nullable();
            //$table->foreignId('current_team_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
