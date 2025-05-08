<?php

namespace App\Http\Controllers;
use App\Models\assessment;
use App\Models\group;
use App\Models\group_subject;
use App\Models\journal;
use App\Models\journal_lesson_date;
use App\Models\semester;
use App\Models\subject;
use App\Models\student;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class GroupSubjectController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:users');
    }

    public function trainingPrograms()
    {

        return view('trainingProgram.training_programs');
    }

    public function create()
    {
        $groups = Group::all();
        $subjects = Subject::all();
        $semesters = Semester::all();
        return view('trainingProgram.create')->with([
            'groups' => $groups,
            'subjects' => $subjects,
            'semesters' => $semesters,
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
        ]);

        $groupSubject = new group_subject();
        $groupSubject->group_id = $request->group_id;
        $groupSubject->subject_id = $request->subject_id;
        $groupSubject->semester_id = $request->semester_id;
        $groupSubject->number_of_hours = $request->number_of_hours;
        $groupSubject->save();

        $journal = new Journal();
        $journal->group_id = $request->group_id;
        $journal->group_subject_id = $groupSubject->id;
        $journal->save();

        return redirect()->route('trainingPrograms')->with([
            'success' => 'Meýilnama goşuldy',
        ]);
    }

    public function edit($trainingProgram_id)
    {

        $trainingProgram = group_subject::findOrFail($trainingProgram_id);
        $groups = Group::all();
        $subjects = Subject::all();
        $semesters = Semester::all();

        return view('trainingProgram.edit')->with([
            'trainingProgram' => $trainingProgram,
            'groups' => $groups,
            'subjects' => $subjects,
            'semesters' => $semesters,
        ]);
    }

    public function update($student_id, Request $request)
    {

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

        if ($request->hasfile('photo_path')) {
            $file_full_name = $request->file('photo_path')->getClientOriginalName();
            $filename = pathinfo($file_full_name, PATHINFO_FILENAME);
            $ext = $ext = pathinfo($file_full_name, PATHINFO_EXTENSION);

            $student->photo_path = 'photos/students/' . $student->slug . '.' . $ext;
            $student->save();

            $file = $request->file('photo_path');
            $file->storeAs('public/photos/students/', $student->slug . '.' . $ext);
        }

        return redirect()->route('trainingPrograms');
    }

    public function delete($trainingProgram_id)
    {

        $trainingProgram = group_subject::find($trainingProgram_id);
        $trainingProgram->delete();
        return redirect()->route('trainingPrograms');
    }

    public function getTrainingProgramsApi(Request $request)
    {
        $columns = array(
            0 => 'group_id',
            1 => 'subject_id',
            2 => 'semester_id',
            3 => 'number_of_hours',
        );

        $totalData = group_subject::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {

            $trainingPrograms = GroupSubject::where(function ($query) use ($request) {
                if ($group = $request->input('group')) {
                    $query->wherehas('group', function ($query1) use ($group) {
                        $query1->where('number', 'like', "%{$group}%");
                    });
                };
                if ($subject = $request->input('subject')) {
                    $query->wherehas('subject', function ($query1) use ($subject) {
                        $query1->where('name', 'like', "%{$subject}%");
                    });
                };
                if ($semester = $request->input('semester')) {
                    $query->wherehas('semester', function ($query1) use ($semester) {
                        $query1->where('number', 'like', "%{$semester}%");
                    });
                };
                if ($number_of_hours = $request->input('number_of_hours')) {
                    $query->where('number_of_hours', 'like', "%{$number_of_hours}%");
                };
            })->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = group_subject::count();
        } else {
            $search = $request->input('search.value');
            $trainingPrograms = group_subject:: where('first_name', 'like', "%{$search}%")
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
            $totalFiltered = group_subject::count();
        }
        $data = array();
        if ($trainingPrograms) {
            foreach ($trainingPrograms as $trainingProgram) {
                $nestedData['group'] = $trainingProgram->group->number;
                $nestedData['subject'] = $trainingProgram->subject->name;
                $nestedData['semester'] = $trainingProgram->semester->number;
                $nestedData['number_of_hours'] = $trainingProgram->number_of_hours . " sagat";
                $nestedData['operations'] = '<a onclick="return confirm(\'Are you sure?\')" class="btn btn-danger" href="' . route('trainingProgram.delete', ['trainingProgram_id' => $trainingProgram->id]) . '"> <i class="fa fa-trash"></i>
                                               </a> &nbsp;
                                               <a class="btn btn-primary btn-md" href="' . route('trainingProgram.edit', ['trainingProgram_id' => $trainingProgram->id]) . '"><i class="fa fa-edit"></i>
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

    public function getTrainingProgramsGroupApi(Request $request)
    {
        $columns = array(
            0 => 'group_id',
            1 => 'subject_id',
            2 => 'semester_id',
            3 => 'number_of_hours',
        );
        $role_id = auth()->user()->role[0]->id;
        $group_id = auth()->user()->group_id;

        $totalData = group_subject::where('group_id',$group_id)->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {

            $trainingPrograms = group_subject::where('group_id',$group_id)
                ->orwhere(function ($query) use ($request) {
                    if ($group = $request->input('group')) {
                        $query->wherehas('group', function ($query1) use ($group) {
                            $query1->where('number', 'like', "%{$group}%");
                        });
                    };
                    if ($subject = $request->input('subject')) {
                        $query->wherehas('subject', function ($query1) use ($subject) {
                            $query1->where('name', 'like', "%{$subject}%");
                        });
                    };
                    if ($semester = $request->input('semester')) {
                        $query->wherehas('semester', function ($query1) use ($semester) {
                            $query1->where('number', 'like', "%{$semester}%");
                        });
                    };
                    if ($number_of_hours = $request->input('number_of_hours')) {
                        $query->where('number_of_hours', 'like', "%{$number_of_hours}%");
                    };
                })->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = group_subject::where('group_id',$group_id)->count();
        } else {

            $search = $request->input('search.value');
            $trainingPrograms = group_subject:: where('group_id',$group_id)
                ->orWhere(function ($query) use ($search) {
                    $query->orWherehas('group', function ($query1) use ($search) {
                        $query1->orWhere('number', 'like', "%{$search}%");
                    });
                    $query->orWherehas('student_rank', function ($query1) use ($search) {
                        $query1->where('name', 'like', "%{$search}%");
                    });
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = group_subject::where('group_id',$group_id)->count();
        }
        $data = array();
        if ($trainingPrograms) {
            foreach ($trainingPrograms as $trainingProgram) {
                $nestedData['group'] = $trainingProgram->group->number;
                $nestedData['subject'] = $trainingProgram->subject->name;
                $nestedData['semester'] = $trainingProgram->semester->number;
                $nestedData['number_of_hours'] = $trainingProgram->number_of_hours . " sagat";
                $nestedData['operations'] = '<a onclick="return confirm(\'Are you sure?\')" class="btn btn-danger" href="' . route('trainingProgram.delete', ['trainingProgram_id' => $trainingProgram->id]) . '"> <i class="fa fa-trash"></i>
                                               </a> &nbsp;
                                               <a class="btn btn-primary btn-md" href="' . route('trainingProgram.edit', ['trainingProgram_id' => $trainingProgram->id]) . '"><i class="fa fa-edit"></i>
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

    public function groupCourseSubjects($group_id, $course_id)
    {

        return view('journal.group_subjects')->with([
            'group_id' => $group_id,
            'course_id' => $course_id
        ]);
    }

    public function getSubjectsOfGroupApi(Request $request)
    {
        $columns = array(
            0 => 'group_id',
            1 => 'faculty',
            2 => 'kathedra',
        );
        // $JLD=journal_lesson_date::all();

        $group_id = Crypt::decrypt($request->input('group_id'));
        $course_id = Crypt::decrypt($request->input('course_id'));

        $totalData = group_subject::where(function ($query) use ($group_id, $course_id) {
            $query->wherehas('group', function ($query1) use ($group_id) {
                $query1->where('id', $group_id);
            });
            $query->wherehas('semester', function ($query2) use ($course_id) {
                $query2->wherehas('course', function ($query3) use ($course_id) {
                    $query3->where('id', $course_id);
                });
            });
        })->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {

            $groupSubjects = group_subject::where(function ($query) use ($group_id, $course_id) {
                $query->wherehas('group', function ($query1) use ($group_id) {
                    $query1->where('id', $group_id);
                });
                $query->wherehas('semester', function ($query2) use ($course_id) {
                    $query2->wherehas('course', function ($query3) use ($course_id) {
                        $query3->where('id', $course_id);
                    });
                });
            })->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = group_subject::where(function ($query) use ($group_id, $course_id) {
                $query->wherehas('group', function ($query1) use ($group_id) {
                    $query1->where('id', $group_id);
                });
                $query->wherehas('semester', function ($query2) use ($course_id) {
                    $query2->wherehas('course', function ($query3) use ($course_id) {
                        $query3->where('id', $course_id);
                    });
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
                // $JLD=journal_lesson_date::where('journal_id',$groupSubject->journal->id)->count();
                $nestedData['group'] = $groupSubject->group->number;
                $nestedData['subject'] = $groupSubject->subject->name;
                $nestedData['semester'] = $groupSubject->semester->number;
                $nestedData['hours'] = $groupSubject->number_of_hours;
                $nestedData['operations'] = '<a class="btn btn-info btn-md" href="'
                    . route('groupSubject', [
                        'group_id' => Crypt::encrypt($groupSubject->group->id),
                        'subject_id' => Crypt::encrypt($groupSubject->subject->id),
                        'course_id' => Crypt::encrypt($course_id),
                        'semester_id' => Crypt::encrypt($groupSubject->semester->id),
                    ]) .
                    '"> <i class="fa fa-envelope-open-text"></i>
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

    public function groupSubject($group_id, $subject_id, $course_id, $semester_id)
    {

        $group_id = Crypt::decrypt($group_id);
        $subject_id = Crypt::decrypt($subject_id);
        $course_id = Crypt::decrypt($course_id);
        $semester_id = Crypt::decrypt($semester_id);


        $subject = Subject::findOrFail($subject_id);
        $group = Group::findOrFail($group_id);

        $group_subject = group_subject::where(function ($query) use ($group_id, $subject_id, $course_id, $semester_id) {
            $query->wherehas('group', function ($query1) use ($group_id) {
                $query1->where('id', $group_id);
            });
            $query->wherehas('semester', function ($query2) use ($course_id, $semester_id) {
                $query2->where('id', $semester_id);
                $query2->wherehas('course', function ($query3) use ($course_id) {
                    $query3->where('id', $course_id);
                });
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

        return view('journal.group_subject')->with([
            'subject' => $subject,
            'group' => $group,
            'group_subject' => $group_subject,
            'journal' => $journal,
            'lesson_dates' => $lesson_dates,
            'course_id' => $course_id,
            'assessments' => $assessments,
            'semester_id' => $semester_id,

        ]);
    }
}
