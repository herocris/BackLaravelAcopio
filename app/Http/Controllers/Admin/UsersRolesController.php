<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UsersRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    //public function update(Request $request, $id)
    {
        // activity()
        // ->causedBy(Auth::user())
        // ->performedOn($user)
        // ->withProperties(['attributes' => ['role_id' => implode(", ",$request->roles), 'model_id' => $user->id],'old' => ['role_id' => implode(", ",$user->roles->pluck('id')->toArray()), 'model_id' => $user->id]])
        // ->event('updated')
        // //->useLog(Auth::user()->name)
        // ->log($request->roles==[]?('Se le han quitado todos los roles al usuario'):('Se le ha asignado el rol de: '.implode(", ",$lista->toArray())." al usuario con id: ".$user->id) );

        $user->syncRoles($request->roles);
        //return redirect()->route('user.index')->with('flash', 'El rol de tu usuario ha sido actualizado.');
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
        //
    }
}
