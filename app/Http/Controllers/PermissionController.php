<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (auth()->user()->can('read permissions')) {
            $permissions = Permission::get();
            return view('seguridad.permission.index', compact('permissions'));
        } else {
            alert()->error('Usuario No Autorizado');
            return back();
        }
    }



    public function update_permission(Request $request)
    {
        if (auth()->user()->can('edit permissions')) {
            $permission = ModelsPermission::findOrFail($request->id);
            $permission->name = $request->name;
            $permission->update();

            alert()->success('El registro ha sido modificado correctamente');
            return back();
        } else {
            alert()->error('Usuario No Autorizado');
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = Permission::create(['name' => $request->get('name')]);
        alert()->success('El registro ha sido agregado correctamente');
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        if (auth()->user()->can('delete permissions')) {
            $permission = ModelsPermission::findOrFail($id);
            $permission->delete();
            alert()->error('El registro ha sido eliminado correctamente');
            return back();
        } else {
            alert()->error('Usuario No Autorizado');
            return back();
        }
    }
}
