<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(){

        $user = User::all();

        return view('content.user.list')
        ->with('user', $user);
    }

    public function editUser($id)
    {

        $user = User::find($id);
 
        return view('content.user.edit')
              ->with('user',$user);

    }
    
     public function updateUser(Request $request, $id)
     {
         $user = User::find($id);

         $fields = [     ];

         $msj = [        ];

         $this->validate($request, $fields, $msj);

         // foto
         $user->update($request->all());
     
         $user->username = $request->username;
         $user->role = $request->role;
         $user->status = $request->status;
         $user->balance = $request->balance;
         $user->whatsapp = $request->whatsapp;
         $user->save();

         return redirect()->route('user.list')->with('message','Se actualizo el perfil de '.$user->username.'');
     }


    public function destroyUser($id)
    {
      $user = User::find($id);
      
      $user->delete();
      
      return redirect()->route('user.list')->with('message', 'Usuario '.$id.' Eliminado');
    }

}
