<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupSubject;
use App\Semester;
use App\Subject;
use App\Teacher;
use App\TeacherGroupSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LoadController extends Controller
{
    public function store(Request $request){
        $group_id = $request->input('group_id');
        $subject_id = $request->input('subject_id');
        $teacher_id = $request->input('teacher_id');
        $semester_id = $request->input('semester_id');
        if($group_subject = GroupSubject::where('semester_id',$semester_id)
            ->where('group_id',$group_id)
            ->where('subject_id',$subject_id)
            ->first()){
            $teacherGroupSubject = new TeacherGroupSubject();
            $teacherGroupSubject->group_subject_id = $group_subject->id;
            $teacherGroupSubject->teacher_id = $teacher_id;
            $teacherGroupSubject->save();
        }
        return redirect()->route('load.teachers')->with([
            'success'=>'Agyrlyk goşuldy',
        ]);
    }

    public function delete($load_id){

        $load_id = Crypt::decrypt($load_id);
        $GroupSubject =  GroupSubject::findOrFail($load_id);
        $GroupSubject->delete();
        return redirect()->back()->with([
            'success'=>'Meyilnama pozuldy',
        ]);
    }

    public function teachers(){

        $groups = Group::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $semesters = Semester::all();

        return view('load.teachers')->with([
            'groups' => $groups,
            'subjects' => $subjects,
            'teachers' => $teachers,
            'semesters' => $semesters,
        ]);
    }

    public function teachersApi(Request $request){

        $columns = array(
            0 => 'id'
        );
        $totalData = Teacher::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value')))  {

            $teachers = Teacher::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Teacher::where(function($query)use($request){
                if($first_name = $request->input('first_name')){
                    $query->where('first_name','like',"%{$first_name}%");
                };
                if($last_name = $request->input('last_name')){
                    $query->where('last_name','like',"%{$last_name}%");
                };
            })->count();
        }else {
            $search = $request->input('search.value');
            $teachers = Teacher:: where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Teacher::count();
        }
        $data = array();
        if ($teachers) {
            foreach ($teachers as $teacher) {
                $nestedData['teacher'] = $teacher->last_name." ".$teacher->first_name;
                $nestedData['operations'] =    '<a class="btn btn-info" href="'.route('load.oneTeacher',['teacher_id' => $teacher->id]).'"> <i class="fa fa-book-open"></i>
                                                </a> &nbsp;';
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function oneTeacher($teacher_id){

        $teacher = Teacher::findOrFail($teacher_id);

        return view('load.teacher_load')->with([
            'teacher_id' => $teacher_id,
            'teacher' => $teacher,
        ]);
    }

    public function oneTeacherApi(Request $request){

        $columns = array(
            0 => 'id',
        );

        $teacher_id = $request->input('teacher_id');
        $totalData = TeacherGroupSubject::where('teacher_id',$teacher_id)->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        // $order = $columns[$request->input('order.0.column')];
        // $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value')))  {

            $teacherGroupSubjects = TeacherGroupSubject::where('teacher_id',$teacher_id)->offset($start)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = TeacherGroupSubject::where('teacher_id',$teacher_id)->count();
        }else

        {
            $search= $request->input('search.value');
            $teacherGroupSubjects = Group:: where('id','like',"%{$search}%")
                ->orWhere('last_name','like',"%{$search}%")
                ->orWhere('father_name','like',"%{$search}%")
                ->orWhere(function($query)use($search){
                    $query->orWherehas('group',function ($query1) use ($search){
                        $query1->where('name','like',"%{$search}%");
                        $query1->orWhere('number','like',"%{$search}%");
                        $query1->orWherehas('kathedra',function ($query2) use ($search){
                            $query2->where('name','like',"%{$search}%");
                            $query2->orWherehas('faculty',function ($query3) use ($search){
                                $query3->where('name','like',"%{$search}%");
                            });
                        });
                    });
                    $query->orWherehas('student_rank',function ($query1) use ($search) {
                        $query1->where('name','like',"%{$search}%");
                    });
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy('id', 'desc')
                ->get();
            $totalFiltered = Group::count();
        }
        $data = array();
        if ($teacherGroupSubjects) {
            foreach ($teacherGroupSubjects as $teacherGroupSubject) {
                $nestedData['semester'] = $teacherGroupSubject->groupSubject->semester->number;
                $nestedData['subject'] = $teacherGroupSubject->groupSubject->subject->name;
                $nestedData['group'] = $teacherGroupSubject->groupSubject->group->number.'-'.$teacherGroupSubject->groupSubject->group->name;
                $nestedData['operations'] =    '<a onclick="return confirm(\'Are you sure?\')" class="btn btn-danger" href="'.route('load.deleted',['load_id'=>(Crypt::encrypt($teacherGroupSubject->group_subject_id))]).'"> <i class="fa fa-trash"></i>
                                               </a> &nbsp;';
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
}
