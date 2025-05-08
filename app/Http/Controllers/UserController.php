<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Permission;
use App\Models\degre;
use App\Models\Role;
use App\Models\User;
use App\Models\User_Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:users');
    }

    public function index(){
        $groups = Group::all();
        return view('user.users')->with([
            'groups' =>$groups,
        ]);
    }

    public function admins(){
        $user_roles=User_Role::where('role_id',1)->get();
        $user=User::all();
        return view('user.admin')->with([
            'user_roles' => $user_roles,
            'user' => $user,
        ]);
    }

    public function create(){
        $roles = Role::all();
        $groups = Group::all();
        return view('user.create')->with([
            'roles' => $roles,
            'groups'=>$groups,
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'last_name'=>'required',
            'first_name'=>'required',
            'login'=>'required|unique:users',
            'password'=>'required',
        ]);
        $role_id=$request->role_id;
        $group_id = $request->group_id;
        $recept_date =$request->recept_date;

        $user = new User;
        $user->slug =  Str::slug('9');
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->group_id = $request->group_id;
        $user->recept_date = $request->recept_date;
        $user->father_name = $request->father_name;
        $user->login = $request->login;
        $user->password = bcrypt($request->password);
        $user->status = $request->status=='on'?1:0;
        $user->save();
        $user->role()->sync($request->role_id);
        return redirect()->route('users')->with([
            'success'=>'Ulanyjy '.$user->last_name.' '.$user->first_name.' goşuldy',
        ]);
    }

    public function delete($user_id){
        $user = User::find($user_id);
        $user->delete();
        return redirect()->route('users')->with([
            'success'=>'Ulanyjy '.$user->last_name.' '.$user->first_name.' pozuldy',
        ]);
    }

    public function block($user_id){
        $user = User::find($user_id);
        $user ->update([
            'status' => 0
        ]);
        return redirect()->route('users')->with([
            'success'=>'Ulanyjy '.$user->last_name.' '.$user->first_name.' ýapyldy',
        ]);
    }

    public function open($user_id){
        $user = User::find($user_id);
        $user ->update([
            'status' => 1
        ]);
        return redirect()->route('users')->with([
            'success'=>'Ulanyjy '.$user->last_name.' '.$user->first_name.' açyldy',
        ]);
    }
    public function edit($user_id){
        $user=User::findOrFail($user_id);
        return view('user.edit')->with([
            'user'=>$user,
        ]);
    }
}
