@extends('layouts.admin')
@section('title', 'Mugallymlar')
@section('content')
    @include('partitions.success')

    <div class="col-lg-12">
        <h1 class="page-header"> Mugallymyň žurnallary</h1>
        <hr class="hr-header">
    </div>
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            <a href="#" data-toggle="modal" data-target="#addLoad" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"> </i> Meýilnama goş </a>
        </div>
    </div>
    <table id="teacher_groups" class="table table-bordered table-hover" style="width:100%">
        <thead>
        <tr>
            <th scope="col">Topar</th>
            <th scope="col">Operasiýalar</th>
        </tr>
        </thead>
        <tbody>

        
        </tbody>
        <tfoot>
        <tr>
            <th scope="col">Topar</th>
            <th scope="col">Operasiýalar</th>
        </tr>
        </tfoot>
    </table>
    <!--modal for load add-->
    <div class="modal fade" id="addLoad" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('teacher_load.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-header text-center">
                        <h4 class="modal-title">Täze meýilnama goşmak:</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-2">
                        <label>Topar: </label>
                        <div class="input-group">
                            <select style="width: 100%" class="js-example-theme-single form-control" name="group_id">
                                @foreach($groups as $group)
                                    <option value="{{$group->id}}">{{$group->number}} ({{$group->name}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-body mx-2">
                        <label>Ders:</label>
                        <div class="input-subject">
                            <select style="width: 100%" class="js-example-theme-single form-control" name="subject_id">
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-body mx-2">
                        <label>Sagat sany:</label>
                        <input type="number" name="number_of_hours" class="form-control input-lg" placeholder="Sagat sany" tabindex="1">
                    </div>
                    <br>
                    <input type="hidden" name="teacher_id" value="{{auth()->user()->teacher_id}}">
                    <div class="modal-footer d-flex">
                        <p style="color: green;"> </p>
                        <input type="submit" class="btn btn-primary float-right" value="Goşmak"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--modal for load add-->
    <script>
        $(document).ready(function () {
            $(".js-example-theme-single").select2({
                theme: "classic",
                "language": {
                    "noResults": function () {
                        return "Gözlege görä maglumat tapylmady.";
                    }
                }
            });
        });
        $(function () {
            // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                // save the latest tab; use cookies if you like 'em better:
                localStorage.setItem('lastTab', $(this).attr('href'));
            });

            // go to the latest tab, if it exists:
            var lastTab = localStorage.getItem('lastTab');
            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#teacher_groups').DataTable({
                "processing":true,
                "serverSide":true,
                "pageLength": 10,
                "responsive": true,
                "info": false,
                "ajax":{
                    "url":"<?= route('teacher.groupsApi') ?>",
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
                    emptyTable:       "Topar tapylmady",
                    info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty:        "0 topar görkezilýär",
                    infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                    infoPostFix:      "",
                    lengthMenu:       "Görkez _MENU_ ",
                    loadingRecords:   "Ýüklenýär...",
                    processing:       "Dowam edýär...",
                    search:           "Gözleg",
                    zeroRecords:      "Sazlamalardan taze meyilnama gosun :(",
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
    <style>
        .mfp-with-zoom .mfp-container,
        .mfp-with-zoom.mfp-bg {
            opacity: 0;
            -webkit-backface-visibility: hidden;
            /* ideally, transition speed should match zoom duration */
            -webkit-transition: all 0.3s ease-out;
            -moz-transition: all 0.3s ease-out;
            -o-transition: all 0.3s ease-out;
            transition: all 0.3s ease-out;
        }

        .mfp-with-zoom.mfp-ready .mfp-container {
            opacity: 1;
        }
        .mfp-with-zoom.mfp-ready.mfp-bg {
            opacity: 0.8;
        }

        .mfp-with-zoom.mfp-removing .mfp-container,
        .mfp-with-zoom.mfp-removing.mfp-bg {
            opacity: 0;
        }
    </style>
@endsection