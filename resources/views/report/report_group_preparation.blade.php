@extends('layouts.admin')
@section('title', 'Baş sahypa')
@section('content')
    @include('partitions.success')
    <div class="col-md-12">
        <h1>Kafedranyň toparlary</h1>
        <hr class="hr-header">
    </div>
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            <form action="#" method="POST">
{{--                <input type="submit" class="btn bg-navbar float-right m-1" value="Sene goşmak"/>--}}
            </form>
        </div>
    </div>
    <table id="groups" class="table table-bordered table-hover" style="width:100%">
        <thead>
        <tr>
            <th>Topar</th>
            <th>Ady</th>
            <th>Kafedra</th>
            <th>Semester</th>
            <th>Operasiýalar</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#groups').DataTable({
                "processing": true,
                "serverSide": true,
                "pageLength": 10,
                "responsive": true,
                "ajax": {
                    "url": "<?= route('report.preparationApi') ?>",
                    "dataType": "json",
                    "type": "POST",
                    "data": {"_token": "<?= csrf_token() ?>"},
                },
                "columns": [
                    {"data": "number"},
                    {"data": "name"},
                    {"data": "kathedra"},
                    {"data": "faculty"},
                    {"data": "operations", "orderable": false}
                ],
                order: [[1, 'desc']],
                mark: true,
                language: {
                    emptyTable: "Topar tapylmady",
                    info: "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty: "0 topar görkezilýär",
                    infoFiltered: "(_MAX_ maglumatdan gözleg esasynda)",
                    infoPostFix: "",
                    lengthMenu: "Görkez _MENU_ ",
                    loadingRecords: "Ýüklenýär...",
                    processing: "Dowam edýär...",
                    search: "Gözleg",
                    zeroRecords: "Gözlegiňize göra topar tapylmady :(",
                    paginate: {
                        first: "Ilkinji",
                        previous: "Öňki",
                        next: "Indiki",
                        last: "Soňky"
                    }
                }
            });
        })
    </script>
@endsection