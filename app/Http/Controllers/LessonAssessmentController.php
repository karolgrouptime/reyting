<?php

namespace App\Http\Controllers;

use App\Models\assessment;
use App\Models\lesson_assessment;
use Illuminate\Http\Request;

class LessonAssessmentController extends Controller
{
    public function index(){
        return view('report.index');
    }

    public function assessmentMake(Request $request){
        $assessment_check_id = Assessment::where('id',$request->input('assessment'))->first();
        if($assessment_check_id){
            $lesson_assessment = lesson_assessment::updateOrcreate(
                ['student_id' => $request->input('student_id'),
                    'lesson_date_id' => $request->input('lesson_date_id'),
                ],['assessment_id' => $request->input('assessment')]
            );
        }
        return redirect()->back();
    }

    public function assessmentEdit(Request $request){
        $assessmentId = $request->assessmentId;
        $studentId = $request->studentId;
        $dateId = $request->dateId;
        $subjectId = $request->subject_id;
//        $date_lesson = $request->lessonDate;
        $lesId = $request->lesId;
//        if ($lesId<5 and $assessmentId<6 and $assessmentId>1) {
//            return redirect()->back();
//        }

        if($assessmentId==0) {
            $lesson_assessment = lesson_assessment::where('lesson_date_id',$dateId)->where('student_id',$studentId)->delete();
        } else {
            $lesson_assessment = lesson_assessment::updateOrcreate(
                [
                    'student_id' => $studentId,
                    'lesson_date_id' => $dateId,
                    'teacher_id' => auth()->user()->teacher->id,
                ],
                [
                    'subject_id'=> $subjectId,
                    'assessment_id' => $assessmentId,
                ]
            );
        }
        return redirect()->back();
    }
}
