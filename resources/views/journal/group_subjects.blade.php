@extends('layouts.admin')
@section('title', 'Žurnallar')
@section('content')

    @include('partitions.success')

    <div class="col-lg-12">
        <a class="float-left text-success mt-3" href="{{route('journals')}}">
            <i class="fa fa-arrow-alt-circle-left fa-2x"></i>
        </a>
        <h1 class="page-header">
           &nbsp;Toparyň dersleri sanawy {{Crypt::decrypt($course_id)}} kurs</h1>

        <hr class="hr-header">
    </div>

    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
        <a href="{{route('reportGroupExcel',['group_id'=>$group_id,'course_id'=>$course_id])}}" title="Excel" class="btn bg-navbar float-right "><i class="fa fa-chalkboard"> </i> Excel</a>
        </div>
    </div>
    <table id="teachers" class="table table-bordered table-striped" style="width:100%">
        <thead>
        <tr>
            <th scope="col">Topar</th>
            <th scope="col">Ders</th>
            <th scope="col">Semestr</th>
            <th scope="col">Sagat sany</th>
            <th scope="col">Operasiýalar</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#teachers').DataTable({
                "processing":true,
                "serverSide":true,
                "pageLength": 10,
                "responsive": true,
                "ajax":{
                    "url":"<?= route('groupSubjects.api') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":{"_token":"<?= csrf_token() ?>","group_id":"<?= $group_id?>","course_id":"<?= $course_id?>"},
                },
                "columns":[
                    {"data":"group" },
                    {"data":"subject"},
                    {"data":"semester"},
                    {"data":"hours"},
                    {"data":"operations","orderable": false}
                ],
                order: [[0, 'desc']],
                mark: true,
                language: {
                    emptyTable:       "Žurnal tapylmady",
                    info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty:        "0 žurnal görkezilýär",
                    infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                    infoPostFix:      "",
                    lengthMenu:       "Görkez _MENU_ ",
                    loadingRecords:   "Ýüklenýär...",
                    processing:       "Dowam edýär...",
                    search:           "Gözleg",
                    zeroRecords:      "Gözlegiňize göra žurnal tapylmady :(",
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
@endsection