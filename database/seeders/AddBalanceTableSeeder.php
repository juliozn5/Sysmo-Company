<?php

use Illuminate\Database\Seeder;
// modelo
use App\Models\AddBalance;

class AddBalanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayAddBalance = [

                [
                  "id"=>"1",
                  "iduser"=>"1",
                  "saldo"=>"100",
                  "metodo_pago"=>"Skrill",
                  "id_transacion"=>"123",
                  "estado"=>"1",
                  "fecha_creacion"=>"2021-03-17",
                  "fecha_procesado"=>"2021-03-24",
                ],
                [
                  "id"=>"2",
                  "iduser"=>"1",
                  "saldo"=>"100",
                  "metodo_pago"=>"Stripe",
                  "id_transacion"=>"456",
                  "estado"=>"1",
                  "fecha_creacion"=>"2021-03-17",
                  "fecha_procesado"=>"2021-03-24",
                ],
                [
                  "id"=>"3",
                  "iduser"=>"1",
                  "saldo"=>"100",
                  "metodo_pago"=>"Payu",
                  "id_transacion"=>"789",
                  "estado"=>"1",
                  "fecha_creacion"=>"2021-03-17",
                  "fecha_procesado"=>"2021-03-24",
                ],
                [
                  "id"=>"4",
                  "iduser"=>"1",
                  "saldo"=>"100",
                  "metodo_pago"=>"Coinbase",
                  "id_transacion"=>"159",
                  "estado"=>"1",
                  "fecha_creacion"=>"2021-03-17",
                  "fecha_procesado"=>"2021-03-24",
                ]

    ];
    foreach ($arrayAddBalance as $addbalance ) {
        AddBalance::create($addbalance);
    }
    }
}
