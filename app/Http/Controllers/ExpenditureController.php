<?php

namespace App\Http\Controllers;
use App\Models\assessment;
use App\Models\group;
use App\Models\student;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public function index(Request $request)
    {
        Carbon::now()->toDateString();
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
            ->select('groups.name', 'groups.number', 'groups.id', 'groups.kathedra_id', 'journal_lesson_dates.date_lesson')
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
        return view('expenditure.index')->with([
            'para' => $para,
            'date' => $date,
            'groupReportForWeek' => $groupReportForWeek
        ]);
    }
    public function OpenExpenditure($para, $date, $group_id)
    {
        $group_rashods =  Student::leftJoin('lesson_assessments', function ($query) {
            $query->on('lesson_assessments.student_id', '=', 'students.id');
        })->leftJoin('journal_lesson_dates', function ($query) use ($para) {
            $query->on('journal_lesson_dates.id', '=', 'lesson_assessments.lesson_date_id');
            $query->where('journal_lesson_dates.number_lesson', $para);
        })->leftJoin('assessments', function ($query) {
            $query->on('assessments.id', '=', 'lesson_assessments.assessment_id');
        })
            ->where('students.group_id', '=', $group_id)
            ->where('journal_lesson_dates.date_lesson', '=', $date)
            ->where('lesson_assessments.assessment_id', '>', 5)
            ->select('students.last_name', 'students.first_name', 'assessments.value', 'assessments.id', 'journal_lesson_dates.date_lesson','journal_lesson_dates.teacher_id')
            ->orderBy('assessments.value', 'desc')
            ->groupBy('students.id')
            ->get();
        $assessments=Assessment::all();
        $student_count=Student::where('group_id',$group_id)->count();
        $group=Group::find($group_id);
        return view('expenditure.OpenExpenditure')->with([
            'assessments'=>$assessments,
            'student_count'=>$student_count,
            'para' => $para,
            'date' => $date,
            'group' => $group,
            'group_rashods'=>$group_rashods
        ]);
    }
}
