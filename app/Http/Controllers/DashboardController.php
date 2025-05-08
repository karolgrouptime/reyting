<?php

namespace App\Http\Controllers;
use App\Models\Group;
use App\Models\Student;
use App\Models\lesson_assessment;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index()
    {
        $student_reports = lesson_assessment::leftJoin('journal_lesson_dates', 'journal_lesson_dates.id', '=', 'lesson_assessments.lesson_date_id')
            ->where('journal_lesson_dates.date_lesson', '>=', Carbon::now()->startOfWeek()->toDateString())
            ->where('journal_lesson_dates.date_lesson', '<=', Carbon::now()->endOfWeek()->toDateString())
            ->where('assessment_id', 5)
            ->select('student_id')
            ->addSelect(DB::raw('COUNT(CASE WHEN assessment_id = ' . 5 . ' THEN 0 END) as five'))
            ->groupBy('student_id')
            ->take(10)
            ->orderBy('five', 'desc')
            ->get();
        $student_reports_two = lesson_assessment::leftJoin('journal_lesson_dates', 'journal_lesson_dates.id', '=', 'lesson_assessments.lesson_date_id')
            ->where('journal_lesson_dates.date_lesson', '>=', Carbon::now()->startOfWeek()->toDateString())
            ->where('journal_lesson_dates.date_lesson', '<=', Carbon::now()->endOfWeek()->toDateString())
            ->where('assessment_id', 2)
            ->select('student_id')
            ->addSelect(DB::raw('COUNT(CASE WHEN assessment_id = ' . 2 . ' THEN 0 END) as deuce'))
            ->groupBy('student_id')
//            ->take(50)
            ->orderBy('deuce', 'desc')
            ->get();
        $loseGroups = Group::take(10)->get();
        $bestGroups = Group::take(10)->get();
        $students = Student::all();
        return view('dashboard.index')->with([
            'loseGroups' => $loseGroups,
            'students' => $students,
            'student_reports' => $student_reports,
            'student_reports_two' => $student_reports_two
        ]);
    }

    public function bestGroups()
    {
        $bestGroupsWeekNames = Group::leftJoin('journals', function ($query) {
            $query->on('groups.id', '=', 'journals.group_id');
        })->leftJoin('journal_lesson_dates', function ($query) {
            $query->on('journals.id', '=', 'journal_lesson_dates.journal_id');
            $query->where('journal_lesson_dates.date_lesson', '>=', Carbon::now()->startOfWeek()->toDateString())
                ->where('journal_lesson_dates.date_lesson', '<=', Carbon::now()->endOfWeek()->toDateString());
        })->leftJoin('lesson_assessments', function ($query) {
            $query->on('journal_lesson_dates.id', '=', 'lesson_assessments.lesson_date_id');
        })->leftJoin('assessments', function ($query) {
            $query->on('assessments.id', '=', 'lesson_assessments.assessment_id');
            $query->whereBetween('assessments.id', array(2, 5));
        })
            ->whereBetween('assessments.id', array(2, 5))
            ->groupBy('groups.id')
            ->skip(0)
            ->take(15)
            ->select('groups.number', DB::raw('avg(assessments.value) AS average'))
            ->orderBy('average', 'desc')
            ->pluck('number')->toArray();

        $bestGroupsWeekNames = Arr::prepend($bestGroupsWeekNames, "");
        array_push($bestGroupsWeekNames, "");

        $bestGroupsWeekValues = Group::leftJoin('journals', function ($query) {
            $query->on('groups.id', '=', 'journals.group_id');
        })->leftJoin('journal_lesson_dates', function ($query) {
            $query->on('journals.id', '=', 'journal_lesson_dates.journal_id');
            $query->where('journal_lesson_dates.date_lesson', '>=', Carbon::now()->startOfWeek()->toDateString())
                ->where('journal_lesson_dates.date_lesson', '<=', Carbon::now()->endOfWeek()->toDateString());
        })->leftJoin('lesson_assessments', function ($query) {
            $query->on('journal_lesson_dates.id', '=', 'lesson_assessments.lesson_date_id');
        })->leftJoin('assessments', function ($query) {
            $query->on('assessments.id', '=', 'lesson_assessments.assessment_id');
            $query->whereBetween('assessments.id', array(2, 5));
        })
            ->whereBetween('assessments.id', array(2, 5))
            ->groupBy('groups.id')
            ->skip(0)
            ->take(15)
            ->select('groups.number', DB::raw('avg(assessments.value) AS average'))
            ->orderBy('average', 'desc')
            ->pluck('average')->toArray();

        $bestGroupsWeekValues = Arr::prepend($bestGroupsWeekValues, 0);
        array_push($bestGroupsWeekValues, 0);


        return [
            'labels' => $bestGroupsWeekNames,
            'datasets' => array([
                'label' => 'Bahalar',
                'backgroundColor' => ['green', 'green', 'green', 'green', 'green', 'green', 'green', 'green', 'green', 'green', 'green', 'green', 'green', 'green', 'green', 'green'],
                'data' => $bestGroupsWeekValues,
            ])
        ];
    }

    public function worseGroups()
    {
        $worseGroupsWeekNames = Group::leftJoin('journals', function ($query) {
            $query->on('groups.id', '=', 'journals.group_id');
        })->leftJoin('journal_lesson_dates', function ($query) {
            $query->on('journals.id', '=', 'journal_lesson_dates.journal_id');
            $query->where('journal_lesson_dates.date_lesson', '>=', Carbon::now()->startOfWeek()->toDateString())
                ->where('journal_lesson_dates.date_lesson', '<=', Carbon::now()->endOfWeek()->toDateString());
        })->leftJoin('lesson_assessments', function ($query) {
            $query->on('journal_lesson_dates.id', '=', 'lesson_assessments.lesson_date_id');
        })->leftJoin('assessments', function ($query) {
            $query->on('assessments.id', '=', 'lesson_assessments.assessment_id');
            $query->whereBetween('assessments.id', array(2, 5));
        })
            ->whereBetween('assessments.id', array(2, 5))
            ->groupBy('groups.id')
            ->skip(0)
            ->take(15)
            ->select('groups.number', DB::raw('avg(assessments.value) AS average'))
            ->orderBy('average', 'asc')
            ->pluck('number')->toArray();

        $worseGroupsWeekNames = Arr::prepend($worseGroupsWeekNames, "");
        array_push($worseGroupsWeekNames, "");

        $worseGroupsWeekValues = Group::leftJoin('journals', function ($query) {
            $query->on('groups.id', '=', 'journals.group_id');
        })->leftJoin('journal_lesson_dates', function ($query) {
            $query->on('journals.id', '=', 'journal_lesson_dates.journal_id');
            $query->where('journal_lesson_dates.date_lesson', '>=', Carbon::now()->startOfWeek()->toDateString())
                ->where('journal_lesson_dates.date_lesson', '<=', Carbon::now()->endOfWeek()->toDateString());
        })->leftJoin('lesson_assessments', function ($query) {
            $query->on('journal_lesson_dates.id', '=', 'lesson_assessments.lesson_date_id');
        })->leftJoin('assessments', function ($query) {
            $query->on('assessments.id', '=', 'lesson_assessments.assessment_id');

            $query->whereBetween('assessments.id', array(2, 5));
        })
            ->whereBetween('assessments.id', array(2, 5))
            ->groupBy('groups.id')
            ->skip(0)
            ->take(15)
            ->select('groups.number', DB::raw('avg(assessments.value) AS average'))
            ->orderBy('average', 'asc')
            ->pluck('average')->toArray();

        $worseGroupsWeekValues = Arr::prepend($worseGroupsWeekValues, 0);
        array_push($worseGroupsWeekValues, 0);

        return [
            'labels' => $worseGroupsWeekNames,
            'datasets' => array([
                'label' => 'Bahalar',
                'backgroundColor' => ['red', 'red', 'red', 'red', 'red', 'red', 'red', 'red', 'red', 'red', 'red', 'red', 'red', 'red', 'red', 'red'],
                'data' => $worseGroupsWeekValues,
            ])
        ];

    }

    public function reyting()
    {
        $student_reytings = lesson_assessment::leftJoin('journal_lesson_dates', 'journal_lesson_dates.id', '=', 'lesson_assessments.lesson_date_id')
            ->where('journal_lesson_dates.date_lesson', '>=', '2024-03-01')
            ->where('journal_lesson_dates.date_lesson', '<=', '2024-03-30')
            ->where('journal_lesson_dates.number_lesson', 07)
            ->whereBetween('assessment_id', array(2, 5))
            ->select('student_id', DB::raw('avg(lesson_assessments.assessment_id) AS average'))
            ->groupBy('student_id')
            ->take(1000)
            ->orderBy('average', 'desc')
            ->get();

        return view('dashboard.reyting')->with([
            'student_reytings' => $student_reytings
        ]);
    }
}
