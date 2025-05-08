@extends('layouts.admin')
@section('title', 'Meýilnamalar')
@section('content')

    @include('partitions.success')

    <div class="col-lg-12">
        <a class="float-left text-success mt-2 mr-3" href="{{route('settings')}}">
            <i class="fa fa-arrow-alt-circle-left fa-2x"></i>
        </a>
        <h1 class="page-header"> Meýilnamalar sanawy </h1>
        <hr class="hr-header">
    </div>

    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            <a href="{{route('trainingProgram.create')}}" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus"></i> Täze goşmak </a>
        </div>
    </div>

    <table id="teachers" class="table table-bordered table-striped" style="width:100%">
        <thead>
        <tr>
            <th scope="col">Topar</th>
            <th scope="col">Ders</th>
            <th scope="col">Semestr</th>
            <th scope="col">Sagat sany</th>
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
                <input type="text" style="width: 45%" class="form-control" id="group"/>
            </td>
            <td>
                <input type="text" style="width: 45%" class="form-control" id="subject"/>
            </td>
            <td>
                <input type="text" style="width: 45%" class="form-control" id="semester"/>
            </td>
            <th>
                <input type="text" style="width: 45%" class="form-control" id="number_of_hours"/>
            </th>
            @can('student_change')
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
                "ajax":{
                    
                            "url":"<?= route('trainingProgram.api') ?>",
                
                    "dataType":"json",
                    "type":"POST",
                    "data":function (d) {
                        d._token = "<?= csrf_token() ?>";
                        d.group = $('#group').val();
                        d.subject = $('#subject').val();
                        d.semester = $('#semester').val();
                        d.number_of_hours = $('#number_of_hours').val();
                    },
                },
                "columns":[
                    {"data":"group" },
                    {"data":"subject"},
                    {"data":"semester"},
                    {"data":"number_of_hours"},
                        @can('student_change')
                    {"data":"operations","orderable": false}
                    @endcan
                ],
                order: [[0, 'desc']],
                mark: true,
                language: {
                    emptyTable:       "Meýilnama tapylmady",
                    info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty:        "0 talyp görkezilýär",
                    infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                    infoPostFix:      "",
                    lengthMenu:       "Görkez _MENU_ ",
                    loadingRecords:   "Ýüklenýär...",
                    processing:       "Dowam edýär...",
                    search:           "Gözleg",
                    zeroRecords:      "Gözlegiňize göra meýilnama tapylmady :(",
                    paginate: {
                        first:        "Ilkinji",
                        previous:     "Öňki",
                        next:         "Indiki",
                        last:         "Soňky"
                    }
                }
            });
             //send search filed value
            $('#group,#subject,#semester,#number_of_hours').on(
                'keyup change', function () {
                    setTimeout(function() {
                        //draw('page') redraws your DataTable and preserves the page where it was
                        dataTable.draw();
                    },400);
                });
            //send search filed value
        });
    </script>
@endsection