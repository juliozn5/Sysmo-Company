<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserControler extends Controller
{
    public function list(){

        $user = User::all();

        return view('content.user.list')
        ->with('user', $user);
    }

    public function editUser($id)
    {

        $user = User::find($id);

        // $timezone = Timezone::orderBy('list_utc','ASC')->get();
        // $countries = Country::orderBy('name','ASC')->get();
 
 
        return view('users.componenteUsers.admin.edit-user')
              ->with('user',$user);
            //   ->with('countries',$countries)
            //   ->with('timezone',$timezone);
    }
    
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        $fields = [
         "name" => ['required'],
         "last_name" => ['required'],
         "email" => [
            'required',
            'string',
            'email',
            'max:255',
        ],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido',
            'last_name.required' => 'El telefono es requerido',
            'email.unique' => 'El correo debe ser unico',
        ];

        $this->validate($request, $fields, $msj);

        $fullname = $request->name .' '. $request->last_name;

        // foto
        $user->update($request->all());
        if ($request->hasFile('photo')) {
            if(!$user->getMedia('photo')->isEmpty()) {
                $user->getFirstMedia('photo')->delete();
            }
            $user->addMediaFromRequest("photo")->toMediaCollection('photo');
        }
        $user->fullname = $fullname;
        $user->utc = $request->utc;
        $user->admin = $request->admin;
        $user->status = $request->status;
        $user->balance = $request->balance;
        $user->website = $request->website;
        $user->whatsapp = $request->whatsapp;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('list-user')->with('message','Se actualizo el perfil de '.$user->fullname.'');
    }


    public function destroyUser($id)
    {
      $user = User::find($id);
      
      $user->delete();
      
      return redirect()->route('list-user')->with('message', 'Usuario '.$id.' Eliminado');
    }

}
