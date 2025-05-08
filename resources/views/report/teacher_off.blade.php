<div class="row my-3 mx-1">
    <div class="col-md-12 text-right">
        @if(auth()->user()->teacher->kathedra->status==0)
        <a onclick="return confirm('Maglumatlar diňe bir gezek ugradylýar.')" href="{{route('report.send',['kathedra_id'=>auth()->user()->teacher->kathedra_id])}}" class="btn bg-navbar btn-dark float-right m-1"> <i class="fa fa-play-circle"></i> Ugratmak </a>
        @endif
    </div>
</div>
<table id="teacher_off" class="table table-bordered table-hover" style="width:100%">
    <thead>
    <tr>
        <th scope="col">Ýagdaý</th>
        <th scope="col">F.A.a</th>
        <th scope="col">Kafedra</th>
        <th scope="col">Wezipesi</th>
        <th scope="col">Doglan güni</th>
        <th scope="col">Nomeri</th>
        <th scope="col">Sene we bellik</th>
        <th scope="col">Operasiýalar</th>
    </tr>
    </thead>
    <tbody>
    @foreach($teach_reports as $teacher_load)
        @php($assessment_count=App\LessonAssessment::where('updated_at', '>=', Carbon\Carbon::now()->startOfWeek()->toDateString())->where('updated_at', '<=', Carbon\Carbon::now()->endOfWeek()->toDateString())
        ->where('teacher_id',$teacher_load->id)->count())
        <tr>
          
                <td> - </td>
         
            <td>{{$teacher_load->last_name}} {{$teacher_load->first_name}} {{$teacher_load->father_name}}</td>
            <td> {{$teacher_load->kathedra->name}} </td>
                @if($teacher_load->position)
                    <td> {{$teacher_load->position->name}} </td>
                @else
                    <td> - </td>
                @endif
                <td>{{$teacher_load->birth}}</td>
                <td>{{$teacher_load->phone}}</td>
            @if($teacher_load->total_count==0)
                <th>
                    <span class="badge badge-danger badge-pill">{{$teacher_load->total_count}} </span>
                </th>
                @else
                <th>
                    <span class="badge badge-success badge-pill">{{$teacher_load->total_count}}</span> - <span class="badge badge-success badge-pill">{{$assessment_count}} </span>
                </th>
            @endif
            <th scope="col"><a href="{{route('teacher.teacherEdit', ['teacher_id' => $teacher_load->id])}}"><span class="badge badge-success badge-pill">Üýtgetmek</span></a> </th>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#teacher_off').DataTable({
            "pageLength": 10,
            "responsive": true,
            order: false,
            mark: true,
            language: {
                emptyTable:       "Ders tapylmady",
                info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                infoEmpty:        "0 ders görkezilýär",
                infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                infoPostFix:      "",
                lengthMenu:       "Görkez _MENU_ ",
                loadingRecords:   "Ýüklenýär...",
                processing:       "Dowam edýär...",
                search:           "Gözleg",
                zeroRecords:      "Gözlegiňize göra maglumat tapylmady :(",
                paginate: {
                    first:        "Ilkinji",
                    previous:     "Öňki",
                    next:         "Indiki",
                    last:         "Soňky"
                }
            }
        });
    });

</script>