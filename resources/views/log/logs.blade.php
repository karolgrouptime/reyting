@extends('layouts.admin')
@section('title', 'Loglar')
@section('content')
    @include('partitions.success')
    <a class="btn btn-primary" style="margin-left: 89%" href="{{route('log.saveExcel')}}"><i class="fa fa-file-excel text-light"></i> Export to Excel</a>
    <div class="col-lg-12">
        <h1 class="page-header">Log taryhy sanawy</h1>
         <hr class="hr-header">
    </div>
    <table id="teachers" class="table table-bordered table-striped" style="width:100%">
        <thead>
        <tr>
            <th scope="col">F.A.A.a</th>
            <th scope="col">Ulanyjy ady</th>
            <th scope="col">Ip</th>
            <th scope="col">Görnüşi</th>
            <th scope="col">Info</th>
            <th scope="col">Wagty</th>
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
                    "url":"<?= route('log.api') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":{"_token":"<?= csrf_token() ?>"},
                },
                "columns":[
                    {"data":"full_name" },
                    {"data":"login"},
                    {"data":"ip"},
                    {"data":"kind"},
                    {"data":"info"},
                    {"data":"created_at"},
                ],
                order: [[0, 'desc']],
                mark: true,
                language: {
                    emptyTable:       "Log tapylmady",
                    info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty:        "0 log görkezilýär",
                    infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                    infoPostFix:      "",
                    lengthMenu:       "Görkez _MENU_ ",
                    loadingRecords:   "Ýüklenýär...",
                    processing:       "Dowam edýär...",
                    search:           "Gözleg",
                    zeroRecords:      "Gözlegiňize göra log tapylmady :(",
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