<div class="row my-3 mx-1">
    <div class="col-md-12 text-right">
        <a href="#" data-toggle="modal" data-target="#addLoad" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"> </i> Meýilnama goş </a>
    </div>
</div>
<table id="teacher_pro" class="table table-bordered table-hover" style="width:100%">
    <thead>
    <tr>
        <th scope="col">Topar</th>
        <th scope="col">Ders</th>
        <th scope="col">Semestr-sagat</th>
        <th scope="col">Operasiýalar</th>
    </tr>
    </thead>
    <tbody>
    @foreach($teacher_loads as $teacher_load)
        <tr>
            <td>{{$teacher_load->groupSubject->group->number}}-{{$teacher_load->groupSubject->group->name}}</td>
            <td>{{$teacher_load->groupSubject->subject->name}}</td>
            <td>{{$teacher_load->groupSubject->semester->number}} -{{$teacher_load->groupSubject->number_of_hours}}</td>
            <td><a href="{{route('loadTeacher.delete',['load_id'=>(Crypt::encrypt($teacher_load->group_subject_id))])}}" onclick="return confirm('Are you sure?')"><span class="badge badge-danger badge-pill">Pozmak</span></a> </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#teacher_pro').DataTable({
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

<!--modal for load add-->
<div class="modal fade" id="addLoad" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('teacher_load.store')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header text-center">
                    <h4 class="modal-title">Täze meýilnama goşmak:</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-2">
                    <label>Topar: </label>
                    <div class="input-group">
                        <select style="width: 100%" class="js-example-theme-single form-control" name="group_id">
                            @foreach($groups as $group)
                                <option value="{{$group->id}}">{{$group->number}} ({{$group->name}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-body mx-2">
                    <label>Ders:</label>
                    <div class="input-subject">
                        <select style="width: 100%" class="js-example-theme-single form-control" name="subject_id">
                            @foreach($subjects as $subject)
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
{{--                <div class="modal-body mx-2">--}}
{{--                    <label>Semester:</label>--}}
{{--                    <div class="input-semester">--}}
{{--                        <select style="width: 100%" class="js-example-theme-single form-control" name="semester_id">--}}
{{--                            @foreach($semesters as $semester)--}}
{{--                                <option value="{{$semester->id}}">{{$semester->number}}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="modal-body mx-2">
                    <label>Sagat sany:</label>
                    <input type="number" name="number_of_hours" class="form-control input-lg" placeholder="Sagat sany" tabindex="1">
                </div>
                <br>
                <input type="hidden" name="teacher_id" value="{{auth()->user()->teacher_id}}">
                <div class="modal-footer d-flex">
                    <p style="color: green;"> </p>
                    <input type="submit" class="btn btn-primary float-right" value="Goşmak"/>
                </div>
            </form>
        </div>
    </div>
</div>
<!--modal for load add-->