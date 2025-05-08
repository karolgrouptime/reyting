<?php

namespace App\Http\Controllers;

//use App\Exports\UsersExport;
use App\Models\Log;
use Illuminate\Http\Request;
//use Maatwebsite\Excel\Facades\Excel;

class LogController extends Controller
{
    public function logs(){
        return view('log.logs');
    }

    public function saveExcel(){
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function logsApi(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 =>  'login',
            3 =>  'ip',
            4 =>  'kind',
            5 =>  'created_at',
        );
        $totalData = Log::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value')))  {
            $logs = Log::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Log::count();
        }else

        {
            $search= $request->input('search.value');
            $logs = Log:: where('name','like',"%{$search}%")
                ->orWhere('login','like',"%{$search}%")
                ->orWhere('ip','like',"%{$search}%")
                ->orWhere('kind','like',"%{$search}%")
                ->orWhere('created_at','like',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Log::count();
        }
        $data = array();
        if ($logs) {
            foreach ($logs as $log) {
                $nestedData['full_name'] = $log->name?'<p class="text-center">'.$log->name.'</p>':'<p class="text-center">-</p>';
                $nestedData['login'] = $log->login;
                $nestedData['ip'] = $log->ip;
                if($log->kind==1) {
                    $type = '<p><i class="fa fa-door-open text-success"></i> Girdi</p>';
                }elseif($log->kind==2){
                    $type = '<p><i class="fa fa-door-closed text-info"></i> Çykdy</p>';
                }elseif($log->kind==3){
                    $type = '<p><i class="fa fa-outdent text-danger"></i> Şowsuz</p>';
                }
                $nestedData['kind'] = $type;
                $nestedData['info'] = $log->kind!=3?"[".$log->platform."; ".$log->browser."; ".$log->device."]":"-";
                $nestedData['created_at'] = $log->created_at->toDateTimeString();
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
