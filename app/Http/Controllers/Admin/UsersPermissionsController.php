<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class UsersPermissionsController extends Controller
{
    public function update(Request $request, User $user)
    {
        //dd($request);
        // $listap=collect();
        // if ($request->permisos!=null) {
        //     foreach (explode(",", $request->permisos) as $per_) {
        //         $nper=Permission::find($per_);
        //         $listap->push($nper->name);
        //     }
        //     $parametros=['attributes' => ['permission_id' => implode(", ",(explode(",", $request->permisos)!=null?explode(",", $request->permisos):$user->permissions->pluck('id')->toArray())), 'model_id' => $user->id],'old' => ['permission_id' => implode(", ",$user->permissions->pluck('id')->toArray()), 'model_id' => $user->id]];
        // }else{
        //     $request->permisos=[];
        //     $parametros=['attributes' => ['permission_id' => implode(", ",($request->permisos!=null?$request->permisos:$user->permissions->pluck('id')->toArray())), 'model_id' => $user->id],'old' => ['permission_id' => implode(", ",$user->permissions->pluck('id')->toArray()), 'model_id' => $user->id]];
        // }

        // //dd($parametros);
        // activity()
        // ->causedBy(Auth::user())
        // ->performedOn($user)
        // ->withProperties($parametros)
        // ->event('updated')
        // ->useLog(Auth::user()->name)
        // ->log('Se le ha asignado el permiso de: '.implode(", ",$listap->toArray())." al usuario con id: ".$user->id );
        // //dd($listap);
        // //$user->syncPermissions($request->permisos);

        // if ($request->permisos!=null) {
        //     $user->syncPermissions(explode(",", $request->permisos));
        // }else{
        //     $user->permissions()->detach();
        // }
        // return redirect()->route('user.index')->with('flash', 'Los permisos del usuario '.$user->name.' han sido actualizados.');

        $user->syncPermissions($request->permissions);
        //return redirect()->route('user.index')->with('flash', 'El rol de tu usuario ha sido actualizado.');
        return response()->json($user);
    }
}
