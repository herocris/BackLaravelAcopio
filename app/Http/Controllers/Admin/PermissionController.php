<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

    }
    public function index()
    {
        $permissions = Permission::select('id', 'name')->get();

        return $this->showAll($permissions);
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
        $rules = [
            'name'=> 'required|unique:permissions,name',
        ];
        $messages = [
            'name.required' => 'Este campo es obligatorio',
            'name.unique' => 'El permiso '.$request->name.' ya ha sido registrado'
        ];

        $this->validate($request, $rules, $messages);

        $permission=Permission::create(['name' => $request->name, 'guard_name' => 'web']);

        return response()->json($permission);
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
    public function edit(Permission $permission)
    {
        return response()->json($permission); //'load' equivalente a with()
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $rules = [
            'name'=> 'required',
        ];
        $messages = [
            'name.required' => 'Este campo es obligatorio',
        ];

        $this->validate($request, $rules,$messages);
        $permission->name=$request->name;
        $permission->guard_name='web';
        $permission->save();

        return response()->json($permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission )
    {
        $permission->delete();
        return response()->json('El permiso ha sido borrado');
    }
}
