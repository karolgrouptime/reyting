@extends('layouts.admin')
@section('title', 'Toparlaryň sagatlary')
@section('content')

    @include('partitions.success')

    <div class="col-lg-12">
        <a class="float-left text-success mt-2 mr-2" href="{{route('load.teachers')}}">
            <i class="fa fa-arrow-alt-circle-left fa-2x"></i>
        </a>
        <h1 class="page-header"> {{$teacher->last_name}} {{$teacher->first_name}} agyrlyklary</h1>
        <hr class="hr-header">
    </div>

    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
          </div>
    </div>

    <table id="teachers" class="table table-bordered table-striped" style="width:100%">
        <thead>
        <tr>
            <th scope="col">Semestr</th>
            <th scope="col">Ders</th>
            <th scope="col">Topar</th>
            @if(auth()->user()->role[0]->id<>2)
            <th scope="col">Operasiýalar</th>
                @endif
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
                    "url":"<?= route('load.oneTeacherApi') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":{"_token":"<?= csrf_token() ?>","teacher_id":"<?= $teacher_id ?>"},
                },
                "columns":[
                    {"data":"semester" },
                    {"data":"subject" },
                    {"data":"group" },
                        @if(auth()->user()->role[0]->id<>2)
                    {"data":"operations","orderable": false}
                    @endif
                ],
                order: [[0, 'asc']],
                mark: true,
                language: {
                    emptyTable:       "Agyrlyk tapylmady",
                    info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty:        "0 agyrlyk görkezilýär",
                    infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                    infoPostFix:      "",
                    lengthMenu:       "Görkez _MENU_ ",
                    loadingRecords:   "Ýüklenýär...",
                    processing:       "Dowam edýär...",
                    search:           "Gözleg",
                    zeroRecords:      "Gözlegiňize göra agyrlyk tapylmady :(",
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