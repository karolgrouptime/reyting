<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\degre;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\group_subject;
use App\Models\Journal;
use App\Models\journal_lesson_date;
use App\Models\Kathedra;
use App\Models\Role;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function teachers()
    {

        if (auth()->user()->can('teacher_show')) {

            $positions = Position::all();
            $faculties = Faculty::all();
            $kathedras = Kathedra::all();
            return view('teacher.teachers')->with([
                'faculties' => $faculties,
                'positions' => $positions,
                'kathedras' => $kathedras,
            ]);
        }
    }

    public function create()
    {

        if (auth()->user()->can('teacher_change')) {
            $positions = Position::all();
            $degrees = Degree::all();
            $kathedras = Kathedra::all();
            $faculties = Faculty::all();
            $roles = Role::all();

            return view('teacher.create')->with([
                'positions' => $positions,
                'degrees' => $degrees,
                'kathedras' => $kathedras,
                'faculties' => $faculties,
                'roles' => $roles,
            ]);
        } else {
            return redirect()->back()->with([
                'response' => 'Siziň rugsadyňyz ýok'
            ]);
        }
    }

    public function store(Request $request)
    {
        if (auth()->user()->can('teacher_change')) {
            $request->validate([
                'last_name' => 'required',
                'first_name' => 'required',
                'login' => 'unique:users',
            ]);

            //get first letter
            $firstChar = mb_strtolower(mb_substr($request->first_name, 0, 1, "UTF-8"));
            $str_ran = Str::slug('3');
            //get first letter
            $teacher = new Teacher();
            $teacher->slug = Str::slug('9');
            $teacher->last_name = $request->last_name;
            $teacher->first_name = $request->first_name;
            $teacher->father_name = $request->father_name;
            $teacher->birth = $request->birth;
            $teacher->phone = $request->phone;
            $teacher->faculty_id = $request->faculty_id;
            $teacher->kathedra_id = $request->kathedra_id;
            $teacher->position_id = $request->position_id;
            $teacher->degree_id = $request->degree_id;

            if ($request->hasfile('photo_path')) {
                $file_full_name = $request->file('photo_path')->getClientOriginalName();
                $filename = pathinfo($file_full_name, PATHINFO_FILENAME);
                $ext = $ext = pathinfo($file_full_name, PATHINFO_EXTENSION);
                $teacher->photo_path = 'photos/teachers/' . $teacher->slug . '.' . $ext;
                $file = $request->file('photo_path');
                $file->storeAs('public/photos/teachers/', $teacher->slug . '.' . $ext);
            }
            $teacher->save();

            $checkLoginUnique = User::where('login', $request->last_name . $firstChar)->first();
            $user = new User;
            $user->slug = Str::slug('9');
            $user->last_name = $request->last_name;
            $user->first_name = $request->first_name;
            if ($request->login) {
                $user->login = $request->login;
            } elseif (!$checkLoginUnique) {
                $user->login = $request->last_name . $firstChar;
            } else $user->login = $request->last_name . $firstChar . $str_ran;
            $request->password ? $user->password = bcrypt($request->password) : $user->password = bcrypt('123456');
            $user->status = 1;
            $user->teacher_id = $teacher->id;
            $user->save();

            $user->role()->sync($request->role_id);
            return redirect()->route('teachers');
        } else {
            return redirect()->back()->with([
                'response' => 'Siziň rugsadyňyz ýok'
            ]);
        }
    }

    public function edit($teacher_id)
    {
        if (auth()->user()->can('teacher_change')) {
            $teacher = Teacher::find($teacher_id);
            $positions = Position::all();
            $degrees = Degree::all();
            $kathedras = Kathedra::all();
            $faculties = Faculty::all();

            return view('teacher.edit')->with([
                'teacher' => $teacher,
                'positions' => $positions,
                'degrees' => $degrees,
                'kathedras' => $kathedras,
                'faculties' => $faculties,
            ]);
        } else {
            return redirect()->back()->with([
                'response' => 'Siziň rugsadyňyz ýok'
            ]);
        }
    }

    public function teacherEdit($teacher_id)
    {
        if (auth()->user()->teacher->position->id == 4) {
            $teacher = Teacher::find($teacher_id);
            $positions = Position::all();
            $degrees = Degree::all();
            $kathedras = Kathedra::all();
            $faculties = Faculty::all();
            return view('teacher.teacherEdit')->with([
                'teacher' => $teacher,
                'positions' => $positions,
                'degrees' => $degrees,
                'kathedras' => $kathedras,
                'faculties' => $faculties,
            ]);
        } else {
            return redirect()->back()->with([
                'response' => 'Siziň rugsadyňyz ýok'
            ]);
        }
    }

    public function teacherUpdate($teacher_id, Request $request)
    {
        if (auth()->user()->teacher->position->id == 4) {
            $request->validate([
                'last_name' => 'required',
                'first_name' => 'required',
            ]);
            $teacher = Teacher::findOrFail($teacher_id);
            $teacher->slug = Str::slug('9');
            $teacher->last_name = $request->last_name;
            $teacher->first_name = $request->first_name;
            $teacher->father_name = $request->father_name;
            $teacher->phone = $request->phone;
            $teacher->birth = $request->birth;
            $teacher->degree_id = $request->degree_id;
            if ($teacher->user->id) {
                User::where('id', $teacher->user->id)
                    ->update(['login' => $request->login]);
            }
            if ($request->password) {
                User::where('id', $teacher->user->id)
                    ->update(['password' => bcrypt($request->password)]);
            }

            return redirect()->route('teacher.setting');
        } else {
            return redirect()->back()->with([
                'response' => 'Siziň rugsadyňyz ýok'
            ]);
        }
    }

    public function update($teacher_id, Request $request)
    {

        if (auth()->user()->can('teacher_change')) {
            $request->validate([
                'last_name' => 'required',
                'first_name' => 'required',
                'faculty_id' => 'required',
                'kathedra_id' => 'required',
            ]);

            $teacher = Teacher::findOrFail($teacher_id);
            $teacher->slug = Str::slug('9');
            $teacher->last_name = $request->last_name;
            $teacher->first_name = $request->first_name;
            $teacher->father_name = $request->father_name;
            $teacher->birth = $request->birth;
            $teacher->faculty_id = $request->faculty_id;
            $teacher->kathedra_id = $request->kathedra_id;
            $teacher->phone = $request->phone;
            $teacher->degree_id = $request->degree_id;

            if ($teacher->user->id) {
                User::where('id', $teacher->user->id)
                    ->update(['login' => $request->login]);
            }
            if ($request->password) {
                User::where('id', $teacher->user->id)
                    ->update(['password' => bcrypt($request->password)]);
            }
            if ($request->hasfile('photo_path')) {
                Storage::disk('public')->delete($teacher->photo_path);
                $file_full_name = $request->file('photo_path')->getClientOriginalName();
                $filename = pathinfo($file_full_name, PATHINFO_FILENAME);
                $ext = $ext = pathinfo($file_full_name, PATHINFO_EXTENSION);
                $teacher->photo_path = 'photos/teachers/' . $teacher->slug . '.' . $ext;
                $file = $request->file('photo_path');
                $file->storeAs('public/photos/teachers/', $teacher->slug . '.' . $ext);
            }
            $teacher->save();
            return redirect()->route('teachers');
        } else {
            return redirect()->back()->with([
                'response' => 'Siziň rugsadyňyz ýok'
            ]);
        }
    }

    public function delete($teacher_id)
    {
        if (auth()->user()->can('teacher_change')) {
            $teacher = Teacher::find($teacher_id);
            Storage::disk('public')->delete($teacher->photo_path);
            $teacher->delete();
            return redirect()->route('teachers');
        } else {
            return redirect()->back()->with([
                'response' => 'Siziň rugsadyňyz ýok'
            ]);
        }
    }

    public function getTeachersApi(Request $request)
    {
        $columns = array(
            0 => 'last_name',
            1 => 'first_name',
            2 => 'position_id',
            4 => 'faculty_id',
            5 => 'kathedra_id',
            6 => 'photo_path',
        );

        $totalData = Teacher::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {

            $teachers = Teacher::where(function ($query) use ($request) {
                if ($first_name = $request->input('first_name')) {
                    $query->where('first_name', 'like', "%{$first_name}%");
                };
                if ($last_name = $request->input('last_name')) {
                    $query->where('last_name', 'like', "%{$last_name}%");
                };
                if ($birth = $request->input('birth')) {
                    $query->where('birth', 'like', "%{$birth}%");
                };
                if ($position = $request->input('position')) {
                    $query->wherehas('position', function ($query1) use ($position) {
                        $query1->where('name', 'like', "%{$position}%");
                    });
                };
                if ($kathedra = $request->input('kathedra')) {
                    $query->wherehas('kathedra', function ($query1) use ($kathedra) {
                        $query1->where('name', 'like', "%{$kathedra}%");
                    });
                };
                if ($faculty = $request->input('faculty')) {
                    $query->wherehas('faculty', function ($query1) use ($faculty) {
                        $query1->where('name', 'like', "%{$faculty}%");
                    });
                };
                if ($phone = $request->input('phone')) {
                    $query->where('phone', 'like', "%{$phone}%")->orWhere('id', 'like', "%{$phone}%");
                };
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Teacher::where(function ($query) use ($request) {
                if ($first_name = $request->input('first_name')) {
                    $query->where('first_name', 'like', "%{$first_name}%");
                };
                if ($last_name = $request->input('last_name')) {
                    $query->where('last_name', 'like', "%{$last_name}%");
                };
                if ($birth = $request->input('birth')) {
                    $query->where('birth', 'like', "%{$birth}%");
                };
                if ($position = $request->input('position')) {
                    $query->wherehas('position', function ($query1) use ($position) {
                        $query1->where('name', 'like', "%{$position}%");
                    });
                };
                if ($kathedra = $request->input('kathedra')) {
                    $query->wherehas('kathedra', function ($query1) use ($kathedra) {
                        $query1->where('name', 'like', "%{$kathedra}%");
                    });
                };
                if ($faculty = $request->input('faculty')) {
                    $query->wherehas('faculty', function ($query1) use ($faculty) {
                        $query1->where('name', 'like', "%{$faculty}%");
                    });
                };
            })->count();
        } else {
            $search = $request->input('search.value');

            $teachers = Teacher:: where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('Id', 'like', "%{$search}%")
                ->orWhere(function ($query) use ($search) {

                    $query->orWherehas('position', function ($query1) use ($search) {
                        $query1->where('name', 'like', "%{$search}%");
                    });

                    $query->orWherehas('faculty', function ($query1) use ($search) {
                        $query1->where('name', 'like', "%{$search}%");
                    });
                    $query->orWherehas('kathedra', function ($query1) use ($search) {
                        $query1->where('name', 'like', "%{$search}%");
                    });
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Teacher::count();
        }
        $data = array();
        $i = 1;
        if ($teachers) {
            foreach ($teachers as $teacher) {
                $nestedData['index'] = $i;
                $nestedData['full_name'] = $teacher->last_name . ' ' . $teacher->first_name . ' ' . $teacher->father_name;
                $nestedData['birth'] = $teacher->birth;
                $nestedData['position'] = $teacher->position ? $teacher->position->name : '-';
                $nestedData['faculty'] = $teacher->faculty->name;
                $nestedData['kathedra'] = $teacher->kathedra->name;
                $nestedData['phone'] = $teacher->phone . '<span style="color: #053d9b"> (' . $teacher->id . ')</span>';
                $nestedData['photo'] = $teacher->photo_path ? '<div class="col-xs-2"><a id="image" data-fancybox="images" href="' . url('storage/' . $teacher->photo_path) . '" class="image-link"><img style= "height: 60px; width: 70px;"
                                        class="border border-info" src="' . url('storage/' . $teacher->photo_path) . '"/></a>
                                        </div>' : '-';
                if (auth()->user()->can('teacher_change')) {
                    $nestedData['operations'] = '<a onclick="return confirm(\'Are you sure?\')" class="btn btn-danger" href="' . route('teacher.delete', ['teacher_id' => $teacher->id]) . '"> <i class="fa fa-trash"></i>
                                               </a> &nbsp;
                                               <a class="btn btn-primary btn-md" href="' . route('teacher.edit', ['teacher_id' => $teacher->id]) . '"><i class="fa fa-edit"></i>
                                               </a> &nbsp;
                                                <a class="btn btn-info btn-md" href="#"> <i class="fa fa-user"></i>
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

    public function teacherGroups()
    {
        $groups = Group::where('active', 1)->get();
        $subjects = Subject::where('id','!=',629)->get();
        return view('teacher.teacher_groups')->with([
            'groups' => $groups,
            'subjects' => $subjects,
        ]);
    }

    public function teacherGroupsApi(Request $request)
    {
        $columns = array(
            0 => 'id',
        );
        function currentSemester($group_id)
        {

            $group = Group::findOrFail($group_id);
            $current_date = Carbon::now()->toDateString();
            $recept_date = $group->student[0]->recept_date;

            $y_1 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(1)->year;
            $y_2 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(2)->year;
            $y_3 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(3)->year;
            $y_4 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(4)->year;
            $y_5 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(5)->year;

            $endOneSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-02-04')->toDateString();
            $startTwoSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-02-08')->toDateString();
            $endTwoSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-07-24')->toDateString();
            $startThreeSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-08-05')->toDateString();

            $endThreeSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-02-04')->toDateString();
            $startFourSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-02-08')->toDateString();
            $endFourSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-07-24')->toDateString();
            $startFiveSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-08-05')->toDateString();

            $endFiveSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-02-04')->toDateString();
            $startSixSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-02-08')->toDateString();
            $endSixSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-07-24')->toDateString();
            $startSevenSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-08-05')->toDateString();

            $endSevenSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-02-04')->toDateString();
            $startEightSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-02-08')->toDateString();
            $endEightSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-07-24')->toDateString();
            $startNineSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-08-05')->toDateString();

            $endNineSem = Carbon::createFromFormat('Y-m-d', $y_5 . '-02-04')->toDateString();
            $startTenSem = Carbon::createFromFormat('Y-m-d', $y_5 . '-02-08')->toDateString();
            $endTenSem = Carbon::createFromFormat('Y-m-d', $y_5 . '-07-24')->toDateString();

            if ($recept_date <= $current_date AND $current_date <= $endOneSem) {
                return 1;
            };
            if ($startTwoSem <= $current_date AND $current_date <= $endTwoSem) {
                return 2;
            };
            if ($startThreeSem <= $current_date AND $current_date <= $endThreeSem) {
                return 3;
            };
            if ($startFourSem <= $current_date AND $current_date <= $endFourSem) {
                return 4;
            };
            if ($startFiveSem <= $current_date AND $current_date <= $endFiveSem) {
                return 5;
            };
            if ($startSixSem <= $current_date AND $current_date <= $endSixSem) {
                return 6;
            };
            if ($startSevenSem <= $current_date AND $current_date <= $endSevenSem) {
                return 7;
            };
            if ($startEightSem <= $current_date AND $current_date <= $endEightSem) {
                return 8;
            };
            if ($startNineSem <= $current_date AND $current_date <= $endNineSem) {
                return 9;
            };
            if ($startTenSem <= $current_date AND $current_date <= $endTenSem) {
                return 10;
            };
        }

        $search = $request->input('search.value');

        $totalData = group_subject::where('subject_id', '!=', 629)->where(function ($query) use ($search) {
            $query->wherehas('teacher', function ($query2) use ($search) {
                if (auth()->user()->teacher) {
                    $query2->where('teacher_id', auth()->user()->teacher->id);
                }
            });
        })->groupBy('group_id')->count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $teacher_groups = group_subject::where('subject_id', '!=', 629)->where(function ($query) use ($search) {
                $query->wherehas('teacher', function ($query2) use ($search) {
                    if (auth()->user()->teacher) {
                        $query2->where('teacher_id', auth()->user()->teacher->id);

                    }
                });
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Journal::where(function ($query) use ($search) {
                $query->wherehas('group_subject', function ($query1) use ($search) {
                    $query1->wherehas('teacher', function ($query2) use ($search) {
                        if (auth()->user()->teacher) {
                            $query2->where('teacher_id', auth()->user()->teacher->id);
                        }
                    });
                });
            })->count();
        } else {
            $search = $request->input('search.value');
            $teachers = Teacher:: where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere(function ($query) use ($search) {
                    $query->orWherehas('position', function ($query1) use ($search) {
                        $query1->where('name', 'like', "%{$search}%");
                    });
                    $query->orWherehas('faculty', function ($query1) use ($search) {
                        $query1->where('name', 'like', "%{$search}%");
                    });
                    $query->orWherehas('kathedra', function ($query1) use ($search) {
                        $query1->where('name', 'like', "%{$search}%");
                    });
                })->groupBy('group_id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Teacher::count();
        }
        $data = array();
        if ($teacher_groups) {
            foreach ($teacher_groups as $teacher_group) {
                $current_semester = currentSemester($teacher_group->group->id);
                if ($current_semester == $teacher_group->semester->number) {
                    $nestedData['group'] = $teacher_group->group->number . '-' . $teacher_group->group->name;
                    $nestedData['operations'] = '<a class="btn btn-info btn-md" href="' . route('teacher.groupSubjects', ['group_id' => $teacher_group->group->id]) . '"><i class="fa fa-user"> Girmek-' . $current_semester . '</i>
                                               </a> &nbsp;';
                    $data[] = $nestedData;
                }
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

    public function groupSubjects($group_id)
    {
        $group = Group::findOrFail($group_id);
        return view('teacher.teacher_group_subjects')->with([
            'group' => $group,
            'group_id' => $group_id,
        ]);
    }

    public function getSubjectsOfGroupApi(Request $request)
    {
        $columns = array(
            0 => 'group_id',
            1 => 'faculty',
            2 => 'kathedra',
        );

        $group_id = $request->input('group_id');


        function currentSemester($group_id)
        {
            $group = Group::findOrFail($group_id);
            $current_date = Carbon::now()->toDateString();
            $recept_date = $group->student[0]->recept_date;

            $y_1 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(1)->year;
            $y_2 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(2)->year;
            $y_3 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(3)->year;
            $y_4 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(4)->year;
            $y_5 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(5)->year;

            $endOneSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-02-04')->toDateString();
            $startTwoSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-02-08')->toDateString();
            $endTwoSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-07-24')->toDateString();
            $startThreeSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-08-05')->toDateString();

            $endThreeSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-02-04')->toDateString();
            $startFourSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-02-08')->toDateString();
            $endFourSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-07-24')->toDateString();
            $startFiveSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-08-05')->toDateString();

            $endFiveSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-02-04')->toDateString();
            $startSixSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-02-08')->toDateString();
            $endSixSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-07-24')->toDateString();
            $startSevenSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-08-05')->toDateString();

            $endSevenSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-02-04')->toDateString();
            $startEightSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-02-08')->toDateString();
            $endEightSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-07-24')->toDateString();
            $startNineSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-08-05')->toDateString();

            $endNineSem = Carbon::createFromFormat('Y-m-d', $y_5 . '-02-04')->toDateString();
            $startTenSem = Carbon::createFromFormat('Y-m-d', $y_5 . '-02-08')->toDateString();
            $endTenSem = Carbon::createFromFormat('Y-m-d', $y_5 . '-07-24')->toDateString();

            if ($recept_date <= $current_date AND $current_date <= $endOneSem) {
                return 1;
            };
            if ($startTwoSem <= $current_date AND $current_date <= $endTwoSem) {
                return 2;
            };
            if ($startThreeSem <= $current_date AND $current_date <= $endThreeSem) {
                return 3;
            };
            if ($startFourSem <= $current_date AND $current_date <= $endFourSem) {
                return 4;
            };
            if ($startFiveSem <= $current_date AND $current_date <= $endFiveSem) {
                return 5;
            };
            if ($startSixSem <= $current_date AND $current_date <= $endSixSem) {
                return 6;
            };
            if ($startSevenSem <= $current_date AND $current_date <= $endSevenSem) {
                return 7;
            };
            if ($startEightSem <= $current_date AND $current_date <= $endEightSem) {
                return 8;
            };
            if ($startNineSem <= $current_date AND $current_date <= $endNineSem) {
                return 9;
            };
            if ($startTenSem <= $current_date AND $current_date <= $endTenSem) {
                return 10;
            };
        }

        $current_semester = currentSemester($group_id);
        $totalData = group_subject::where('subject_id', '!=', 629)->where(function ($query) use ($group_id, $current_semester) {
            $query->wherehas('group', function ($query1) use ($group_id) {
                $query1->where('id', $group_id);
            });
            $query->wherehas('semester', function ($query2) use ($current_semester) {
                $query2->where('id', $current_semester);
            });
        })->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {

            $groupSubjects = group_subject::where('subject_id', '!=', 629)->where(function ($query) use ($group_id, $current_semester) {
                $query->wherehas('group', function ($query1) use ($group_id) {
                    $query1->where('id', $group_id);
                });
                $query->wherehas('semester', function ($query2) use ($current_semester) {
                    $query2->where('id', $current_semester);
                });
            })
//                ->groupBy('subject_id')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = group_subject::where('subject_id', '!=', 629)->where(function ($query) use ($group_id, $current_semester) {
                $query->wherehas('group', function ($query1) use ($group_id) {
                    $query1->where('id', $group_id);
                });
                $query->wherehas('semester', function ($query2) use ($current_semester) {
                    $query2->where('id', $current_semester);
                });
            })->count();
        } else {
            $search = $request->input('search.value');
            $journals = Journal:: where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('father_name', 'like', "%{$search}%")
                ->orWhere(function ($query) use ($search) {
                    $query->orWherehas('group', function ($query1) use ($search) {
                        $query1->where('name', 'like', "%{$search}%");
                        $query1->orWhere('number', 'like', "%{$search}%");
                        $query1->orWherehas('kathedra', function ($query2) use ($search) {
                            $query2->where('name', 'like', "%{$search}%");
                            $query2->orWherehas('faculty', function ($query3) use ($search) {
                                $query3->where('name', 'like', "%{$search}%");
                            });
                        });
                    });
                    $query->orWherehas('student_rank', function ($query1) use ($search) {
                        $query1->where('name', 'like', "%{$search}%");
                    });
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Student::count();
        }
        $data = array();
        if ($groupSubjects) {
            foreach ($groupSubjects as $groupSubject) {
                if ($groupSubject->semester->number == $current_semester) {
                    $nestedData['subject'] = $groupSubject->subject->name;

                    if ($groupSubject->teacher) {
                        $rate_can = $groupSubject->teacher->teach->id == auth()->user()->teacher->id ? 1 : 0;
                    } else {
                        $rate_can = 0;
                    }
                    $nestedData['operations'] = '<a class="btn btn-info btn-md" href="'
                        . route('teacher.groupSubject', [
                            'group_id' => Crypt::encrypt($groupSubject->group->id),
                            'subject_id' => Crypt::encrypt($groupSubject->subject->id),
                            'semester_id' => Crypt::encrypt($groupSubject->semester->id),
                            'rate_can' => $rate_can,
                        ]) .
                        '"> <i class="fa fa-envelope-open-text"> Girmek</i>
                                               </a> &nbsp;';
                    $data[] = $nestedData;
                }
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

    public function groupSubject($group_id, $subject_id, $semester_id, $rate_can)
    {

        $group_id = Crypt::decrypt($group_id);
        $subject_id = Crypt::decrypt($subject_id);
        $semester_id = Crypt::decrypt($semester_id);

        $subject = Subject::findOrFail($subject_id);
        $group = Group::findOrFail($group_id);

        $group_subject = group_subject::where(function ($query) use ($group_id, $subject_id, $semester_id) {
            $query->wherehas('group', function ($query1) use ($group_id) {
                $query1->where('id', $group_id);
            });
            $query->wherehas('semester', function ($query2) use ($semester_id) {
                $query2->where('id', $semester_id);
            });
            $query->wherehas('subject', function ($query1) use ($subject_id) {
                $query1->where('id', $subject_id);
            });
        })->first();

        $journal = Journal::whereHas('group_subject', function ($query) use ($group_id, $group_subject) {
            $query->where('id', $group_subject->id);
        })
            ->WhereHas('group', function ($query) use ($group_id) {
                $query->where('id', $group_id);
            })->first();

        $lesson_dates = journal_lesson_date::whereHas('journal', function ($query) use ($journal) {
            $query->where('journal_id', $journal->id);
        })->orderBy('date_lesson')->get();

        $assessments = Assessment::all();
        return view('teacher.teacher_group_subject')->with([
            'assessments' => $assessments,
            'subject' => $subject,
            'group' => $group,
            'group_subject' => $group_subject,
            'journal' => $journal,
            'lesson_dates' => $lesson_dates,
            'rate_can' => $rate_can,
        ]);
    }

    public function teacherSetting(Request $request)
    {
        Carbon::now()->toDateString();
        $kathedra_id = Auth()->user()->teacher->kathedra->id;

        $teach_reports = Teacher::LeftJoin('journal_lesson_dates', 'journal_lesson_dates.teacher_id', '=', 'teachers.id')
            ->where('teachers.kathedra_id', $kathedra_id)
            ->select('teachers.last_name', 'teachers.first_name', 'teachers.father_name', 'teachers.id', 'teachers.position_id', 'teachers.birth', 'teachers.phone', 'teachers.kathedra_id')
            ->addSelect(DB::raw('COUNT(CASE WHEN journal_lesson_dates.number_lesson AND (journal_lesson_dates.date_lesson BETWEEN "' . Carbon::now()->startOfWeek()->toDateString() . ' " AND "' . Carbon::now()->endOfWeek()->toDateString() . ' ")    THEN 0 END) as total_count'))
            ->groupBy('teachers.id')
            ->orderBy('total_count', 'desc')
            ->get();

        if ($request->date) {
            $date = $request->date;
        } else $date = Carbon::now()->toDateString();
        if ($request->para) {
            $para = $request->para;
        } else
            $para = 1;
        $groupReportForWeek = Group::leftJoin('students', function ($query) use ($para) {
            $query->on('groups.id', '=', 'students.group_id');
        })->leftJoin('lesson_assessments', function ($query) {
            $query->on('lesson_assessments.student_id', '=', 'students.id');
        })->leftJoin('journal_lesson_dates', function ($query) use ($para) {
            $query->on('journal_lesson_dates.id', '=', 'lesson_assessments.lesson_date_id');
            $query->where('journal_lesson_dates.number_lesson', $para);
        })
            ->where('journal_lesson_dates.date_lesson', '=', $date)
            ->where('groups.active', 1)
            ->where('groups.kathedra_id', $kathedra_id)
            ->select('groups.name', 'groups.number', 'groups.id', 'journal_lesson_dates.date_lesson')
            ->addSelect(DB::raw('COUNT(CASE WHEN lesson_assessments.assessment_id = ' . 12 . '
                 THEN 0 END) as deuce'))
            ->addSelect(DB::raw('COUNT(CASE WHEN lesson_assessments.assessment_id = ' . 14 . '
                 THEN 0 END) as three'))
            ->addSelect(DB::raw('COUNT(CASE WHEN lesson_assessments.assessment_id = ' . 16 . '
                 THEN 0 END) as four'))
            ->addSelect(DB::raw('COUNT(CASE WHEN lesson_assessments.assessment_id = ' . 17 . '
                 THEN 0 END) as five'))
            ->addSelect(DB::raw('COUNT(CASE WHEN lesson_assessments.assessment_id = ' . 6 . '
                 THEN 0 END) as attire'))
            ->addSelect(DB::raw('COUNT(CASE WHEN lesson_assessments.assessment_id = ' . 7 . '
                 THEN 0 END) as medical_unit'))
            ->addSelect(DB::raw('COUNT(CASE WHEN lesson_assessments.assessment_id = ' . 8 . '
                 THEN 0 END) as hospital'))
            ->addSelect(DB::raw('COUNT(CASE WHEN lesson_assessments.assessment_id = ' . 9 . '
                 THEN 0 END) as official_trip'))
            ->addSelect(DB::raw('COUNT(CASE WHEN lesson_assessments.assessment_id = ' . 10 . '
                 THEN 0 END) as cultural_event'))
            ->addSelect(DB::raw('COUNT(CASE WHEN lesson_assessments.assessment_id = ' . 18 . '
                 THEN 0 END) as arist'))
            ->addSelect(DB::raw('COUNT(CASE WHEN lesson_assessments.assessment_id = ' . 19 . '
                  THEN 0 END) as porad'))
            ->addSelect(DB::raw('COUNT(CASE WHEN lesson_assessments.assessment_id BETWEEN "' . 6 . '" AND "' . 19 . '"
                  THEN 0 END) as total_count'))
            ->groupBy('groups.id')
            ->get();
        $tid = auth()->user()->teacher->id;
        $teacher_loads = TeacherGroupSubject::where('teacher_id', $tid)
            ->orderBy('id', 'desc')
            ->Limit(10)
            ->get();
        $groups = Group::where('active', 1)->get();
        $subjects = Subject::where('id','!=',629)->get();
        return view('teacher.teacher_setting')->with([
            'para' => $para,
            'date' => $date,
            'groupReportForWeek' => $groupReportForWeek,
            'groups' => $groups,
            'subjects' => $subjects,
            'teacher_loads' => $teacher_loads,
            'teach_reports' => $teach_reports
        ]);
    }

    public function teacher_load_store(Request $request)
    {
        function currentSemester($group_id)
        {
            $group = Group::findOrFail($group_id);
            $current_date = Carbon::now()->toDateString();
            $recept_date = $group->student[0]->recept_date;

            $y_1 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(1)->year;
            $y_2 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(2)->year;
            $y_3 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(3)->year;
            $y_4 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(4)->year;
            $y_5 = Carbon::createFromFormat('Y-m-d', $recept_date)->addYear(5)->year;

            $endOneSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-02-04')->toDateString();
            $startTwoSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-02-08')->toDateString();
            $endTwoSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-07-24')->toDateString();
            $startThreeSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-08-05')->toDateString();

            $endThreeSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-02-04')->toDateString();
            $startFourSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-02-08')->toDateString();
            $endFourSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-07-24')->toDateString();
            $startFiveSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-08-05')->toDateString();

            $endFiveSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-02-04')->toDateString();
            $startSixSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-02-08')->toDateString();
            $endSixSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-07-24')->toDateString();
            $startSevenSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-08-05')->toDateString();

            $endSevenSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-02-04')->toDateString();
            $startEightSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-02-08')->toDateString();
            $endEightSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-07-24')->toDateString();
            $startNineSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-08-05')->toDateString();

            $endNineSem = Carbon::createFromFormat('Y-m-d', $y_5 . '-02-04')->toDateString();
            $startTenSem = Carbon::createFromFormat('Y-m-d', $y_5 . '-02-08')->toDateString();
            $endTenSem = Carbon::createFromFormat('Y-m-d', $y_5 . '-07-24')->toDateString();

            if ($recept_date <= $current_date AND $current_date <= $endOneSem) {
                return 1;
            };
            if ($startTwoSem <= $current_date AND $current_date <= $endTwoSem) {
                return 2;
            };
            if ($startThreeSem <= $current_date AND $current_date <= $endThreeSem) {
                return 3;
            };
            if ($startFourSem <= $current_date AND $current_date <= $endFourSem) {
                return 4;
            };
            if ($startFiveSem <= $current_date AND $current_date <= $endFiveSem) {
                return 5;
            };
            if ($startSixSem <= $current_date AND $current_date <= $endSixSem) {
                return 6;
            };
            if ($startSevenSem <= $current_date AND $current_date <= $endSevenSem) {
                return 7;
            };
            if ($startEightSem <= $current_date AND $current_date <= $endEightSem) {
                return 8;
            };
            if ($startNineSem <= $current_date AND $current_date <= $endNineSem) {
                return 9;
            };
            if ($startTenSem <= $current_date AND $current_date <= $endTenSem) {
                return 10;
            };
        }
        $semester_number=currentSemester($request->group_id);

        $request->validate([
            'group_id' => 'required',
            'subject_id' => 'required',
            'number_of_hours' => 'required',
        ]);

        $groupSubject = new group_subject();
        $groupSubject->group_id = $request->group_id;
        $groupSubject->subject_id = $request->subject_id;
        $groupSubject->semester_id = $semester_number;
        $groupSubject->number_of_hours = $request->number_of_hours;
        $groupSubject->save();

        $journal = new Journal();
        $journal->group_id = $request->group_id;
        $journal->group_subject_id = $groupSubject->id;
        $journal->save();
        $group_id = $request->input('group_id');
        $subject_id = $request->input('subject_id');
        $teacher_id = $request->input('teacher_id');
        $semester_id = $semester_number;
        $number_of_hours = $request->input('number_of_hours');
        if ($group_subject = group_subject::where('semester_id', $semester_id)
            ->where('group_id', $group_id)
            ->where('subject_id', $subject_id)
            ->where('number_of_hours', $number_of_hours)
            ->first()) {
            $teacherGroupSubject = new TeacherGroupSubject();
            $teacherGroupSubject->group_subject_id = $group_subject->id;
            $teacherGroupSubject->teacher_id = $teacher_id;
            $teacherGroupSubject->save();
        }
        return redirect()->back()->with([
            'success' => 'Meyilnama goşuldy',
        ]);
    }

    public function TeachLoadDelete($group_subject_id)
    {
        $GroupSubject = group_subject::findOrFail($group_subject_id);
        $GroupSubject->delete();
        return redirect()->back()->with([
            'success' => 'Meyilnama pozuldy',
        ]);

    }

    public function Loaddelete($load_id)
    {

        $load_id = Crypt::decrypt($load_id);
        $teacherGroupSubject = group_subject::findOrFail($load_id);
        if ($teacherGroupSubject->created_at->format('Y-m-d') == Carbon::now()->toDateString()) {
            $teacherGroupSubject->delete();
            return redirect()->back()->with([
                'success' => 'Meýilnama pozuldy',
            ]);
        } else {
            return redirect()->back()->with([
                'error' => 'Meýilnamany goşan günüňiz pozup bilersiňiz!!',
            ]);
        }

    }

    public function saveExcel()
    {
        return Excel::download(new TeachersExport, 'Mugallymlar.xlsx');
    }

    public function Helpstore(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required',
            'text' => 'required|string|max:400',
        ]);
        $help = Teacher::findOrFail(auth()->user()->teacher->id);
        $help->photo_path = $request->text;
        $help->save();
        return redirect()->back()->with([
            'success' => 'Bellikler goşuldy',
        ]);

    }
}
