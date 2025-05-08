@extends('layouts.admin')
@section('title', 'Ulanyjylar')
@section('content')

    @include('partitions.success')

    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <div class="col-lg-12">
        <h1 class="page-header"> Ulanyjylar sahypasy</h1>
        <hr class="hr-header">
    </div>

    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            @can('users_change')
                <a href="{{route('user.create')}}" class="btn bg-navbar btn-dark float-right"><i class="fa fa-plus-circle"></i> Täze goşmak</a>
            @endcan
        </div>
    </div>
    <table id="users" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
        <tr>
            <th scope="col">F.A.A.a</th>
            <th scope="col">Status</th>
            <th scope="col">!</th>
            @can('users_change')
                <th scope="col">Işler</th>
            @endcan
        </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
        <tr>
            <th scope="col">F.A.A.a</th>
            <th scope="col">Status</th>
            <th scope="col">!</th>
            @can('users_change')
                <th scope="col">Işler</th>
            @endcan
        </tr>
        </tfoot>
    </table>

    <script>

        $(document).ready(function() {
            var dataTable = $('#users').DataTable({
                "processing":true,
                "serverSide":true,
                "pageLength": 10,
                "ajax":{
                    "url":"<?= route('user.api') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":function (d) {
                        d._token = "<?= csrf_token() ?>"
                    }
                },
                columnDefs: [{
                    targets: "_all",
                    orderable: true
                }],
                "columns":[
                    {"data":"full_name" },
                    {"data":"status"},
                    {"data":"active"},
                        @can('users_change')
                            {"data":"operations","orderable": false},
                        @endcan
                ],
                order: [[1, 'asc']],
                mark: true,
                filter: true,
                fixedColumns: true,
                language: {
                    emptyTable:       "Ulanyjy tapylmady",
                    info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty:        "0 ulanyjy görkezilýär",
                    infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                    infoPostFix:      "",
                    lengthMenu:       "Görkez _MENU_ ",
                    loadingRecords:   "Ýüklenýär...",
                    processing:       "Dowam edýär...",
                    search:           "Gözleg",
                    zeroRecords:      "Gözlegiňize göra ulanyjy tapylmady :(",
                    paginate: {
                        first:        "Ilkinji",
                        previous:     "Öňki",
                        next:         "Indiki",
                        last:         "Soňky"
                    }
                },
            });
        });
    </script>
@endsection