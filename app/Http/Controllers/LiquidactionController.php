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
    public function indexPendings()
    {
        $liquidations = Liquidaction::where('status', 0)->get();
        foreach ($liquidations as $liqui) {
            $liqui->email = $liqui->getUserLiquidation->email;
        }
        return view('content.liquidation.pending')->with('liquidations', $liquidations);
    }

    /**
     * LLeva a la vistas de las liquidations reservadas o aprobadas
     * 
     * @param string $status
     * @return void
     */
    public function indexHistory()
    {
        $liquidations = Liquidaction::where('status', '1')->get();
        foreach ($liquidations as $liqui) {
            $liqui->email = $liqui->getUserLiquidation->email;
        }
        return view('content.liquidation.history')
        ->with('liquidations', $liquidations);
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
                'listCommissions' => ['required', 'array'],
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
                    $this->generateLiquidation($request->user_id, $request->listCommissions);
                }else{
                    foreach ($request->listUsers as $user_id) {
                        $this->generateLiquidation($user_id, []);
                    }
                }
                return redirect()->back()->with('message', 'Liquidaciones Generada Exitoxamente');
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
            'liquidation_id' => $id,
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
    public function generateLiquidation(int $user_id, array $listComision)
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
            $liquidation_id = $this->saveLiquidation($arrayLiquidation);

            $concept = 'Liquidacion del usuario '.$user->username.' por un monto de '.$crude;
            $arrayWallet =[
                'user_id' => $user->id,
                'referred_id' => $user->id,
                'credit' => $crude,
                'description' => $concept,
                'status' => 0,
                'type_transaction' => 1,
            ];

            $this->walletController->saveWallet($arrayWallet);
            
            if (!empty($liquidation_id)) {
                $listComi = $commissions->pluck('id');
                Wallet::whereIn('id', $listComi)->update([
                    'status' => 1,
                    'liquidation_id' => $liquidation_id
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
                'commentary' => ['required'],
            ]);
        }
        try {
            if ($validate) {

                $liquidation_id = $request->liquidation_id;
                $accion = 'No Procesada';

                if ($request->action == 'reverse') {
                    $accion = 'Reversada';
                    $this->reversarLiquidacion($liquidation_id, $request->commentary);
                }elseif ($request->action == 'aproved') {
                    $accion = 'Aprobada';
                    $this->ApproveLiquidation($liquidation_id, $request->hash);
                }
                if ($accion != 'No Procesada') {
                    $arrayLog = [
                        'liquidation_id' => $liquidation_id,
                        'commentary' => $request->commentary,
                        'action' => $accion
                    ];
                    DB::table('log_liquidations')->insert($arrayLog);
                }


            }
        } catch (\Throwable $th) {
            Log::error('Funcion ProcessLiquidation -> '.$th);
        }

        return redirect()->back()->with('message', 'La Liquidacion fue '.$accion.' con exito');


    }

    /**
     * Permite aprobar las liquidations
     *
     * @param integer $liquidation_id
     * @param string $hash
     * @return void
     */
    public function ApproveLiquidation($liquidation_id, $hash)
    {
        Liquidaction::where('id', $liquidation_id)->update([
            'status' => 1,
            'hash' => $hash
        ]);

        Wallet::where('liquidation_id', $liquidation_id)->update(['liquidado' => 1]);
    }

    /**
     * Permite procesar reversiones del sistema
     *
     * @param integer $liquidation_id
     * @param string $commentary
     * @return void
     */
    public function reversarLiquidacion($liquidation_id, $commentary)
    {
        $liquidation = Liquidaction::find($liquidation_id);
        
        Wallet::where('liquidation_id', $liquidation_id)->update([
            'status' => 0,
            'liquidation_id' => null,
        ]);

        $concept = 'Liquidacion Reservada - Motivo: '.$commentary;
        $arrayWallet =[
            'user_id' => $liquidation->user_id,
            'orden_id' => null,
            'referred_id' => $liquidation->user_id,
            'debit' => $liquidation->gross_amount,
            'description' => $concept,
            'status' => 1,
            'type_transaction' => 0,
        ];

        $this->walletController->saveWallet($arrayWallet);

        $liquidation->status = 2;
        $liquidation->save();
    }
}
