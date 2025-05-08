
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            @can('settings_show')
            <a href="{{route('semester.create')}}" class="btn bg-navbar btn-dark float-right"><i class="fa fa-plus-circle"></i> </a>
            @endcan
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">Sany</th>
            <th scope="col">Wagty</th>
            @can('settings_show')
            <th scope="col">Operasiýalar</th>
            @endcan
        </tr>
        </thead>
        <tbody>
        @foreach($semesters as $semester)
            <tr>
                <td>{{$semester->number}}</td>
                <td>{{$semester->period->start_date}}  --  {{$semester->period->end_date}}</td>
                @can('settings_show')
                <td>
                    <a href="{{route('semester.edit',['semester_id' => $semester->id])}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> </a>
                </td>
                    @endcan
            </tr>
        @endforeach
        </tbody>
    </table>
