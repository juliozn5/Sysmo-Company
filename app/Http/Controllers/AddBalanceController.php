<?php

namespace App\Http\Controllers;

use App\Models\AddBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Charge as Charge2;
use Illuminate\Support\Facades\DB;


class AddBalanceController extends Controller
{
    //

    public function index()
    {
        try {
            // title
            View::share('titleg', 'Añadir Balance');

            return view('addbalance.index');
        } catch (\Throwable $th) {
            dd($th);
        }
    }


    /**
     * Permite procesar las compras realizadas por stripe
     *
     * @param Resquest $resquest
     * @return void
     */
    // function stripe(Request $request)
    // {
    //     try {
            
    //         $orden = [
    //             'iduser' => Auth::id(),
    //             'balance' => $request->balance,
    //             'metodo_pago' => 'Stripe',
    //             'fecha_creacion' => Carbon::now()
    //         ];

    //         $idorden = $this->saveAddBalance($orden);

    //         $secret_key = env('STRIPE_SECRET');
    //         Stripe::setApiKey($secret_key);

    //         $customer = Customer::create(array(
    //             'email' => $request->stripeEmail,
    //             'source'  => $request->stripeToken
    //         ));

    //         $charge = Charge::create(array(
    //             'customer' => $customer->id,
    //             'amount'   => ($request->total * 100),
    //             'currency' => 'usd'
    //         ));

    //         AddBalance::where('id', $idorden)->update([
    //             'id_transacion' => $request->stripeToken,
    //             'fecha_procesado' => Carbon::now(),
    //             'estado' => 1
    //         ]);

    //         // $fee = ($request->balance * 0.10);
    //         $balance = $request->balance;
    //         $balanceAcumulado = (AddBalance::find($idorden)->getUser->balance + $balance);
    //         AddBalance::find($idorden)->getUser->update(['balance' => $balanceAcumulado]);

    //         return redirect()->back()->with('msj-success', 'Balance Agregado con exito');

    //     } catch (\Throwable $th) {
    //         dd($th);
    //     }
    // }

    /**
     * Permite genera la order para poder procesar la compras
     *
     * @param Request $resquest
     * @return string
     */
    public function generate_orden_payu(Request $request): string
    {
        try {
            
            $orden = [
                'iduser' => Auth::id(),
                'balance' => $request->balance,
                'metodo_pago' => 'Payu',
                'fecha_creacion' => Carbon::now()
            ];

            $idorden = $this->saveAddBalance($orden);
            $payuReference = 'Payu-'.$idorden;
            $signature = env('PAYU_API_KEY').'~'.env('PAYU_MERCHANT_ID').'~'.$payuReference.'~'.$request->total.'~COP';
            $data = [
                'idorden' => $payuReference,
                'signature' => md5($signature)
            ];

            return json_encode($data);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Permite obtener la repuesta generada por la pasarela de pago payu
     *
     * @param Request $request
     * @param string $orden
     * @return void
     */
    public function response_orden_payu(Request $request, $orden)
    {
        $orden = base64_decode($orden);
        $tmpOrden = explode('-', $orden);
        $idorden = $tmpOrden[1];

        AddBalance::where('id', $idorden)->update([
            'id_transacion' => $request->transactionId,
        ]);

        $ApiKey = env('PAYU_API_KEY');
        $merchant_id = $request->merchantId;
        $referenceCode = $request->referenceCode;
        $TX_VALUE = $request->TX_VALUE;
        $New_value = number_format($TX_VALUE, 1, '.', '');
        $currency = $request->currency;
        $transactionState = $request->transactionState;
        $firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
        $firmacreada = md5($firma_cadena);
        $firma = $request->signature;
        $reference_pol = $request->reference_pol;
        $cus = $request->cus;
        $extra1 = $request->description;
        $pseBank = $request->pseBank;
        $lapPaymentMethod = $request->lapPaymentMethod;
        $transactionId = $request->transactionId;

        if ($request->transactionState == 4 ) {
            $estadoTx = "Transacción aprobada";
        }

        else if ($request->transactionState == 6 ) {
            $estadoTx = "Transacción rechazada";
        }

        else if ($request->transactionState == 104 ) {
            $estadoTx = "Error";
        }

        else if ($request->transactionState == 7 ) {
            $estadoTx = "Transacción pendiente";
        }

        else {
            $estadoTx= $request->mensaje;
        }

        $resumen = '';
        if (strtoupper($firma) == strtoupper($firmacreada)) {
            $resumen = "<h2 class='text-center'>Resumen Transacción</h2>
            <table class='table table-striped mb-0'>
            <tr class='text-center'>
            <td>Estado de la transaccion</td>
            <td>".$estadoTx."</td>
            </tr>
            <tr class='text-center'>
            <tr class='text-center'>
            <td>ID de la transaccion</td>
            <td>".$transactionId."</td>
            </tr>
            <tr class='text-center'>
            <td>Referencia de la venta</td>
            <td>".$reference_pol."</td>
            </tr>
            <tr class='text-center'>
            <td>Referencia de la transaccion</td>
            <td>".$referenceCode."</td>
            </tr>
            <tr class='text-center'>";
            if($pseBank != null) {
                $resumen = $resumen."<tr class='text-center'>
                <td>cus </td>
                <td>".$cus."</td>
                </tr>
                <tr class='text-center'>
                <td>Banco </td>
                <td>".$pseBank."</td>
                </tr>";
            }
            $resumen = $resumen."<tr class='text-center'>
            <td>Valor total</td>
            <td>".number_format($TX_VALUE)."</td>
            </tr>
            <tr class='text-center'>
            <td>Moneda</td>
            <td>".$currency."</td>
            </tr>
            <tr class='text-center'>
            <td>Descripción</td>
            <td>(".$extra1.")</td>
            </tr>
            <tr class='text-center'>
            <td>Entidad:</td>
            <td>(".$lapPaymentMethod.")</td>
            </tr>
            </table>";
        }else{
            $resumen = "<h1>Error validando firma digital.</h1>";
        }

        Session::flash('msj-info', 'En espera de confirmacion');
        return redirect()->route('addbalance.index')->with('resumen', $resumen);
    }

    /**
     * Confirma el estado de la compra procesada
     *
     * @param Request $request
     * @param string $orden
     * @return void
     */
    public function confimation_orden_payu(Request $request, $orden)
    {
        try {
            $orden = base64_decode($orden);
            $tmpOrden = explode('-', $orden);
            $idorden = $tmpOrden[1];
            $estado = 1;
            if ($request->state_pol > 4) {
                $estado = 2;
            }

            AddBalance::where('id', $idorden)->update([
                'id_transacion' => $request->transactionId,
                'fecha_procesado' => Carbon::now(),
                'estado' => $estado
            ]);

            // $fee = ($request->value * 0.10);
            $balance = AddBalance::find($idorden)->balance;

            $balanceAcumulado = (AddBalance::find($idorden)->getUser->balance + $balance);
            AddBalance::find($idorden)->getUser->update(['balance' => $balanceAcumulado]);
        } catch (\Throwable $th) {
            Log::error("Confirmacion Payu -->".$th);
        }
    }


    /**
     * Permite general la ordenes con coinbase
     *
     * @param Request $request
     * @return void
     */
    // public function generate_orden_coinbase(Request $request)
    // {
    //     try {
    //         $orden = [
    //             'iduser' => Auth::id(),
    //             'balance' => $request->balance,
    //             'metodo_pago' => 'Coinbase',
    //             'fecha_creacion' => Carbon::now()
    //         ];

    //         $apiKey = env('COINBASE_API_KEY');
    //         ApiClient::init($apiKey);

    //         $idorden = $this->saveAddBalance($orden);

    //         $chargerData = [
    //                 'description' => 'Monto de recarga '.$request->balance,
    //                 'metadata' => [
    //                     'balance' => $request->balance,
    //                     'orden' => $idorden
    //                 ],
    //                 'pricing_type' => 'fixed_price',
    //                 'redirect_url' => route('addbalance.coinbase.status', ['pendiente']),
    //                 'cancel_url' => route('addbalance.coinbase.status', ['cancelada']),
    //                 'local_price' => [
    //                     'amount' => $request->total,
    //                     'currency' => 'USD'
    //                 ],
    //                 'name' => 'Recarga de Balance',
    //                 'payments' => [],
    //             ];

    //         $chargerObj = Charge2::create($chargerData);

    //         AddBalance::where('id', $idorden)->update([
    //             'id_transacion' => $chargerObj->code,
    //         ]);

    //         return redirect($chargerObj->hosted_url);

    //     } catch (\Throwable $th) {
    //         dd($th);
    //     }
    // }

    /**
     * Permite saber si la transacion fue cancelada o esta en espera de aprobacion
     *
     * @param string $status
     * @return void
     */
    public function status_coinbase($status)
    {
        $concepto = "La transaccion esta ".$status;
        $tipo = ($status == 'pendiente') ? 'msj-success' : 'msj-warning';
        return redirect()->route('addbalance.index')->with($tipo, $concepto);
    }



    /**
     * Permite guardar la orden de compra de balance
     *
     * @param array $data
     * @return integer
     */
    public function saveAddBalance($data) : int
    {
        $balance = AddBalance::create($data);

        return $balance->id;
    }

    /**
     * Permite agregar obtener el balance por meses 
     *
     * @param integer $iduser
     * @return array
     */
    public function getDataGraphicBalance($iduser): array
    {
        try {
            $valorBalance = [];
            if (Auth::user()->admin == 1) {
                $balances = AddBalance::select(DB::raw('SUM(balance) as balance'))
                                ->where([
                                    ['estado', '>=', 0],
                                ])
                                ->groupBy(DB::raw('YEAR(fecha_creacion)'), DB::raw('MONTH(fecha_creacion)'))
                                ->orderBy(DB::raw('YEAR(fecha_creacion)'), 'ASC')
                                ->orderBy(DB::raw('MONTH(fecha_creacion)'), 'ASC')
                                ->take(6)
                                ->get();
            }else{
                $balances = AddBalance::select(DB::raw('SUM(balance) as balance'))
                                ->where([
                                    ['iduser', '=', $iduser],
                                    ['estado', '>=', 0],
                                ])
                                ->groupBy(DB::raw('YEAR(fecha_creacion)'), DB::raw('MONTH(fecha_creacion)'))
                                ->orderBy(DB::raw('YEAR(fecha_creacion)'), 'ASC')
                                ->orderBy(DB::raw('MONTH(fecha_creacion)'), 'ASC')
                                ->take(6)
                                ->get();
            }
            foreach ($balances as $balance) {
                $valorBalance [] = $balance->balance;
            }
            return $valorBalance;
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
