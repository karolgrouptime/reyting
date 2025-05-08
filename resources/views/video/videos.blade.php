@extends('layouts.admin')
@section('title', 'Ulanyjylar')
@section('content')
    @include('partitions.success')
    @include('partitions.error')

    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <div class="col-lg-12">
        <h1 class="page-header"> Ulanyjylar sahypasy</h1>
        <hr class="hr-header">
    </div>
    @can('users_change')
        <div class="row my-3 mx-1">
            <div class="col-md-12 text-right">
                <form role="form" action="{{route('video.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="submit" class="btn bg-navbar float-right m-1" value="Goşmak"/>
                    <input type="text" class="btn float-right m-1" name="name" style="width: 500px; height: 43px; border: 0.5px solid #374ea2;" placeholder="Wideo ady" title="enter your  name if any.">
                    <input type="file" name="video_path" class="btn float-right m-1" style="border: 0.5px solid #374ea2;" placeholder="WIDEONY SAÝLA" title="WIDEONY SAÝLA">
                    <input type="file" name="photo_path" class="btn float-right m-1" style="border: 0.5px solid #374ea2;"  placeholder="SURATY SAÝLA" title="SURATY SAÝLA">
                    <i class="badge badge-success badge-pill"> S u r a t y </i>
                </form>
            </div>
        </div>
    @endcan
    <table id="users" class="table table-hover table-bordered nowrap" style="width:100%">
        <thead>
        <tr>
            <th scope="col">F.A.A.a</th>
            <th scope="col">Wideo ady</th>
            <th scope="col">Like&Eye
            <th scope="col">Status</th>
            <th scope="col">video_path</th>
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
            <th scope="col">Wideo ady</th>
            <th scope="col">Like&Eye</th>
            <th scope="col">Status</th>
            <th scope="col">video_path</th>
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
                    "url":"<?= route('video.api') ?>",
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
                    {"data":"video_name" },
                    {"data":"likeEye" },
                    {"data":"status"},
                    {"data":"video_path"},
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
                    emptyTable:       "Wideo tapylmady",
                    info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty:        "0 wideo görkezilýär",
                    infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                    infoPostFix:      "",
                    lengthMenu:       "Görkez _MENU_ ",
                    loadingRecords:   "Ýüklenýär...",
                    processing:       "Dowam edýär...",
                    search:           "Gözleg",
                    zeroRecords:      "Gözlegiňize göra wideo tapylmady :(",
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