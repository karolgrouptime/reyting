<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:users');
    }

    public function subjects()
    {
        $typeSubjects = SubjectType::all();
        return view('subject.subjects')->with([
            'typeSubjects' => $typeSubjects
        ]);
    }
    public function create(){

        return view('subject.create')->with([

        ]);
    }

    public function store(Request $request){

        $request->validate([
            'name'=>'required',
        ]);

        $subject = new Subject();
        //$subject->slug = Str::slug('9');
        $subject->type_id = $request->input('type_subject');
        $subject->name = $request->name;
        $subject->save();

        return redirect()->route('subjects');
    }

    public function edit($subject_id){
        $subject = Subject::find($subject_id);
        return view('subject.edit')->with([
            'subject' => $subject,
        ]);
    }

    public function update($subject_id,Request $request){

        $subject = Subject::findOrFail($subject_id);
        $subject->name = $request->name;
        $subject->save();

        return redirect()->route('subjects');
    }


    public function delete($subject_id){

        $subject = Subject::find($subject_id);
        $subject->delete();
        return redirect()->route('subjects');
    }

    public function getSubjectsApi(Request $request)
    {
        $columns = array(0 => 'name');

        $totalData = Subject::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $subjects = Subject::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Subject::count();
        } else {
            $search = $request->input('search.value');
            $subjects = Subject::where('name', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Subject::where('name', 'like', "%{$search}%")->count();
        }

        $data = array();
        foreach ($subjects as $subject) {
            $nestedData['name'] = $subject->id . ' - ' . $subject->name;
            $nestedData['operations'] = '
            <a onclick="return confirm(\'Are you sure?\')" class="btn btn-danger" href="' . route('subject.delete', ['subject_id' => $subject->id]) . '">
                <i class="fa fa-trash"></i>
            </a> &nbsp;
            <a class="btn btn-primary btn-md" href="' . route('subject.edit', ['subject_id' => $subject->id]) . '">
                <i class="fa fa-edit"></i>
            </a>';
            $data[] = $nestedData;
        }

        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ]);
    }
}
