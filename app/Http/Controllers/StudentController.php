<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Group;
use App\Models\Kathedra;
use App\Models\Nationality;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:users');
    }

    public function students(){
        if(auth()->user()->can('student_show')){
            $ranks = StudentRank::all();
            $faculties = Faculty::all();
            $kathedras = Kathedra::all();
            return view('student.students')->with([
                'ranks' => $ranks,
                'faculties' => $faculties,
                'kathedras' => $kathedras,
            ]);
        }
    }

    public function create(){
        if(auth()->user()->can('student_show')) {
            $studentRanks = StudentRank::all();
            $groups = Group::where('active',1)->get();
            $nationalities = Nationality::all();
            return view('student.create')->with([
                'studentRanks' => $studentRanks,
                'groups' => $groups,
                'nationalities' => $nationalities,
            ]);
        }
    }

    public function store(Request $request){
        if(auth()->user()->can('student_show')) {
            $request->validate([
                'last_name' => 'required',
                'first_name' => 'required',
                'birth'=>'required',
                'recept_date' => 'required',
                'nationality_id'=> 'required',
                'group_id'=> 'required',
                'rank_id'=> 'required',
                // 'login' => 'unique:users',
                // 'role_id'=>'required',
            ]);

            $firstChar = mb_strtolower(mb_substr($request->first_name, 0, 1, "UTF-8"));

            $str_ran = Str::slug('3');
            $recept_date_parse = Carbon::parse($request->recept_date)->format("Y-m-d");
            $birth_parse = Carbon::parse($request->birth)->format("Y-m-d");

            $student = new Student();
            $student->slug = Str::slug('9');
            $student->last_name = $request->last_name;
            $student->first_name = $request->first_name;
            $student->father_name = $request->father_name;
            $student->birth = $birth_parse;
            $student->recept_date = $recept_date_parse;
            $student->group_id = $request->group_id;
            $student->rank_id = $request->rank_id;
            $student->nationality_id = $request->nationality_id;
            $student->save();

            if ($request->hasfile('photo_path')) {
                $file_full_name = $request->file('photo_path')->getClientOriginalName();
                $filename = pathinfo($file_full_name, PATHINFO_FILENAME);
                $ext = $ext = pathinfo($file_full_name, PATHINFO_EXTENSION);

                $student->photo_path = 'photos/students/' . $student->slug . '.' . $ext;
                $student->save();

                $file = $request->file('photo_path');
                $file->storeAs('public/photos/students/', $student->slug . '.' . $ext);
            }
            return redirect()->route('students')->with([
                'success'=>'Talyp goşuldy',
            ]);
        } else{
            return redirect()->back();
        }
    }

    public function edit($student_id){
        if(auth()->user()->can('student_change')) {
            $student = Student::find($student_id);
            $groups = Group::where('active',1)->get();
            $nationalities = Nationality::all();
            return view('student.edit')->with([
                'student' => $student,
                'groups' => $groups,
                'nationalities' => $nationalities,
            ]);
        }else {
            return redirect()->back();
        }
    }

    public function update($student_id,Request $request){
        if(auth()->user()->can('student_change')) {
            $request->validate([
                'last_name' => 'required',
                'first_name' => 'required',
            ]);
            $student = Student::findOrFail($student_id);
            $student->last_name = $request->last_name;
            $student->first_name = $request->first_name;
            $student->father_name = $request->father_name;
            $student->birth = $request->birth;
            $student->recept_date = $request->recept_date;
            $student->group_id = $request->group_id;
            $student->rank_id = $request->student_rank_id;
            $student->nationality_id = $request->nationality_id;
            $student->save();
            // if ($student->user->id) {
            //     User::where('id', $student->user->id)
            //         ->update(['login' => $request->login]);
            // }
            // if ($request->password) {
            //     User::where('id', $student->user->id)
            //         ->update(['password' => bcrypt($request->password)]);
            // }
            // if ($request->group_id) {
            //     User::where('id', $student->user->id)
            //         ->update(['group_id' => $request->group_id]);
            // }
            // if ($request->recept_date) {
            //     User::where('id', $student->user->id)
            //         ->update(['recept_date' => $request->recept_date]);
            // }


            if ($request->hasfile('photo_path')) {
                $file_full_name = $request->file('photo_path')->getClientOriginalName();
                $filename = pathinfo($file_full_name, PATHINFO_FILENAME);
                $ext = $ext = pathinfo($file_full_name, PATHINFO_EXTENSION);

                $student->photo_path = 'photos/students/' . $student->slug . '.' . $ext;
                $student->save();

                $file = $request->file('photo_path');
                $file->storeAs('public/photos/students/', $student->slug . '.' . $ext);
            }
            return redirect()->route('students');
        }else {
            return redirect()->back();
        }
    }

    public function delete($student_id)
    {
        if (auth()->user()->can('student_change')) {

            $student = Student::find($student_id);
            Storage::disk('public')->delete($student->photo_path);
            $student->delete();
            return redirect()->route('students');

        }else {
            return redirect()->back();
        }
    }

    public function getStudentsApi(Request $request)
    {
        $columns = array(
            0 => 'last_name',
            1 =>  'first_name',
            2 =>  'recept_date',
            3 =>  'rank_id',
            4 =>  'id',
            5 =>  'recept_data',
        );
        $totalData = Student::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value')))  {

            $students = Student::where(function($query)use($request){
                if($first_name = $request->input('first_name')){
                    $query->where('first_name','like',"%{$first_name}%");
                };
                if($last_name = $request->input('last_name')){
                    $query->where('last_name','like',"%{$last_name}%");
                };
                if($birth = $request->input('birth')){
                    $query->where('birth', 'like', "%{$birth}%");
                };
                if($course = $request->input('course')){
                    if($course==1) {
                        $query->where('recept_date', 'like', "%{$course}%");
                    }
                };
                if($rank = $request->input('rank')){
                    $query->wherehas('student_rank',function ($query1) use ($rank){
                        $query1->where('name','like', "%{$rank}%");
                    });
                };
                if($kathedra = $request->input('kathedra')){
                    $query->wherehas('group',function ($query1) use ($kathedra){
                        $query1->wherehas('kathedra',function ($query2) use ($kathedra){
                            $query2->where('name','like', "%{$kathedra}%");
                        });
                    });
                };
                if($faculty = $request->input('faculty')){
                    $query->wherehas('group',function ($query1) use ($faculty){
                        $query1->wherehas('kathedra',function ($query2) use ($faculty){
                            $query2->wherehas('faculty',function ($query3) use ($faculty){
                                $query3->where('name','like', "%{$faculty}%");
                            });
                        });
                    });
                };
                if($course = $request->input('course')){
                    if($course==1){
                        $current = Carbon::now();
                        $query->whereRaw('DATEDIFF("'. $current .'",recept_date)/365 < 1');
                    }
                    elseif($course==2){
                        $current = Carbon::now();
                        $query->whereRaw('DATEDIFF("'. $current .'",recept_date)/365 < 2 AND DATEDIFF("'. $current .'",recept_date)/365 > 1');
                    }
                    elseif($course==3){
                        $current = Carbon::now();
                        $query->whereRaw('DATEDIFF("'. $current .'",recept_date)/365 < 3 AND DATEDIFF("'. $current .'",recept_date)/365 > 2');
                    }
                    elseif($course==4){
                        $current = Carbon::now();
                        $query->whereRaw('DATEDIFF("'. $current .'",recept_date)/365 < 4 AND DATEDIFF("'. $current .'",recept_date)/365 > 3');
                    }
                    elseif($course==5){
                        $current = Carbon::now();
                        $query->whereRaw('DATEDIFF("'. $current .'",recept_date)/365 < 5 AND DATEDIFF("'. $current .'",recept_date)/365 > 4');
                    }else
                    {
                        $current = Carbon::now();
                        $query->whereRaw('DATEDIFF("'. $current .'",recept_date)/365 < 5 AND DATEDIFF("'. $current .'",recept_date)/365 > 400000000');}
                };
                if($group = $request->input('group')){
                    $query->wherehas('group',function ($query1) use ($group){
                        $query1->where('name','like', "%{$group}%")->orWhere('number','like', "%{$group}%");
                    });
                };
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Student::where(function($query)use($request){
                if($first_name = $request->input('first_name')){
                    $query->where('first_name','like',"%{$first_name}%");
                };
                if($last_name = $request->input('last_name')){
                    $query->where('last_name','like',"%{$last_name}%");
                };
                if($birth = $request->input('birth')){
                    $query->where('birth', 'like', "%{$birth}%");
                };
                if($course = $request->input('course')){
                    if($course==1) {
                        $query->where('recept_date', 'like', "%{$course}%");
                    }
                };
                if($rank = $request->input('rank')){
                    $query->wherehas('student_rank',function ($query1) use ($rank){
                        $query1->where('name','like', "%{$rank}%");
                    });
                };
                if($kathedra = $request->input('kathedra')){
                    $query->wherehas('group',function ($query1) use ($kathedra){
                        $query1->wherehas('kathedra',function ($query2) use ($kathedra){
                            $query2->where('name','like', "%{$kathedra}%");
                        });
                    });
                };
                if($faculty = $request->input('faculty')){
                    $query->wherehas('group',function ($query1) use ($faculty){
                        $query1->wherehas('kathedra',function ($query2) use ($faculty){
                            $query2->wherehas('faculty',function ($query3) use ($faculty){
                                $query3->where('name','like', "%{$faculty}%");
                            });
                        });
                    });
                };
                if($course = $request->input('course')){
                    if($course==1){
                        $current = Carbon::now();
                        $query->whereRaw('DATEDIFF("'. $current .'",recept_date)/365 < 1');
                    }
                    elseif($course==2){
                        $current = Carbon::now();
                        $query->whereRaw('DATEDIFF("'. $current .'",recept_date)/365 < 2 AND DATEDIFF("'. $current .'",recept_date)/365 > 1');
                    }
                    elseif($course==3){
                        $current = Carbon::now();
                        $query->whereRaw('DATEDIFF("'. $current .'",recept_date)/365 < 3 AND DATEDIFF("'. $current .'",recept_date)/365 > 2');
                    }
                    elseif($course==4){
                        $current = Carbon::now();
                        $query->whereRaw('DATEDIFF("'. $current .'",recept_date)/365 < 4 AND DATEDIFF("'. $current .'",recept_date)/365 > 3');
                    }
                    elseif($course==5){
                        $current = Carbon::now();
                        $query->whereRaw('DATEDIFF("'. $current .'",recept_date)/365 < 5 AND DATEDIFF("'. $current .'",recept_date)/365 > 4');
                    }else
                    {
                        $current = Carbon::now();
                        $query->whereRaw('DATEDIFF("'. $current .'",recept_date)/365 < 5 AND DATEDIFF("'. $current .'",recept_date)/365 > 400000000');}
                };
                if($group = $request->input('group')){
                    $query->wherehas('group',function ($query1) use ($group){
                        $query1->where('name','like', "%{$group}%")->orWhere('number','like', "%{$group}%");
                    });
                };
            })->count();
        }else

        {
            $search= $request->input('search.value');
            $students = Student:: where('first_name','like',"%{$search}%")
                ->orWhere('last_name','like',"%{$search}%")
                ->orWhere('father_name','like',"%{$search}%")
                ->orWhere('Id','like',"%{$search}%")
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
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Student::count();
        }
        $data = array();
        $i=1;
        if ($students) {
            foreach ($students as $student) {

                $i++;
                $nestedData['index'] = $i;
                $nestedData['full_name'] = $student->last_name.' '.$student->first_name.' '.$student->father_name;
                // $nestedData['birth'] = $student->birth;
                if($dbDate = $student->recept_date){
                    $diffYears = Carbon::now()->diffInYears($dbDate);
                    $course = $diffYears+1;
                }else $course = "-";

                $nestedData['course'] = $course;
                $nestedData['rank'] = $student->student_rank->name;
                $nestedData['faculty'] = $student->group->kathedra->faculty->name;
                $nestedData['kathedra'] = $student->group->kathedra->name;
                $nestedData['group'] = $student->group->number."-".$student->group->name.' <span style="color: #0b51c5;">('. $student->id.')</span>';

                if($student->active==2) {
                    $lock = '<a class="btn btn-danger" href="'.route('student.open', ['student_id' => $student->id]).'"> <i class="fa fa-lock"></i>
                    </a>&nbsp;';
                }
                else {

                    $lock = ' <a class="btn btn-info" href="'.route('student.block', ['student_id' => $student->id]).'"> <i class="fa fa-unlock"></i>
                        </a>&nbsp;';
                }


                if (auth()->user()->can('student_change')) {
                    $nestedData['operations'] =   $lock .'<a class="btn btn-primary btn-md" href="' . route('student.edit', ['student_id' => $student->id]) . '"><i class="fa fa-edit"></i>
                                               </a> &nbsp; <a onclick="return confirm(\'Are you sure?\')" class="btn btn-danger" href="' . route('student.delete', ['student_id' => $student->id]) . '"> <i class="fa fa-trash"></i>
                                               </a> &nbsp;';
                }
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

    public function block($student_id){
        $student = Student::find($student_id);
        $student->update([
            'active' => 2
        ]);
        return redirect()->route('students')->with([
            'success'=>' Talyp '.$student->first_name.' '.$student->last_name.' arhiwlendi',
        ]);
    }

    public function open($student_id){
        $student = Student::find($student_id);
        $student ->update([
            'active' => NULL
        ]);
        return redirect()->route('students')->with([
            'success'=>' Talyp '.$student->first_name.' '.$student->last_name.' açyldy',
        ]);
    }
}
