<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\ProductWarehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductWarehouseController extends Controller
{

     // permite ver la vista de la tienda

     public function index(){

        $store = ProductWarehouse::all();
        return view('content.store.user.index')->with('store', $store);
    
    }

     // permite ver la vista de la tienda
    public function orders(){

        $store = Order::all();
        return view('content.store.admin.orders')->with('store', $store);
    
    }

    // permite ver la vista de creacion delproducto

    public function create(){

        return view('content.store.admin.create');
    
    }

    // permite la creacion del producto

    public function store(Request $request){

        $store = ProductWarehouse::all();

        $fields = [        ];

        $msj = [        ];

        $this->validate($request, $fields, $msj);

        $store = ProductWarehouse::create($request->all());

        if ($request->hasFile('photoDB')) {
            
            $file = $request->file('photoDB');
            
            $name = $request->name.'_'.$file->getClientOriginalName();
            
            $file->move(public_path('storage').'/products',$name);
            
            $store->photoDB = $name;
        }

		$store->save();
        
        return redirect()->route('store.list-admin')->with('message', 'El Producto se creo Exitosamente');
    }

    // permite editar el producto

    public function editAdmin($id){

        $store = ProductWarehouse::find($id);

        return view('content.store.admin.edit')
        ->with('store', $store);
    }

     // permite editar el producto

     public function orderAttend($id){

        $store = Order::find($id);

        return view('content.store.admin.order-attend')
        ->with('store', $store);
    }

    public function updateOrder(Request $request, $id){

        $store = Order::find($id);

        $fields = [
     
        ];

        $msj = [
      
        ];
        
        $this->validate($request, $fields, $msj);

        $store->update($request->all());

        $store->save();
        
      return redirect()->route('store.list-orders')->with('message', 'Producto '.$id.' Actualizado ');
    }

    // permite actualizar el producto

    public function updateAdmin(Request $request, $id){

        $store = ProductWarehouse::find($id);

        $fields = [
            "name" => ['required'],
            "description" => ['required'],
            "price" => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es Requerido',
            'description.required' => 'La descripcion es Requerido',
            'price.required' => 'El monto es Requerido',
        ];
        
        $this->validate($request, $fields, $msj);

        $store->update($request->all());
        
        if ($request->hasFile('photoDB')) {
            
            $file = $request->file('photoDB');
            
            $name = $request->name.'_'.$file->getClientOriginalName();
            
            $file->move(public_path('storage').'/products',$name);
            
            $store->photoDB = $name;
        }

        $store->save();
        
      return redirect()->route('store.list-admin')->with('message', 'Producto '.$id.' Actualizado ');
    }

    // permite ver la lista de productos

    public function listAdmin(){
        
        $store = ProductWarehouse::all();
        
        return view('content.store.admin.list-admin')
        ->with('store', $store);
    }

    // permite eliminar un producto
    
    public function destroy($id)
    {
      $store = ProductWarehouse::find($id);
    
      $store->delete();
    
      return redirect()->route('store.list-admin')->with('message', 'Producto '.$id.' Eliminado');
    }

    // permite guardar la orden comprada
    public function saveOrden(Request $request)
    {
            $user = Auth::user();

            if($user->balance >= $request->price){

            $orden = Order::create([
                'user_id' => Auth::id(),
                'product_id' => $request->id,
                'amount' => '1',
            ]);

            $wallet = $user->balance - $request->price;
            $orden->getUser->update(['balance' => $wallet]);

            return redirect()->back()->with('message', 'Producto Comprado');
        }else{
            return redirect()->back()->with('error', 'Saldo Insuficiente');
        }
    }

    // permite ver la lista de producto
  
    public function listUser(){
  
      $store = Order::where('user_id', '=', Auth::id())->get();
  
      return view('content.store.user.list-user')
      ->with('store', $store);
    }
  
    // permite ver el producto
  
    public function showUser($id){
  
      $store = Order::find($id);
  
      return view('content.store.user.show')
      ->with('store', $store);
    }


}
