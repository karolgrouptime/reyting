<?php

namespace App\Http\Controllers;
use App\Models\faculty;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:users');
    }

    public function faculties(){
        $faculties = Faculty::all();
        return view('faculty.faculties')->with([
            'faculties' => $faculties
        ]);
    }

    public function create(){
        return view('faculty.create');
    }

    public function store(Request $request){

        $request->validate([
            'name'=>'required',
        ]);

        $faculty = new Faculty();
        $faculty->slug = Str::slug('9');
        $faculty->name = $request->name;
        $faculty->save();

        return redirect()->route('faculties');
    }

    public function edit($faculty_id){
        $faculty = Faculty::find($faculty_id);
        return view('faculty.edit')->with([
            'faculty' => $faculty,
        ]);
    }

    public function update($faculty_id,Request $request){
        $request->validate([
            'name'=>'required',
        ]);
        $faculty = Faculty::findOrFail($faculty_id);
        $faculty->name = $request->name;
        $faculty->save();

        return redirect()->route('faculties');
    }

    public function delete($faculty_id){
        $faculty = Faculty::find($faculty_id);
        $faculty->delete();
        return redirect()->route('faculties');
    }
}
