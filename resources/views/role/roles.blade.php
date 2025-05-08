
<div class="row my-3 mx-1">
    <div class="col-md-12 text-right">
        <a href="{{route('role.create')}}" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"></i> </a>
    </div>
</div>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th scope="col">ADY</th>
        <th scope="col">Rugsatlar</th>
        <th scope="col">Operasiýalar</th>
    </tr>
    </thead>
    <tbody>
    @foreach($roles as $role)
        <tr>
            <td>{{$role->name}}</td>
            <td>
                @foreach($role->permission as $permission)
                    {{$permission->name}}@if (!$loop->last),@else. @endif
                @endforeach
            </td>
            <td>
                <a href="{{route('role.delete',['role_id' => $role->id])}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </a>
                <a href="{{route('role.edit',['role_id' => $role->id])}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<!--modal for assessment add-->
<div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('role.store')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header text-center ">
                    <h4 class="modal-title"> Täze rol</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-2">
                    <label>Ady:</label>
                    <div class="input-group">
                        <input type="char" name="name" class="form-control">
                    </div>
                </div>
                <div class="modal-footer d-flex">
                    <input type="submit" class="btn btn-primary float-right" value="Goş"/>
                </div>
            </form>
        </div>
    </div>
</div>
<!--modal for assessment add-->
