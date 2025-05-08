<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:users');
    }

    public function permissions(){
        $permissions = Permission::all();
        return view('permission.permissions')->with([
            'permissions' => $permissions
        ]);
    }

    public function edit($perm_id){

        $permission = Permission::findOrFail($perm_id);
        return view('permission.edit')->with([
            'permission'=>$permission,
        ]);
    }

    public function update($perm_id,Request $request){

        $permission = Permission::find($perm_id);
        $permission->update(['name' => $request->name]);
        return redirect()->route('settings');
    }

    public function store(Request $request){

        $request->validate([
            'name'=>'required',
        ]);

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('settings');
    }
}
