<?php

namespace App\Http\Controllers;

use App\Models\Nationality;
use Illuminate\Http\Request;

class NationalityController extends Controller
{
    public function store(Request $request){

        if($request->has('name'))
        {
            $nationality = new Nationality();
            $nationality->name = $request->name;
            $nationality->save();
        }
        return redirect()->route('studentConfigure');
    }

    public function delete($nationality_id){

        $nationality = Nationality::find($nationality_id);
        $nationality->delete();
        return redirect()->route('studentConfigure');
    }

    public function getNationalitiesApi(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 =>  'name',
        );

        $totalData = Nationality::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value')))  {

            $nationalities = Nationality::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Nationality::count();
        }else

        {
            $search= $request->input('search.value');
            $nationalities = Nationality:: where('name','like',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Nationality::count();
        }
        $data = array();
        if ($nationalities) {
            foreach ($nationalities as $nationality) {
                $nestedData['id'] = $nationality->id;
                $nestedData['name'] = $nationality->name;
                $nestedData['operations'] =  '<a onclick="return confirm(\'Are you sure?\')" class="btn btn-danger" href="#"> <i class="fa fa-trash"></i>
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
