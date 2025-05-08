<?php

namespace App\Http\Controllers;

use App\Models\faculty;
use App\Models\Kathedra;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KathedraController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:users');
    }

    public function kathedras(){
        $kathedras = Kathedra::all();
        return view('kathedra.kathedras')->with([
            'kathedras' => $kathedras
        ]);
    }

    public function create(){
        $faculties = Faculty::all();
        return view('kathedra.create')->with([
            'faculties' => $faculties
        ]);
    }

    public function store(Request $request){

        $request->validate([
            'name'=>'required',
        ]);

        $kathedra = new Kathedra();
        $kathedra->slug = Str::slug('9');
        $kathedra->name = $request->name;
        $kathedra->faculty_id = $request->faculty_id;
        $kathedra->save();

        return redirect()->route('kathedras');
    }

    public function edit($kathedra_id){
        $faculties = Faculty::all();
        $kathedra = Kathedra::find($kathedra_id);
        return view('kathedra.edit')->with([
            'kathedra' => $kathedra,
            'faculties' => $faculties,
        ]);
    }

    public function update($kathedra_id,Request $request){

        $request->validate([
            'name'=>'required',
        ]);
        $kathedra = Kathedra::findOrFail($kathedra_id);
        $kathedra->name = $request->name;
        $kathedra->faculty_id = $request->faculty_id;
        $kathedra->save();

        return redirect()->route('kathedras');
    }

    public function delete($kathedra_id){
        $faculty = Kathedra::find($kathedra_id);
        $faculty->delete();
        return redirect()->route('kathedras');
    }
}
