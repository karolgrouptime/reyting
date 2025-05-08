@extends('layouts.admin')
@section('title', 'Mugallym-ders')
@section('content')

    @include('partitions.success')

    <div class="col-lg-12">
        <h1 class="page-header"> Agyrlyk</h1>
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
                    "url":"<?= route('load.groupsApi') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":{"_token":"<?= csrf_token() ?>"},
                },
                "columns":[
                    {"data":"group" },
                    {"data":"operations","orderable": false}
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
        });
    </script>
@endsection