<?php

namespace App\Http\Controllers;
use App\Models\group;
use App\Models\kathedra;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function store(Request $request){
        if($request->has('name'))
        {
            $group = new Group();
            $group->name = $request->name;
            $group->slug = Str::slug(9);
            $group->number = $request->number;
            $group->kathedra_id = $request->kathedra_id;
            $group->save();
        }
        return redirect()->route('studentConfigure');
    }

    public function delete($group_id){

        $group = Group::find($group_id);
        $group->delete();
        return redirect()->route('studentConfigure');

    }

    public function edit($group_id){
        $group = Group::find($group_id);
        $kathedries = Kathedra::all();
        return view('studentConfigure.groupEdit')->with([
            'group'=> $group,
            'kathedries'=>$kathedries,
        ]);
    }

    public function update($group_id,Request $request){

        $request->validate([
            'name'=>'required',
        ]);

        $group = Group::findOrFail($group_id);
        $group->number = $request->number;
        $group->name = $request->name;
        $group->kathedra_id = $request->kathedra_id;
        $group->save();

        return redirect()->route('studentConfigure')->with([
            'success'=>'Topar üýtgedildi',
        ]);
    }

    public function getGroupsApi(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 =>  'name',
            2 =>  'number',
            3 =>  'kathedra_id',
        );
        $totalData = Group::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value')))  {

            $groups = Group::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Group::count();
        }else

        {
            $search= $request->input('search.value');
            $groups = Group:: where('name','like',"%{$search}%")

                ->orwhere('number','like',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Group::count();
        }
        $data = array();
        if ($groups) {
            foreach ($groups as $group) {
                $nestedData['id'] = $group->id;
                $nestedData['name'] = $group->name;
                $nestedData['number'] = $group->number;
                $nestedData['kathedra'] = $group->kathedra->name;
                $nestedData['faculty'] = $group->kathedra->faculty->name;
                if($group->active==1) {
                    $lock ='<a class="btn btn-info" href="'.route('group.block', ['group_id' => $group->id]).'"> <i class="fa fa-unlock"></i>
                        </a>&nbsp;';
                }
                else {
                    $lock = '<a class="btn btn-danger" href="'.route('group.open', ['group_id' => $group->id]).'"> <i class="fa fa-lock"></i>
                        </a>&nbsp;';
                }
                $nestedData['operations'] = $lock. '&nbsp; &nbsp; <a class="btn btn-primary btn-md" href="'.route('group.edit',['group_id'=>$group->id]).'"> <i class="fa fa-edit"></i>
                                               </a> <a onclick="return confirm(\'Are you sure?\')" class="btn btn-danger" href="'.route('group.delete',['group_id'=>$group->id]).'"> <i class="fa fa-trash"></i>
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

    public function block($group_id){
        $group = Group::find($group_id);
        $group->update([
            'active' => 0
        ]);
        return redirect()->route('studentConfigure')->with([
            'success'=>'Topar '.$group->number.' '.$group->name.' arhiwlendi',
        ]);
    }

    public function open($group_id){
        $group = Group::find($group_id);
        $group ->update([
            'active' => 1
        ]);
        return redirect()->route('studentConfigure')->with([
            'success'=>'Topar '.$group->number.' '.$group->name.' açyldy',
        ]);
    }
}
