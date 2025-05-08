@extends('layouts.admin')
@section('title', 'Mugallymlar')
@section('content')

    <link rel="stylesheet" href="{{asset('css/fancybox.min.css')}}" />
    <script src="{{asset('js/fancybox.min.js')}}"></script>
    @include('partitions.success')
{{--    <a class="btn btn-primary" style="margin-left: 95%" href="{{route('teacher.saveExcel')}}"><i class="fa fa-file-excel text-light"></i> Excel</a>--}}
    <div class="col-lg-12">
        <h1 class="page-header"> Mugallymlaryň sanawy</h1>
        <hr class="hr-header">
    </div>
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            @can('teacher_change')
                <a href="{{route('teacher.create')}}" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"></i> Täze goşmak</a>
            @endcan
        </div>
    </div>
    <table id="teachers" class="table table-bordered table-striped" style="width:100%">
        <thead>
        <tr>
            <th>№</th>
            <th scope="col">F.A.A.a</th>
            <th scope="col">Doglan senesi</th>
            <th scope="col">Wezipesi</th>
{{--            <th scope="col">Ýagdaý</th>--}}
            <th scope="col">Fakultet</th>
            <th scope="col">Kafedrasy</th>
            <th scope="col">Telefon (Id)</th>
            <th scope="col">Suraty</th>
            @can('teacher_change')
                <th scope="col">Operasiýalar</th>
            @endcan
        </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <td>
                <div class="input-group">
                    <input type="text" style="width: 45%" class="form-control"   id="last_name"/>
                    <input type="text" style="width: 45%" class="form-control"  id="first_name"/>
                </div>
            </td>
            <td><input class="form-control" id="birth" autocomplete="off"/></td>
            <td style="width:10%;">
                <select name="position" class="form-control" id="position" type="text">
                    <option value=""></option>
                    @foreach($positions as $position)
                        <option value="{{$position->name}}">{{$position->name}} </option>
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
            <th>
                <div class="input-group">
                    <input type="char" style="width: 45%" class="form-control" id="phone"/>
                </div>
            </th>
            <th>Suraty</th>

            @can('teacher_change')
                <th scope="col">Operasiýalar</th>
            @endcan
        </tr>
        </tfoot>
    </table>

    <script>
        $(document).ready(function() {
            var dataTable = $('#teachers').DataTable({
                "processing":true,
                "serverSide":true,
                "pageLength": 10,
                "responsive": true,
                "mark": true,
                "ajax":{
                    "url":"<?= route('teacher.api') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":function (d) {
                        d._token = "<?= csrf_token() ?>";
                        d.first_name = $('#first_name').val();
                        d.last_name = $('#last_name').val();
                        d.birth = $('#birth').val();
                        d.position = $('#position').val();
                        d.faculty = $('#faculty').val();
                        d.kathedra = $('#kathedra').val();
                        d.phone = $('#phone').val();
                    },
                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var info = $(this).DataTable().page.info();
                    $("td:nth-child(1)", nRow).html(info.start + iDisplayIndex + 1 + ".");
                    return nRow;
                },
                "columns":[
                    {"data":"index"},
                    {"data":"full_name"},
                    {"data":"birth"},
                    {"data":"position"},
                    {"data":"faculty"},
                    {"data":"kathedra"},
                    {"data":"phone"},
                    {"data":"photo"},
                    @can('teacher_change')
                        {"data":"operations","orderable": false}
                    @endcan
                ],
                order: [[1, 'desc']],
                language: {
                    emptyTable:       "Mugallym tapylmady",
                    info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty:        "0 mugallym görkezilýär",
                    infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                    infoPostFix:      "",
                    lengthMenu:       "Görkez _MENU_ ",
                    loadingRecords:   "Ýüklenýär...",
                    processing:       "Dowam edýär...",
                    search:           "Gözleg",
                    zeroRecords:      "Gözlegiňize göra mugallym tapylmady :(",
                    paginate: {
                        first:        "Ilkinji",
                        previous:     "Öňki",
                        next:         "Indiki",
                        last:         "Soňky"
                    }
                },

            });
            //send search filed value
            $('#first_name,#last_name,#birth,#faculty,#kathedra,#position,#phone').on(
                'keyup change', function () {
                    setTimeout(function() {
                        //draw('page') redraws your DataTable and preserves the page where it was
                        dataTable.draw();
                    },400);
                });
            //send search filed value
        });

        $('[data-fancybox]').fancybox({
            protect: true
        });
    </script>
@endsection