
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            @can('settings_show')
            <a href="{{route('position.create')}}" class="btn bg-navbar btn-dark float-right"><i class="fa fa-plus-circle"></i> </a>
                @endcan
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">Ady</th>
            @can('settings_show')
            <th scope="col">Operasiýalar</th>
            @endcan
        </tr>
        </thead>
        <tbody>
        @foreach($positions as $position)
            <tr>
                <td>{{$position->name}}</td>
                @can('settings_show')
                <td><a href="{{route('position.edit',['position_id' => $position->id])}}" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i></a>
                    <a href="{{route('position.delete',['position_id' => $position->id])}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </a>
                </td>
                    @endcan
            </tr>
        @endforeach
        </tbody>
    </table>

