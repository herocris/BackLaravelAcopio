<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class RoleController extends ApiController
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
        $roles = Role::with('permissions:id,name')->select('id', 'name')->get();

        return $this->showAll($roles);
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
            'name' => 'required|unique:roles,name',
        ];
        $messages = [
            'name.required' => 'Este campo es obligatorio',
            'name.unique' => 'El rol ' . $request->name . ' ya ha sido registrado',
        ];

        $this->validate($request, $rules, $messages);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
        $role->syncPermissions($request->permissions);

        $user = Auth::user();
        activity()
            ->causedBy($user)
            ->withProperties(['attributes' => ['role' => $role]])
            ->event('creado')
            ->useLog($user->name)
            ->log('Se ha creado el rol de: ' . $role->name);

        return response()->json($role->load('permissions')); //'load' equivalente a with()
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
    public function edit(Role $role)
    {
        return response()->json($role->load('permissions')); //'load' equivalente a with()
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $rules = [
            'name' => 'required',
        ];
        $messages = [
            'name.required' => 'Este campo es obligatorio',
        ];

        $this->validate($request, $rules, $messages);
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();

        if ($request->has('permisos')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->revokePermissionTo($request->permissions);
        }

        $user = Auth::user();
        activity()
            ->causedBy($user)
            ->withProperties(['attributes' => ['role' => $role]])
            ->event('actualizado')
            ->useLog($user->name)
            ->log('Se ha actualizado el rol de: ' . $role->name);

        return response()->json($role->load('permissions')); //'load' equivalente a with()
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        $user = Auth::user();
        activity()
            ->causedBy($user)
            ->withProperties(['attributes' => ['role' => $role]])
            ->event('borrado')
            ->useLog($user->name)
            ->log('Se ha borrado el rol de: ' . $role->name);
        return response()->json('El rol ha sido borrado');
    }

    public function updatePermissions(Request $request, Role $role)
    {
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->revokePermissionTo($request->permissions);
        }
        $user = Auth::user();
        activity()
            ->causedBy($user)
            ->withProperties(['attributes' => ['role' => $role]])
            ->event('borrado')
            ->useLog($user->name)
            ->log('Se han actualizado los permisos del el rol de: ' . $role->name);


        return response()->json($role->load('permissions')); //'load' equivalente a with()
    }
}
