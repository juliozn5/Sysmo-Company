<?php

namespace App\Http\Controllers;

use App\Models\AddBalance;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReferredController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class WalletController extends Controller
{
    //

    public $referredController;

    public function __construct()
    {
        $this->referredController = new ReferredController;
        View::share('titleq', 'Billetera');
    }

    /**
     * Lleva a la vista de la billetera
     *
     * @return void
     */
    public function index()
    {
        $this->payComision();
        // dd('parar');
        if (Auth::user()->role == 1) {
            $wallets = Wallet::all();
        }else{
            $wallets = Auth::user()->getWallet;
        }
        return view('content.wallet.index')->with('wallets', $wallets);
    }

    /**
     * Permite pagar las comisiones de los usuarios
     *
     * @return void
     */
    public function payComision()
    {
        try {
            $saldos = $this->getSaldos();
            foreach ($saldos as $balance) {
                $sponsors = $this->referredController->getSponsor($balance->user_id, [], 0, 'id', 'referred_id');
                // dd($sponsors);
                if (!empty($sponsors)) {
                    foreach ($sponsors as $sponsor) {
                        if ($sponsor->id != $balance->user_id) {
                            if ($sponsor->nivel <= 5) {
                                $pocentaje = $this->getPorcentage($sponsor->nivel);
                                $monto = $this->recalcularMonto($balance->balance, $balance->metodo_pago);
                                $comision = ($monto * $pocentaje);
                                $concepto = 'Comision del usuario '.$balance->getUser->fullname.' por un monto de '.$balance->balance;
                                $data = [
                                    'user_id' => $sponsor->id,
                                    'referred_id' => $balance->user_id,
                                    'orden_id' => $balance->id,
                                    'debit' => $comision,
                                    'description' => $concepto,
                                    'status' => 0,
                                    'type_transaction' => 0,
                                ];
                                $this->saveWallet($data);
                            }
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            Log::error('Funcion payComisiones -> '.$th);
            return redirect()->back()->with('msj', 'Ocurrio un error, Por favor comunicarse con el administrador');
        }
    }

    /**
     * Permite obtener el porcentaje a pagar
     *
     * @param integer $nivel
     * @return float
     */
    public function getPorcentage(int $nivel): float
    {
        $nivelPorcentaje = [
            1 => 0.20, 2 => 0.10, 3 => 0.05, 4 => 0.02, 5 => 0.03
        ];

        return $nivelPorcentaje[$nivel];
    }

    /**
     * Permite Recalcular el monto a pagar por el tipo de medio que recargo
     *
     * @param float $monto
     * @param string $tipo_pago
     * @return float
     */
    public function recalcularMonto(float $monto, string $tipo_pago):float
    {
        $arrayMetodo = [
            'payulatam' => 1.10, 'manual' => 1.00, 'stripe' => 1.10, 'coinbase' => 1.02
        ];
        
        $resultado = ($monto / $arrayMetodo[strtolower($tipo_pago)]);
        return $resultado;
    }

    /**
     * Permite obtener las compras de balance de los ultimos 30 dias
     *
     * @param integer $user_id
     * @return object
     */
    public function getSaldos($user_id = null): object
    {
        try {
            $fecha = Carbon::now();
            if ($user_id == null) {
                $saldos = AddBalance::where([
                    ['status', '=', 1]
                ])->whereDate('created_at', '>=', $fecha->subDay(10))->get();
            }else{
                $saldos = AddBalance::where([
                    ['user_id', '=', $user_id],
                    ['status', '=', 1]
                ])->whereDate('created_at', '>=', $fecha->subDay(10))->get();
            }
            return $saldos;
        } catch (\Throwable $th) {
           // return redirect()->back()->with('msj', 'Ocurrio un error, Por favor comunicarse con el administrador');
           Log::error('Funcion getSaldo -> '.$th);
        }
    }

    /**
     * Permite guardar la informacion de la wallet
     *
     * @param array $data
     * @return void
     */    
    public function saveWallet($data)
    {
        try {
            if ($data['tipo_transaction'] == 1) {
                $wallet = Wallet::create($data);
                $saldoAcumulado = ($wallet->getWalletUser->wallet - $data['credito']);
                $wallet->getWalletUser->update(['wallet' => $saldoAcumulado]);
                $wallet->update(['balance' => $saldoAcumulado]);
            }else{
                if ($data['orden_id'] != null) {
                    $check = Wallet::where([
                        ['user_id', '=', $data['user_id']],
                        ['orden_id', '=', $data['orden_id']]
                    ])->first();
                    if ($check == null) {
                        $wallet = Wallet::create($data);
                    }
                }else{
                    $wallet = Wallet::create($data);
                }
                $saldoAcumulado = ($wallet->getWalletUser->wallet + $data['debito']);
                $wallet->getWalletUser->update(['wallet' => $saldoAcumulado]);
                $wallet->update(['balance' => $saldoAcumulado]);
            }
        } catch (\Throwable $th) {
            // return redirect()->back()->with('msj', 'Ocurrio un error, Por favor comunicarse con el administrador');
            Log::error('Funcion saveWallet -> '.$th);
        }
    }

    /**
     * Permite obtener el total disponible en comisiones
     *
     * @param integer $user_id
     * @return float
     */
    public function getTotalComision($user_id): float
    {
        try {
            $wallet = Wallet::where([['user_id', '=', $user_id], ['status', '=', 0]])->get()->sum('debito');
            if ($user_id == 1) {
                $wallet = Wallet::where([['status', '=', 0]])->get()->sum('debito');
            }
            return $wallet;
        } catch (\Throwable $th) {
            // return redirect()->back()->with('msj', 'Ocurrio un error, Por favor comunicarse con el administrador');
            Log::error('Funcion getTotalComision -> '.$th);
        }
    }

    /**
     * Permite obtener el total de comisiones por meses
     *
     * @param integer $user_id
     * @return void
     */
    public function getDataGraphiComisiones($user_id)
    {
        try {
            $totalComision = [];
            if (Auth::user()->admin == 1) {
                $Comisiones = Wallet::select(DB::raw('SUM(debito) as Comision'))
                                ->where([
                                    ['status', '<=', 1]
                                ])
                                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                                ->orderBy(DB::raw('YEAR(created_at)'), 'ASC')
                                ->orderBy(DB::raw('MONTH(created_at)'), 'ASC')
                                ->take(6)
                                ->get();
            }else{
                $Comisiones = Wallet::select(DB::raw('SUM(debito) as Comision'))
                                ->where([
                                    ['user_id', '=',  $user_id],
                                    ['status', '<=', 1]
                                ])
                                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                                ->orderBy(DB::raw('YEAR(created_at)'), 'ASC')
                                ->orderBy(DB::raw('MONTH(created_at)'), 'ASC')
                                ->take(6)
                                ->get();
            }
            foreach ($Comisiones as $comi) {
                $totalComision [] = $comi->Comision;
            }
            return $totalComision;
        } catch (\Throwable $th) {
            // return redirect()->back()->with('msj', 'Ocurrio un error, Por favor comunicarse con el administrador');
            Log::error('Funcion getDataGraphiComisiones -> '.$th);
        }
    }
}
