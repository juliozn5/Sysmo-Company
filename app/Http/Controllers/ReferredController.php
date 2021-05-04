<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ReferredController extends Controller
{

    // obtiene los referidos directos del usuario logueado
    public function listDirect(){

        $referred_direct = User::where('referred_id', '=', Auth::user()->id)
                                ->select('id', 'email', 'created_at', 'status')
                                ->orderBy('id', 'DESC')
                                ->get();

        return view('content.referred.referred-direct')->with('referred_direct', $referred_direct);

    }

    // obtiene los referidos en red del usuario logueado
    public function listNet(){
        
        $referred_net = $this->getReferrals(Auth::user()->id, [], 1);

        return view('content.referred.referred-net')->with('referred_net', $referred_net);
    }

    public function getReferrals($user, $referrals, $level){

    	if (empty($referrals)){
    		$referrals = collect();
    	}

    	if ($level < 10){
    		$referidos = User::select('id', 'email', 'created_at', 'status')
    					->where('referred_id', '=', $user)
    					->get();

	    	foreach ($referidos as $referido){
	    		$referido->level = $level;
	    		$referrals->push($referido);
	    		$this->getReferrals($referido->id, $referrals, $level+1);
	    	}
    	}
    	
    	return $referrals;
    }

















    protected $position;

    /**
     * Lleva a la vista de arbol o matriz
     *
     * @param string $type
     * @return void
     */
    public function index($type)
    {
        try {
            //Titulo
            View::share('titleg', 'Arbol');
            $trees = $this->getDataEstructura(Auth::id(), $type);
            $type = ucfirst($type);
            $base = Auth::user();
            $base->logoarbol = asset('images/logo/logoarbol.png');
            return view('content.referred.tree.tree', compact('trees', 'type', 'base'));
        } catch (\Throwable $th) {
            dd($th);
        }
    }



    /**
     * Permite obtener la informacion para el arbol o matris
     *
     * @param integer $id - id del usuario a obtener sus hijos
     * @param string $type - tipo de estructura a general
     * @return void
     */
    private function getDataEstructura($id, $type)
    {
        try {
            $genealogyType = [
                'tree' => 'referred_id',
                'matriz' => 'position_id',
                'alterno' => 'alternativo_id'
            ];
            $childres = $this->getData($id, 1, $genealogyType[$type]);
            $trees = $this->getChildren($childres, 2, $genealogyType[$type]);
            return $trees;
        } catch (\Throwable $th) {
            dd($th);
        }
    } 

    /**
     * Lleva a la vista de arbol o matriz de un usuario hijo
     *
     * @param string $type
     * @param string $id
     * @return void
     */
    public function moretree($type, $id)
    {
        try {
            // titulo
            View::share('titleg', 'Arbol');
            $id = base64_decode($id);
            $trees = $this->getDataEstructura($id, $type);
            $type = ucfirst($type);
            $base = User::find($id);
            $base->logoarbol = asset('images/logo/logoarbol.png');
            return view('genealogy.tree', compact('trees', 'type', 'base'));
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Permite obtener a todos mis hijos y los hijos de mis hijos
     *
     * @param array $users - arreglo de usuarios
     * @param integer $nivel - el nivel en el que esta parado
     * @param string $typeTree - el tipo de arbol a usar
     * @return void
     */
    public function getChildren($users, $nivel, $typeTree)
    {
        try {
            if (!empty($users)) {
                foreach ($users as $user) {
                    $user->children = $this->getData($user->id, $nivel, $typeTree);
                    $this->getChildren($user->children, ($nivel+1), $typeTree);
                }
                return $users;
            }else{
                return $users;
            }
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Se trare la informacion de los hijos 
     *
     * @param integer $id - id a buscar hijos
     * @param integer $nivel - nivel en que los hijos se encuentra
     * @param string $typeTree - tipo de arbol a usar
     * @return object
     */
    private function getData($id, $nivel, $typeTree)
    {
        try {
            $resul = User::where($typeTree, '=', $id)->get();
            foreach ($resul as $user) {
                $user->nivel = $nivel;
                $user->logoarbol = asset('images/logo/logoarbol.png');

            }
            return $resul;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    //    /**
    //  * Permite obtener la cantidad de usuarios tantos directos, como indirectos
    //  *
    //  * @param integer $iduser
    //  * @return array
    //  */
    // public function getTotalUser(int $iduser): array
    // {
    //     try {
    //         $directos = count($this->getChidrens2($iduser, [], 1, 'referred_id', 1));
    //         $indirectos = count($this->getChidrens2($iduser, [], 1, 'referred_id', 0));
    //         return [
    //             'directos' => $directos,
    //             'indirectos' => $indirectos
    //         ];
    //     } catch (\Throwable $th) {
    //         dd($th);
    //     }
    // }

    
    /**
     * Se trare la informacion de los hijos 
     *
     * @param integer $id - id a buscar hijos
     * @param integer $nivel - nivel en que los hijos se encuentra
     * @param string $typeTree - tipo de arbol a usar
     * @return object
     */
    private function getDataSponsor($id, $nivel, $typeTree) : object
    {
        $resul = User::where($typeTree, '=', $id)->get();
        foreach ($resul as $user) {
            $user->nivel = $nivel;
        }
        return $resul;
    }

    /**
     * Permite tener la informacion de los hijos como un listado
     *
     * @param integer $parent - id del padre
     * @param array $array_tree_user - arreglo con todos los usuarios
     * @param integer $nivel - nivel
     * @param string $typeTree - tipo de usuario
     * @param boolean $allNetwork - si solo se va a traer la informacion de los directos o todos mis hijos
     * @return void
     */
    public function getChidrens2($parent, $array_tree_user, $nivel, $typeTree, $allNetwork)
    {   
        try {
            if (!is_array($array_tree_user))
            $array_tree_user = [];
        
            $data = $this->getData($parent, $nivel, $typeTree);
            
            if (count($data) > 0) {
                if ($allNetwork == 1) {
                    foreach($data as $user){
                        if ($user->nivel == 1) {
                            $array_tree_user [] = $user;
                        }
                    }
                }else{
                    foreach($data as $user){
                        $array_tree_user [] = $user;
                        $array_tree_user = $this->getChidrens2($user->id, $array_tree_user, ($nivel+1), $typeTree, $allNetwork);
                    }
                }
            }
            return $array_tree_user;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Permite obtener a todos mis patrocinadores
     *
     * @param integer $child - id del hijo
     * @param array $array_tree_user - arreglo de patrocinadores
     * @param integer $nivel - nivel a buscar
     * @param string $typeTree - llave a buscar
     * @param string $keySponsor - llave para buscar el sponsor, position o referido
     * @return array
     */
    public function getSponsor($child, $array_tree_user, $nivel, $typeTree, $keySponsor): array
    {
        if (!is_array($array_tree_user))
        $array_tree_user = [];
    
        $data = $this->getDataSponsor($child, $nivel, $typeTree);
        
        if (count($data) > 0) {
            foreach($data as $user){
                $array_tree_user [] = $user;
                $array_tree_user = $this->getSponsor($user->$keySponsor, $array_tree_user, ($nivel+1), $typeTree, $keySponsor);
            }
        }
        return $array_tree_user;
    }


    
    /**
   * Obtiene un id de Posicionamiento Valido 
   *
   * @param integer $id - primer id a verificar
   * @param string $lado - lado donde se insertara el referido
   * @return int
   */
  public function getPosition(int $id, string $lado = '')
  {
        try {
            $resul = 0;
            $ids = $this->getIDs($id, $lado);
            $limiteFila = 2;
            if ($lado != '') {
                if ($lado == 'I') {
                    if (count($ids) == 0) {
                        $resul = $id;
                    }else{
                        $this->verificarOtraPosition($ids, $limiteFila, $lado);
                        $resul = $this->position;
                    }
                }elseif($lado == 'D'){
                    if (count($ids) == 0) {
                        $resul = $id;
                    }else{
                        $this->verificarOtraPosition($ids, $limiteFila, $lado);
                        $resul = $this->position;
                    }
                }
            }else{
                if (count($ids) == 0) {
                    $resul = $id;
                }else{
                    $this->verificarOtraPosition($ids, $limiteFila, $lado);
                    $resul = $this->position;
                }
            }
            return $resul;
        } catch (\Throwable $th) {
            dd($th);
        }
  }
  /**
   * Buscar Alternativas al los id Posicionamiento validos
   *
   * @param array $arregloID - arreglos de id a Verificar
   * @param int $limitePosicion - Cantdad de posiciones disponibles
   * @param string $lado - lado donde se insertara el referido
   */
  public function verificarOtraPosition($arregloID, $limitePosicion, $lado)
  {
        try {
            foreach ($arregloID as $item) {
                $ids = $this->getIDs($item['id'], $lado);
                if ($lado != '') {
                    if ($lado == 'I') {
                        if (count($ids) == 0) {
                            $this->position = $item['id'];
                            break;
                        }else{
                            $this->verificarOtraPosition($ids, $limitePosicion, $lado);
                        }
                    }elseif($lado == 'D'){
                        if (count($ids) == 0) {
                        $this->position = $item['id'];
                            break;
                        }else{
                            $this->verificarOtraPosition($ids, $limitePosicion, $lado);
                        }
                    }
                }else{
                    if (count($ids) == 0) {
                        $this->position = $item['id'];
                        break;
                    }else{
                        $this->verificarOtraPosition($ids, $limitePosicion, $lado);
                    }
                }
            }
        } catch (\Throwable $th) {
            dd($th);
        }
  }

}
