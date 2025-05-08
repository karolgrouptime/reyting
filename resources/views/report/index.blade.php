@extends('layouts.admin')
@section('title', 'Sapak goýberenler')
@section('content')
    @include('partitions.success')
    <div class="col-lg-12">
        <a class="float-left text-success mt-2 mr-3" href="{{route('dashboard')}}">
            <i class="fa fa-arrow-alt-circle-left fa-2x"></i>
        </a>
        <h1 class="page-header">Hasabatlar</h1>
        <hr class="hr-header">
    </div>
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            <a href="#" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-download"></i> Export</a>
            <a href="#" data-toggle="modal" data-target="#addSubject" class="btn bg-navbar btn-dark float-right m-1"><i
                        class="fa fa-pen"></i> Sapakdan galanlar</a>
        </div>
    </div>
    <table id="reports" class="table table-bordered table-striped table-hover" style="width:100%">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Wezipesi</th>
            <th scope="col">ýagdaý</th>
            <th scope="col">F.A.a</th>
            <th scope="col">Kafedra</th>
            <th scope="col">Sene-sany</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $('#reports').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 10,
                "responsive": true,
                "ajax": {
                    "url": "<?= route('report.api') ?>",
                    "dataType": "json",
                    "type": "POST",
                    "data": {"_token": "<?= csrf_token() ?>"},
                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var info = $(this).DataTable().page.info();
                    $("td:nth-child(1)", nRow).html(info.start + iDisplayIndex + 1 + ".");
                    return nRow;
                },
                "columns": [
                    {"data": "index"},
                    {"data": "position"},
                    {"data": "name"},
                    {"data": "kathedra"},
                    {"data": "result"},
                ],
                order: [[0, 'desc']],
                mark: true,
                language: {
                    emptyTable: "Maglumat tapylmady",
                    info: "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty: "0 maglumat görkezilýär",
                    infoFiltered: "(_MAX_ maglumat gözleg esasynda)",
                    infoPostFix: "",
                    lengthMenu: "Görkez _MENU_ ",
                    loadingRecords: "Ýüklenýär...",
                    processing: "Dowam edýär...",
                    search: "Gözleg",
                    zeroRecords: "Gözlegiňize göra maglumat tapylmady :(",
                    paginate: {
                        first: "Ilkinji",
                        previous: "Öňki",
                        next: "Indiki",
                        last: "Soňky"
                    }
                }
            });
        });
    </script>

@endsection