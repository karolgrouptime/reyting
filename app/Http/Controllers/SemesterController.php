<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SemesterController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:users');
    }

    public function semesters(){
        $semesters = Semester::all();
        return view('semester.semesters')->with([
            'semesters' => $semesters
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
        $kathedra = Kathedra::findOrFail($kathedra_id);
        return view('kathedra.edit')->with([
            'kathedra' => $kathedra,
        ]);
    }

    public function update($kathedra_id,Request $request){

        $request->validate([
            'name'=>'required',
        ]);

        $kathedra = Kathedra::findOrFail($kathedra_id);
        $kathedra->name = $request->name;
        $kathedra->save();

        return redirect()->route('kathedras');
    }

    public function delete($kathedra_id){
        $faculty = Kathedra::findOrFail($kathedra_id);
        $faculty->delete();
        return redirect()->route('kathedras');
    }
}
