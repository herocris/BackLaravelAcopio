<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Institucion;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;


class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {

     }
    public function index(Request $request)
    {
        $users = User::select('id', 'name', 'email')->with('roles:id,name')->get();
        return $this->showAll($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $rules = [
            'name' => 'required',
            'email'=> 'required|unique:users,email|email:dns',
            //'institucion_id'=> 'required',
            'password'=> ['required',
                Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()],
            'password_confirmation' => 'required|same:password',
        ];

        $messages = [
            'name.required' => 'Este campo es obligatorio',
            'email.required' => 'Este campo es obligatorio',
            'email.unique' => 'El correo '.$request->email. ' ya ha sido registrado',
            //'institucion_id.required' => 'Este campo es obligatorio',
            'password.required' => 'Este campo password es obligatorio',
            'password_confirmation.required' => 'La confirmación del password es obligatoria',
            'password_confirmation.same' => 'Ambos campos deben coincidir'
        ];

        //$this->validate($request, $rules, $messages);

        $validator = Validator::make($request->all(),$rules, $messages);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()]);
        }

        $usuario = new User;
        $usuario->name=$request->name;
        $usuario->institucion_id=$request->institucion_id;
        $usuario->email=$request->email;
        $usuario->password=Hash::make($request->password);
        $usuario->save();

        if ($request->filled('roles')){
            $usuario->assignRole($request->roles);

            $lista = collect();
            foreach ($request->roles as $rol_) {
                $lista->push($rol_);
            }

            activity()
            ->causedBy(Auth::user())
            ->performedOn($usuario)
            ->withProperties(['attributes' => ['role_id' => implode(", ",$request->roles)]])
            ->event('created')
            //->useLog(Auth::user()->name)
            ->log('se le ha  asignado el rol de: '.implode(", ",$lista->toArray())."al usuario con id: ".$usuario->id );
        }

        if ($request->filled('permissions')) {
            $usuario->syncPermissions($request->permissions);
            // $lista=collect();

            // foreach (explode(",", $request->permissions) as $per_) {
            //     //$nper = Permission::find($per_);
            //     $lista->push($per_);
            // }
            // activity()
            // ->causedBy(Auth::user())
            // ->performedOn($usuario)
            // ->withProperties(['attributes' => ['permission_id' => implode(", ",$request->permissions)]])
            // ->event('creado')
            // //->useLog(Auth::user()->name)
            // ->log('se le ha  asignado el permiso de: '.implode(", ",$lista->toArray())."al usuario con id: ".$usuario->id );
        }

        return response()->json($usuario);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::with('roles:name','permissions:name')->select('id', 'name', 'email')->find($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //dd($user->id);
        if ($request->password!="") {
             $rules = [
                 'name'=> 'required',
                 'email'=> 'required|email',
                 //'institucion_id'=> 'required',
                 'password'=> ['required',
                Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()],
                'password_confirmation' => 'required|same:password',
            ];
            $user->password=Hash::make($request->password);
        }else{
            $rules = [
                'name' => 'required',
                'email' => 'required|email'
            ];
        }

        $messages = [
            'name.required' => 'Este campo es obligatorio',
            'email.required' => 'Este campo es obligatorio',
            'email.unique' => 'El correo '.$request->email. ' ya ha sido registrado',
            //'institucion_id.required' => 'Este campo es obligatorio',
            'password.required' => 'Este campo password es obligatorio',
            'password_confirmation.required' => 'La confirmación del password es obligatoria',
            'password_confirmation.same' => 'Ambos campos deben coincidir'
        ];

        $validator = Validator::make($request->all(),$rules, $messages);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()]);
        }

        $user->name=$request->name;
        $user->email=$request->email;
        //$user->institución_id=$request->institucion_id;
        $user->save();

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id);
        $user->delete();
        return response()->json($user);
    }
}
