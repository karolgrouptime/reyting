
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            <a href="{{route('degree.create')}}" class="btn bg-navbar btn-dark float-right"><i class="fa fa-plus-circle"></i> </a>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">Ady</th>
            <th scope="col">Operasiýalar</th>
        </tr>
        </thead>
        <tbody>
        @foreach($degrees as $degree)
            <tr>
                <td>{{$degree->name}}</td>
                <td><a href="{{route('degree.edit',['degree_id' => $degree->id])}}" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i></a>
                    <a href="{{route('degree.delete',['degree_id' => $degree->id])}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
