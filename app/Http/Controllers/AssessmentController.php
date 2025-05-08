<?php

namespace App\Http\Controllers;
use App\Models\assessment;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:users');
    }

    public function assessments(){
        $assessments = Assessment::all();
        return view('assessment.assessments')->with([
            'assessments' => $assessments
        ]);
    }
    public function create(){
        return view('assessment.create');
    }
    public function store(Request $request){
        $request->validate([
            'value'=>'required',
        ]);
        $assessment = new Assessment();
        $assessment->value = $request->value;
        $assessment->save();

        return redirect()->route('settings');
    }

    public function edit($assessment_id){
        $assessment = Assessment::find($assessment_id);
        return view('assessment.edit')->with([
            'assessment' => $assessment,
        ]);
    }

    public function update($assessment_id,Request $request){
        $request->validate([
            'name'=>'required',
        ]);
        $assessment = Assessment::findOrFail($assessment_id);
        $assessment->value = $request->value;
        $assessment->update();

        return redirect()->route('settings');
    }
    public function delete($assessment_id){
        $assessment = Assessment::find($assessment_id);
        $assessment->delete();
        return redirect()->route('settings');
    }
}
