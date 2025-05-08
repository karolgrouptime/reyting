<?php

namespace App\Http\Controllers;
use App\Models\group;
use App\Models\journal;
use App\Models\nationality;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:users');
    }

    public function journals(){
        return view('journal.journals');
    }

    public function getJournalsGroupApi(Request $request)
    {
        $columns = array(
            0 => 'group_id',
            1 =>  'faculty',
            2 =>  'kathedra',
        );
        $role_id=auth()->user()->role[0]->id;
        $group_id= auth()->user()->group_id;
        $total = Journal::groupBy('group_id')->where('group_id',$group_id)->get();

        $totalData = $total->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value')))  {
            $journals = Journal::where('group_id',$group_id)
                ->offset($start)
                ->limit($limit)
                ->groupBy('group_id')
                ->orderBy($order, $dir)
                ->get();
            $total = Journal::groupBy('group_id')->where('group_id',$group_id)->get();
            $totalFiltered = $total->count();
        }else
        {
            $search= $request->input('search.value');
            $journals = Journal:: where('group_id',$group_id)

                ->Where(function($query)use($search){
                    $query->Wherehas('group',function ($query1) use ($search){

                        $query1->Where('number','like',"%{$search}%");

                    });
                })
                ->offset($start)
                ->limit($limit)
                ->groupBy('group_id')
                ->orderBy($order, $dir)
                ->get();
            $total = Journal::groupBy('group_id')->where('group_id',$group_id)->get();
            $totalFiltered = $total->count();
        }
        $data = array();
        if ($journals) {
            foreach ($journals as $journal) {
                if(isset($journal->group->student[0])){
                    $recept_date = $journal->group->student[0]->recept_date;
                    $course = Carbon::now()->diffInYears($recept_date)+1;
                };
                $nestedData['group'] = $journal->group->name.'-('.$journal->group->number.')';
                $nestedData['faculty'] = $journal->group->kathedra->faculty->name;
                $nestedData['kathedra'] = $journal->group->kathedra->name;
                $nestedData['group_course_subjects'] = '<a class="btn btn-success btn-sm"  href="'.route('groupCourseSubjects',['group_id'=>Crypt::encrypt($journal->group->id),'course_id'=>Crypt::encrypt('1')]).'"><span>1</span></a>'.
                    '</a> &nbsp;<a class="btn btn-success btn-sm" href="'.route('groupCourseSubjects',['group_id'=>Crypt::encrypt($journal->group->id),'course_id'=>Crypt::encrypt('2')]).'"> <span>2</span>
                                               </a> &nbsp;<a class="btn btn-success btn-sm" href="'.route('groupCourseSubjects',['group_id'=>Crypt::encrypt($journal->group->id),'course_id'=>Crypt::encrypt('3')]).'"> <span>3</span>
                                               </a> &nbsp;<a class="btn btn-success btn-sm" href="'.route('groupCourseSubjects',['group_id'=>Crypt::encrypt($journal->group->id),'course_id'=>Crypt::encrypt('4')]).'"> <span>4</span>
                                               </a> &nbsp;<a class="btn btn-success btn-sm" href="'.route('groupCourseSubjects',['group_id'=>Crypt::encrypt($journal->group->id),'course_id'=>Crypt::encrypt('5')]).'"> <span>5</span>
                                               </a> &nbsp;<a class="btn btn-info btn-sm" href="'.route('groupCertification',['group_id'=>Crypt::encrypt($journal->group->id)]).'"> Umumy
                                               </a> &nbsp;';
                $nestedData['course'] = "-";
                $nestedData['operations'] =    '<a onclick="return confirm(\'Are you sure?\')" class="btn btn-danger" href="'.route('journal.delete',['journal_id'=>$journal->id]).'"> <i class="fa fa-trash"></i>
                                               </a> &nbsp;
                                               <a class="btn btn-primary btn-md" href="'.route('journal.edit',['journal_id'=>$journal->id]).'"><i class="fa fa-edit"></i>
                                               </a> &nbsp;';
                $course=NULL;
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

    public function getJournalsApi(Request $request)
    {
        $columns = array(
            0 => 'group_id',
            1 =>  'faculty',
            2 =>  'kathedra',
        );
        $total = Journal::groupBy('group_id')->get();
        $totalData = $total->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value')))  {

            $journals = Journal::offset($start)
                ->limit($limit)
                ->groupBy('group_id')
                ->orderBy($order, $dir)
                ->get();
            $total = Journal::groupBy('group_id')->get();
            $totalFiltered = $total->count();

        }else
        {
            $search= $request->input('search.value');
            $journals = Journal::Where(function($query)use($search){
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

            })
                ->offset($start)
                ->limit($limit)
                ->groupBy('group_id')
                ->orderBy($order, $dir)
                ->get();
            $total = Journal::groupBy('group_id')->get();
            $totalFiltered = $total->count();
        }
        $data = array();
        if ($journals) {
            foreach ($journals as $journal) {

                if(isset($journal->group->student[0])){
                    $recept_date = $journal->group->student[0]->recept_date;
                    $course = Carbon::now()->diffInYears($recept_date)+1;
                } else{
                    $course='ht ýok';
                }

                $nestedData['group'] = $journal->group->name.' ('.$journal->group->number.')';
                $nestedData['faculty'] = $journal->group->kathedra->faculty->name;
                $nestedData['kathedra'] = $journal->group->kathedra->name;
                $nestedData['group_course_subjects'] = '<a class="btn btn-success btn-sm"  href="'.route('groupCourseSubjects',['group_id'=>Crypt::encrypt($journal->group->id),'course_id'=>Crypt::encrypt('1')]).'"><span>1</span></a>'.
                    '</a> &nbsp;<a class="btn btn-success btn-sm" href="'.route('groupCourseSubjects',['group_id'=>Crypt::encrypt($journal->group->id),'course_id'=>Crypt::encrypt('2')]).'"> <span>2</span>
                                               </a> &nbsp;<a class="btn btn-success btn-sm" href="'.route('groupCourseSubjects',['group_id'=>Crypt::encrypt($journal->group->id),'course_id'=>Crypt::encrypt('3')]).'"> <span>3</span>
                                               </a> &nbsp;<a class="btn btn-success btn-sm" href="'.route('groupCourseSubjects',['group_id'=>Crypt::encrypt($journal->group->id),'course_id'=>Crypt::encrypt('4')]).'"> <span>4</span>
                                               </a> &nbsp;<a class="btn btn-success btn-sm" href="'.route('groupCourseSubjects',['group_id'=>Crypt::encrypt($journal->group->id),'course_id'=>Crypt::encrypt('5')]).'"> <span>5</span>
                                               </a>
                                               &nbsp;<a class="btn btn-info btn-sm" href="'.route('groupCertification',['group_id'=>Crypt::encrypt($journal->group->id)]).'">j
                                               </a> &nbsp;';
                $nestedData['course'] = $course;
                $nestedData['operations'] =    '<a onclick="return confirm(\'Are you sure?\')" class="btn btn-danger" href="'.route('journal.delete',['journal_id'=>$journal->group->id]).'"> <i class="fa fa-trash"></i>
                                               </a> &nbsp;
                                               <a class="btn btn-primary btn-md" href="'.route('journal.edit',['journal_id'=>$journal->id]).'"><i class="fa fa-edit"></i>
                                               </a> &nbsp;';
                $course=NULL;
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

    public function getJournalsTeacherApi(Request $request)
    {
        $columns = array(
            0 => 'group_id',
            1 =>  'faculty',
            2 =>  'kathedra',
        );

        $totalData = Journal::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value')))  {

            $journals = Journal::offset($start)
                ->limit($limit)
                ->groupBy('group_id')
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Journal::count();
        }else

        {
            $search= $request->input('search.value');
            $journals = Journal:: where('first_name','like',"%{$search}%")
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
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Student::count();
        }
        $data = array();
        if ($journals) {
            foreach ($journals as $journal) {
                $nestedData['group'] = $journal->group->number;
                $nestedData['faculty'] = $journal->group->kathedra->faculty->name;
                $nestedData['kathedra'] = $journal->group->kathedra->name;
                $nestedData['group_subject'] = '<a class="btn btn-success btn-sm" href="'.route('groupSubjects',['group_id'=>$journal->group->id,'course_id'=>1]).'"> <span>1</span>
                                               </a> &nbsp;<a class="btn btn-success btn-sm" href="'.route('groupSubjects',['group_id'=>$journal->group->id]).'"> <span>2</span>
                                               </a> &nbsp;<a class="btn btn-success btn-sm" href="'.route('groupSubjects',['group_id'=>$journal->group->id]).'"> <span>3</span>
                                               </a> &nbsp;<a class="btn btn-success btn-sm" href="'.route('groupSubjects',['group_id'=>$journal->group->id]).'"> <span>4</span>
                                               </a> &nbsp;<a class="btn btn-success btn-sm" href="'.route('groupSubjects',['group_id'=>$journal->group->id]).'"> <span>5</span>
                                               </a> &nbsp;<a class="btn btn-info btn-md" href="'.route('groupSubjects',['group_id'=>$journal->group->id]).'"> Umumy
                                               </a> &nbsp;';
                $nestedData['operations'] =    '<a onclick="return confirm(\'Are you sure?\')" class="btn btn-danger" href="'.route('journal.delete',['journal_id'=>$journal->id]).'"> <i class="fa fa-trash"></i>
                                               </a> &nbsp;
                                               <a class="btn btn-primary btn-md" href="'.route('journal.edit',['journal_id'=>$journal->id]).'"><i class="fa fa-edit"></i>
                                               </a> &nbsp;
                                                <a class="btn btn-info btn-md" href="'.route('journal.profile',['journal_id'=>$journal->id]).'"> <i class="fa fa-file-o"></i>
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
