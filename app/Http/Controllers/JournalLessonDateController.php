<?php

namespace App\Http\Controllers;

use App\Models\journal_lesson_date;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JournalLessonDateController extends Controller
{
    //add new date for lesson in journal
    public function store(Request $request)
    {
        $request->validate([
            'date_lesson' => 'required',
            'number_lesson' => 'required',
        ]);
        if ($request->number_lesson < 1 or $request->number_lesson > 9) {
            return back();
        } else {
            $date = $request->input('date_lesson');
            $date_convert = Carbon::parse($date)->format("Y-m-d");
            $journal_lesson_date = journal_lesson_date::updateOrCreate(
                ['date_lesson' => $date_convert,
                    'number_lesson' => $request->input('number_lesson'),
                    'journal_id' => $request->input('journal_id'),
                    'teacher_id' => Auth()->user()->teacher->id,
                ]
            );
            return redirect()->back();
        }
    }
    public function updateDate(Request $request)
    {
        $request->validate([
            'dateId' => 'required',
            'number_lesson' => 'required',
            'studentId' => 'required',
        ]);
        if ($request->number_lesson < 1 or $request->number_lesson > 9) {
            return back();
        } else {
            $studentId = $request->studentId;     /* <-----journal_lesson_dates->id==studentId*/
            $date = journal_lesson_date::find($studentId);
            $date->date_lesson = $request->dateId;
            $date->number_lesson = $request->number_lesson;
            $date->save();
            return back();
        }

    }
}
