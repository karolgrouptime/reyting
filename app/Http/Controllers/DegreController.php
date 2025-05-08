<?php

namespace App\Http\Controllers;
use App\Models\degre;

use Illuminate\Http\Request;

class DegreController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:users');
    }

    public function degrees(){
        $degrees = degre::all();
        return view('degree.degrees')->with([
            'degrees' => $degrees
        ]);
    }

    public function create(){
        return view('degree.create');
    }

    public function store(Request $request){

        $request->validate([
            'name'=>'required',
        ]);

        $degree = new degre();
        $degree->name = $request->name;
        $degree->save();

        return redirect()->route('settings');
    }

    public function edit($degree_id){
        $degree = degre::find($degree_id);
        return view('degree.edit')->with([
            'degree' => $degree,
        ]);
    }

    public function update($degree_id,Request $request){
        $request->validate([
            'name'=>'required',
        ]);
        $degree = degre::findOrFail($degree_id);
        $degree->name = $request->name;
        $degree->save();

        return redirect()->route('settings');
    }

    public function delete($degree_id){
        $degree = degre::find($degree_id);
        $degree->delete();
        return redirect()->route('settings');
    }
}
