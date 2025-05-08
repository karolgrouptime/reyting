@extends('layouts.admin')
@section('title', 'Žurnallar')
@section('content')

    @include('partitions.success')

    <div class="col-lg-12">
        <h1 class="page-header"> Žurnallaryň sanawy</h1>
        <hr class="hr-header">
    </div>

    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">

        </div>
    </div>

    <table id="teachers" class="table table-bordered table-hover" style="width:100%">
        <thead>
        <tr>
            <th scope="col">Topar</th>
            <th scope="col">Fakultet</th>
            <th scope="col">Kafedrasy</th>
            <th scope="col">Kursy</th>
            <th scope="col">Kurs boýunça žurnal</th>
            @can('settings_show')
            <th scope="col">Operasiýalar</th>
            @endcan
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
                    "url":"<?= route('journal.api') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":{"_token":"<?= csrf_token() ?>"},
                },
                "columns":[
                    {"data":"group" },
                    {"data":"faculty"},
                    {"data":"kathedra"},
                    {"data":"course"},
                    {"data":"group_course_subjects"},
                        @can('settings_show')
                    {"data":"operations","orderable": false}
                    @endcan
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