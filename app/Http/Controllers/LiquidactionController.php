<?php

namespace App\Http\Controllers;

use App\Models\Liquidaction;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\WalletController;

class LiquidactionController extends Controller
{

    public $walletController;

    function __construct()
    {
        $this->walletController = new WalletController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commissions = $this->getTotalCommissions([], null);
        return view('content.liquidation.index')->with('commissions', $commissions);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPendientes()
    {
        $liquidations = Liquidaction::where('status', 0)->get();
        foreach ($liquidations as $liqui) {
            $liqui->username = $liqui->getUserLiquidation->username;
        }
        return view('content.liquidation.pending')->with('liquidations', $liquidations);
    }

    /**
     * LLeva a la vistas de las liquidations reservadas o aprobadas
     *
     * @param string $status
     * @return void
     */
    public function indexHistory($status)
    {
        $status = ($status == 'Reservadas') ? 2 : 1;
        $liquidations = Liquidaction::where('status', $status)->get();
        foreach ($liquidations as $liqui) {
            $liqui->username = $liqui->getUserLiquidation->username;
        }
        return view('content.liquidation.history')
        ->with('liquidations', $liquidations)
        ->with('status', $status);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->tipo = 'detallada') {
            $validate = $request->validate([
                'listComisiones' => ['required', 'array'],
                'user_id' => ['required']
            ]);
        }else{
            $validate = $request->validate([
                'listUsers' => ['required', 'array']
            ]);
        }

        try {
            if ($validate) {
                if ($request->tipo = 'detallada') {
                    $this->generarLiquidation($request->user_id, $request->listComisiones);
                }else{
                    foreach ($request->listUsers as $user_id) {
                        $this->generarLiquidation($user_id, []);
                    }
                }
                return redirect()->back()->with('msj-success', 'Liquidaciones Generada Exitoxamente');
            }
        } catch (\Throwable $th) {
            Log::error('Store LiquidactionController -> '.$th);
            dd($th);
        }



    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commissions = Wallet::where([
            ['status', '=', 0],
            ['liquidation_id', '=', null],
            ['type_transaction', '=', 0],
            ['user_id', '=', $id]
        ])->get();

        foreach ($commissions as $comi) {
            $date = new Carbon($comi->created_at);
            $comi->date = $date->format('Y-m-d');
            $comi->referred = User::find($comi->referred_id)->only('username');
        }
        
        $user = User::find($id);

        $details = [
            'user_id' => $id,
            'username' => $user->username,
            'commissions' => $commissions,
            'total' => number_format($commissions->sum('debit'), 2, ',', '.')
        ];

        return json_encode($details);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Liquidaction  $liquidaction
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $commissions = Wallet::where([
            ['liquidation_id', '=', $id],
        ])->get();

        foreach ($commissions as $comi) {
            $date = new Carbon($comi->created_at);
            $comi->date = $date->format('Y-m-d');
            $comi->referred = User::find($comi->referred_id)->only('username');
        }
        $user = User::find($commissions->pluck('user_id')[0]);

        $details = [
            'idliquidaction' => $id,
            'user_id' => $user->id,
            'username' => $user->username,
            'commissions' => $commissions,
            'total' => number_format($commissions->sum('debit'), 2, ',', '.')
        ];

        return json_encode($details);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Liquidaction  $liquidaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Liquidaction $liquidaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Liquidaction  $liquidaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Liquidaction $liquidaction)
    {
        //
    }

    /**
     * Permite Obtener la informacion de las commissions y el total disponible
     *
     * @param array $filters - filtro para mejorar la vistas
     * @param integer $user_id - si es para un usuario especifico
     * @return array
     */
    public function getTotalCommissions(array $filters, int $user_id = null): array
    {
        try {
            $commissions = [];
            if ($user_id != null && $user_id != 1) {
                $commissionstmp = Wallet::where([
                    ['status', '=', 0],
                    ['liquidation_id', '=', null],
                    ['type_transaction', '=', 0],
                    ['user_id', '=', $user_id]
                ])->select(
                    DB::raw('sum(debit) as total'), 'user_id'
                )->groupBy('user_id')->get();
            }else{
                $commissionstmp = Wallet::where([
                    ['status', '=', 0],
                    ['liquidation_id', '=', null],
                    ['type_transaction', '=', 0],
                ])->select(
                    DB::raw('sum(debit) as total'), 'user_id'
                )->groupBy('user_id')->get();
            }

            foreach ($commissionstmp as $commission) {
                $commission->getWalletUser;
                if ($commission->getWalletUser != null) {
                    if ($filters == []) {
                        $commissions[] = $commission;
                    }else{
                        if (!empty($filters['activo'])) {
                            if ($commission->status == 1) {
                                if (!empty($filters['mayorque'])) {
                                    if ($commission->total >= $filters['mayorque']) {
                                        $commissions[] = $commission;
                                    }
                                } else {
                                    $commissions[] = $commission;
                                }
                            }
                        }else{
                            if (!empty($filters['mayorque'])) {
                                if ($commission->total >= $filters['mayorque']) {
                                    $commissions[] = $commission;
                                }
                            } else {
                                $commissions[] = $commission;
                            }
                        }
                    }
                }
            }
            return $commissions;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Permite procesar las liquidations
     *
     * @param integer $user_id -  id del usuario
     * @param array $listComision - commissions a procesar si son selecionada
     * @return void
     */
    public function generarLiquidation(int $user_id, array $listComision)
    {
        try {
            $user = User::find($user_id);
            $commissions = collect();

            if ($listComision == []) {
                $commissions = Wallet::where([
                    ['user_id', '=', $user_id],
                    ['status', '=', 0],
                    ['type_transaction', '=', 0],
                ])->get();
            }else {
                $commissions = Wallet::whereIn('id', $listComision)->get();
            }

            $crude = $commissions->sum('debit');
            $feed = ($crude * 0);
            $total = ($crude - $feed);

            $arrayLiquidation = [
                'user_id' => $user_id,
                'total' => $total,
                'gross_amount' => $crude,
                'feed' => $feed,
                'hash',
                'wallet_used',
                'status' => 0,
            ];
            $idLiquidation = $this->saveLiquidation($arrayLiquidation);

            $concept = 'Liquidacion del usuario '.$user->username.' por un monto de '.$crude;
            $arrayWallet =[
                'user_id' => $user->id,
                'referred_id' => $user->id,
                'credito' => $crude,
                'descripcion' => $concept,
                'status' => 0,
                'type_transaction' => 1,
            ];

            $this->walletController->saveWallet($arrayWallet);
            
            if (!empty($idLiquidation)) {
                $listComi = $commissions->pluck('id');
                Wallet::whereIn('id', $listComi)->update([
                    'status' => 1,
                    'liquidation_id' => $idLiquidation
                ]);
            }
        } catch (\Throwable $th) {
            Log::error('Generar Liquidacion ->'.$th);
            dd($th);
        }
    }

    /**
     * Permite guardar las liquidations y devuelve el id de la misma
     *
     * @param array $data
     * @return integer
     */
    public function saveLiquidation(array $data): int
    {
        $liquidation = Liquidaction::create($data);
        return $liquidation->id;
    }

    /**
     * Permite elegir que opcion hacer con las liquidations
     *
     * @param Request $request
     * @return void
     */
    public function ProcessLiquidation(Request $request)
    {
        if ($request->action == 'aproved') {
            $validate = $request->validate([
                'hash' => ['required'],
            ]);
        }else{
            $validate = $request->validate([
                'comentario' => ['required'],
            ]);
        }
        try {
            if ($validate) {
                $idliquidation = $request->idliquidation;
                $accion = 'No Procesada';
                if ($request->action == 'reverse') {
                    $accion = 'Reversada';
                    $this->reversarLiquidacion($idliquidation, $request->comentario);
                }elseif ($request->action == 'aproved') {
                    $accion = 'Aprobada';
                    $this->ApproveLiquidation($idliquidation, $request->hash);
                }
    
                if ($accion != 'No Procesada') {
                    $arrayLog = [
                        'idliquidation' => $idliquidation,
                        'comentario' => $request->comentario,
                        'accion' => $accion
                    ];
                    DB::table('log_liquidations')->insert($arrayLog);
                }
                
                return redirect()->back()->with('msj-success', 'La Liquidacion fue '.$accion.' con exito');
            }
        } catch (\Throwable $th) {
            Log::error('Funcion ProcessLiquidation -> '.$th);
        }
    }

    /**
     * Permite aprobar las liquidations
     *
     * @param integer $idliquidation
     * @param string $hash
     * @return void
     */
    public function ApproveLiquidation($idliquidation, $hash)
    {
        Liquidaction::where('id', $idliquidation)->update([
            'status' => 1,
            'hash' => $hash
        ]);

        Wallet::where('liquidation_id', $idliquidation)->update(['liquidado' => 1]);
    }

    /**
     * Permite procesar reversiones del sistema
     *
     * @param integer $idliquidation
     * @param string $comentario
     * @return void
     */
    public function reversarLiquidacion($idliquidation, $comentario)
    {
        $liquidation = Liquidaction::find($idliquidation);
        
        Wallet::where('liquidation_id', $idliquidation)->update([
            'status' => 0,
            'liquidation_id' => null,
        ]);

        $concept = 'Liquidacion Reservada - Motivo: '.$comentario;
        $arrayWallet =[
            'user_id' => $liquidation->user_id,
            'orden_id' => null,
            'referred_id' => $liquidation->user_id,
            'debit' => $liquidation->gross_amount,
            'descripcion' => $concept,
            'status' => 1,
            'type_transaction' => 0,
        ];

        $this->walletController->saveWallet($arrayWallet);

        $liquidation->status = 2;
        $liquidation->save();
    }
}
