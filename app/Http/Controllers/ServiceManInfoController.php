<?php

namespace App\Http\Controllers;

use App\Models\Kathedra;
use App\Models\Faculty;
use App\Models\Nationality;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceManInfoController extends Controller
{
    public function studentConfigure(){
        $kathedras = Kathedra::all();
        return view('studentConfigure.index')->with([
            'kathedras' => $kathedras,
        ]);
    }

    public function index() {
        $facultyStudents =  Faculty::leftJoin('kathedras',function($query){
            $query->on('faculties.id','=','kathedras.faculty_id');
        })->leftJoin('groups',function($query){
            $query->on('groups.kathedra_id','=','kathedras.id');
        })->leftJoin('students',function($query){
            $query->on('students.group_id','=','groups.id');
        })
            ->select('faculties.name')
            ->addSelect(DB::raw('COUNT(students.id) as count'))
            ->orderBy('count','desc')
            ->groupBy('faculties.name')
            ->get();

        $nationalityStudents =  Nationality::leftJoin('students',function($query){
            $query->on('nationalities.id','=','students.nationality_id');
        })->select('nationalities.name')
            ->addSelect(DB::raw('COUNT(students.id) as count'))
            ->orderBy('count','desc')
            ->groupBy('nationalities.name')
            ->get();

        $countPositionTeachers =  Position::leftJoin('teachers',function($query){
            $query->on('positions.id','=','teachers.position_id');
        })->select('positions.name')
            ->addSelect(DB::raw('COUNT(teachers.id) as count'))
            ->orderBy('count','desc')
            ->groupBy('positions.name')
            ->get();

        return view('serviceManInfo.index')->with([
            'facultyStudents' => $facultyStudents,
            'nationalityStudents' => $nationalityStudents,
            'countPositionTeachers' => $countPositionTeachers,
        ]);
    }
}
