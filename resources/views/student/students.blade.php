@extends('layouts.admin')
@section('title', 'Talyplar')
@section('content')

    @include('partitions.success')

    <div class="col-lg-12">
        <h1 class="page-header"> Talyplaryň sanawy</h1>
        <hr class="hr-header">
    </div>
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            @can('student_change')
                <a href="{{route('student.create')}}" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"></i> Täze goşmak</a>
                @endcan
        </div>
    </div>
    <table id="students" class="table table-bordered table-striped" style="width:100%">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col" class="w-25">F.A.A.a</th>
            <!-- <th scope="col">Doglan senesi</th> -->
            <th scope="col">Kursy</th>
            <th scope="col">Ýagdaý</th>
            <th scope="col">Fakultet</th>
            <th scope="col">Kafedrasy</th>
            <th scope="col">Topar we (Talyp id)</th>
            <!-- <th scope="col">Suraty</th> -->
            @can('student_change')
                <th scope="col">Operasiýalar</th>
            @endcan
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <td>
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" style="width: 45%" class="form-control"   id="last_name"/>
                        <input type="text" style="width: 45%" class="form-control"  id="first_name"/>
                    </div>
                </td>
                <!-- <td><input class="form-control" id="birth" autocomplete="off"/></td> -->
                <td><input class="form-control" id="course"/></td>
                <td style="width:10%;">
                    <select name="rank" class="form-control" id="rank" type="text">
                        <option value=""></option>
                        @foreach($ranks as $rank)
                            <option value="{{$rank->name}}">{{$rank->name}} </option>
                        @endforeach
                    </select>
                </td>
                <td style="width:10%;">
                    <select name="faculty" class="form-control" id="faculty" type="text">
                        <option value=""></option>
                        @foreach($faculties as $faculty)
                            <option value="{{$faculty->name}}">{{$faculty->name}} </option>
                        @endforeach
                    </select>
                </td>
                <td style="width:10%;">
                    <select name="kathedra" class="form-control" id="kathedra" type="text">
                        <option value=""></option>
                        @foreach($kathedras as $kathedra)
                            <option value="{{$kathedra->name}}">{{$kathedra->name}} </option>
                        @endforeach
                    </select>
                </td>
                <td> <div class="form-group has-success has-feedback">
                        <input type="text" class="form-control" id="group"/>
                    </div>
                </td>
                <!-- <th>Suraty</th> -->
                @can('student_change')
                    <th scope="col">Operasiýalar</th>
                @endcan
            </tr>
        </tfoot>
    </table>

    <script>
        $(document).ready(function() {
            var dataTable = $('#students').DataTable({
                "processing":true,
                "serverSide":true,
                "pageLength": 10,
                "responsive": true,
                "pagingType": "full_numbers",
                "mark": true,
                "lengthMenu": [[10, 20, 50, 10000000], [10, 20, 50, "All"]],
                "ajax":{
                    "url":"<?= route('student.api') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":function (d) {
                        d._token = "<?= csrf_token() ?>",
                        d.first_name = $('#first_name').val();
                        d.last_name = $('#last_name').val();
                        // d.birth = $('#birth').val();
                        d.course = $('#course').val();
                        d.rank = $('#rank').val();
                        d.faculty = $('#faculty').val();
                        d.kathedra = $('#kathedra').val();
                        d.group = $('#group').val();
                    },
                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var info = $(this).DataTable().page.info();
                    $("td:nth-child(1)", nRow).html(info.start + iDisplayIndex + 1 + ".");
                    return nRow;
                },
                "columns":[
                    {"data":"index" },
                    {"data":"full_name" },
                    // {"data":"birth"},
                    {"data":"course"},
                    {"data":"rank"},
                    {"data":"faculty"},
                    {"data":"kathedra"},
                    {"data":"group"},
                    // {"data":"photo"},
                        @can('student_change')
                            {"data":"operations","orderable": false}
                        @endcan
                ],
                order: [[1, 'desc']],
                language: {
                    emptyTable:       "Talyp tapylmady",
                    info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty:        "0 talyp görkezilýär",
                    infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                    infoPostFix:      "",
                    lengthMenu:       "Görkez _MENU_ ",
                    loadingRecords:   "Ýüklenýär...",
                    processing:       "Dowam edýär...",
                    search:           "Gözleg",
                    zeroRecords:      "Gözlegiňize göra talyp tapylmady :(",
                    paginate: {
                        first:        "Ilkinji",
                        previous:     "Öňki",
                        next:         "Indiki",
                        last:         "Soňky"
                    }
                },
            });

            //send search filed value
            $('#first_name,#last_name,#birth,#course,#rank,#faculty,#kathedra,#group').on(
                'keyup change', function () {
                setTimeout(function() {
                    //draw('page') redraws your DataTable and preserves the page where it was
                    dataTable.draw();
                },400);
            });
            //send search filed value
        });

        //js birth format
        $("#birth").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d",
        });
        //js birth format
    </script>
    <style>
        .pagination a.active {
            background: -webkit-linear-gradient(to right, #237A57 0%, #1f7a0d 100%)!important; /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #237A57 0%, #1f7a0d 100%)!important; /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            color: #370af5;
        }
        .pagination a:hover:not(.active) {background-color: #cbddc4;}
    </style>
@endsection