<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Group;
use App\Models\group_subject;
use App\Models\Journal;
use App\Models\journal_lesson_date;
use App\Models\Kathedra;
use App\Models\Subject;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function report()
    {
        $kathedras = Kathedra::all();
        return view('report.report')->with([
            'kathedras' => $kathedras,
        ]);
    }

    public function SendReport($kathedra_id)
    {
        if (\auth()->user()->teacher->position->id == 4) {
            $kathedra = kathedra::find($kathedra_id);
            if ($kathedra->status == 1) {
                return back()->with([
                    'error' => ' Hormatly ' . \auth()->user()->teacher->last_name . ' ' . \auth()->user()->teacher->first_name . '  maglumatlar bir gezek ugradylýar.',
                ]);
            } else
                $kathedra->update([
                    'status' => 1
                ]);
            return redirect()->route('teacher.setting')->with([
                'success' => ' Hormatly ' . \auth()->user()->teacher->last_name . ' ' . \auth()->user()->teacher->first_name . '  maglumatlar ugradyldy.',
            ]);
        }
        return back()->with([
            'error' => 'Diňe Kafedra müdiri ugradyp biler...',
        ]);
    }

    public function block($kathedra_id)
    {
        if (auth()->user()->can('settings_show')) {
            $kathedra = kathedra::find($kathedra_id);
            $kathedra->update([
                'status' => 0
            ]);
            return redirect()->route('report')->with([
                'success' => ' Hormatly ' . \auth()->user()->last_name . ' ' . \auth()->user()->first_name . '  maglumatlar yzyna ugradyldy.',
            ]);
        }
    }

    public function ReportKathedra($kathedra_id)
    {
        $teach_reports = Teacher::LeftJoin('journal_lesson_dates', 'journal_lesson_dates.teacher_id', '=', 'teachers.id')
            ->where('teachers.kathedra_id', $kathedra_id)
            ->select('teachers.last_name', 'teachers.first_name', 'teachers.father_name', 'teachers.id', 'teachers.position_id', 'teachers.birth', 'teachers.phone', 'teachers.kathedra_id')
            ->addSelect(DB::raw('COUNT(CASE WHEN journal_lesson_dates.number_lesson AND (journal_lesson_dates.date_lesson BETWEEN "' . Carbon::now()->startOfWeek()->toDateString() . ' " AND "' . Carbon::now()->endOfWeek()->toDateString() . ' ")    THEN 0 END) as total_count'))
            ->groupBy('teachers.id')
//            ->skip(0)
//            ->take(15)
            ->orderBy('total_count', 'desc')
            ->get();
        $kathedra = Kathedra::findOrFail($kathedra_id);
        return view('report.reportKathedra')->with([
            'teach_reports' => $teach_reports,
            'kathedra' => $kathedra,
        ]);
    }

    public function GroupPreparation()
    {
        return view('report.report_group_preparation');
    }

    public function preparationApi(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'number',
        );
        $kathedra_id = auth()->user()->teacher->kathedra->id;
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

            $endOneSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-01-20')->toDateString();
            $startTwoSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-02-13')->toDateString();
            $endTwoSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-07-24')->toDateString();
            $startThreeSem = Carbon::createFromFormat('Y-m-d', $y_1 . '-08-05')->toDateString();

            $endThreeSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-01-20')->toDateString();
            $startFourSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-02-13')->toDateString();
            $endFourSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-07-24')->toDateString();
            $startFiveSem = Carbon::createFromFormat('Y-m-d', $y_2 . '-08-05')->toDateString();

            $endFiveSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-01-20')->toDateString();
            $startSixSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-02-13')->toDateString();
            $endSixSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-07-24')->toDateString();
            $startSevenSem = Carbon::createFromFormat('Y-m-d', $y_3 . '-08-05')->toDateString();

            $endSevenSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-01-20')->toDateString();
            $startEightSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-02-13')->toDateString();
            $endEightSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-07-24')->toDateString();
            $startNineSem = Carbon::createFromFormat('Y-m-d', $y_4 . '-08-05')->toDateString();

            $endNineSem = Carbon::createFromFormat('Y-m-d', $y_5 . '-01-20')->toDateString();
            $startTenSem = Carbon::createFromFormat('Y-m-d', $y_5 . '-02-13')->toDateString();
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
        $totalData = Group::where('kathedra_id', $kathedra_id)->where('active', 1)->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $groups = Group::where('kathedra_id', $kathedra_id)->where('active', 1)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Group::where('kathedra_id', $kathedra_id)->where('active', 1)->count();
        } else {
            $search = $request->input('search.value');
            $groups = Group::where('kathedra_id', $kathedra_id)->where('active', 1)->where('name', 'like', "%{$search}%")
                ->orwhere('number', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Group::where('kathedra_id', $kathedra_id)->where('active', 1)->count();
        }
        $data = array();
        if ($groups) {
            foreach ($groups as $group) {
                $i=0;
                $current_semester = currentSemester($group->id);
                if($group_subject=group_subject::where('group_id',$group->id)->where('subject_id',629)->where('semester_id',$current_semester)->count()){
                    $i=1;
                } else {
                    $i=0;
                }
                $nestedData['id'] = $group->id;
                $nestedData['name'] = $group->name;
                $nestedData['number'] = $group->number;
                $nestedData['kathedra'] = $group->kathedra->name;
                $nestedData['faculty'] = $current_semester;
                if ($i == 0) {
                    $lock = '<a class="btn bg-navbar btn-md" href="'.route('preparation.store',['group_id'=>$group->id,'semester_id'=>$current_semester]).'"><i class="fa fa-envelope-open-text">&nbsp;&nbsp;G o ş m a k&nbsp;&nbsp;</i></a>&nbsp;';
                } else {
                    $lock = '<a class="btn btn-success  btn-md" href="'.route('preparation.journalOpen',['group_id'=>$group->id,'semester_id'=>$current_semester]).'"> <span class="fa fa-envelope-open-text"">&nbsp;&nbsp; G i r m e k &nbsp;&nbsp;</span> </a>&nbsp;';
                }
                $nestedData['operations'] = $lock;
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

    public function PreparationStore($group_id, $semester_id)
    {
        $random = rand(1, 100);
        $teacher_id = Auth()->user()->teacher->id;

        $groupSubject = new group_subject();
        $groupSubject->group_id = $group_id;
        $groupSubject->subject_id = 629;
        $groupSubject->semester_id = $semester_id;
        $groupSubject->number_of_hours = $random;
        $groupSubject->save();

        $journal = new Journal();
        $journal->group_id = $group_id;
        $journal->group_subject_id = $groupSubject->id;
        $journal->save();

        if ($group_subject = group_subject::where('semester_id', $semester_id)
            ->where('group_id', $group_id)
            ->where('subject_id', 629)
            ->where('number_of_hours', $groupSubject->number_of_hours)
            ->first()) {

            $teacherGroupSubject = new TeacherGroupSubject();
            $teacherGroupSubject->group_subject_id = $group_subject->id;
            $teacherGroupSubject->teacher_id = $teacher_id;
            $teacherGroupSubject->save();
        }
        return back()->with([
            'success' => 'Maglumatlar goşuldy!!'
        ]);
    }
    public function ReportgroupPreparation($group_id, $semester_id)
    {
        $subject_id = 629;
        $subject = Subject::findOrFail($subject_id);
        $group = Group::findOrFail($group_id);
        if($group->kathedra->id == auth()->user()->teacher->kathedra->id){
            $rate_can=1;
        }else { $rate_can=0;}

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
}
