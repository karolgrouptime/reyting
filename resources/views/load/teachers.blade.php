@extends('layouts.admin')
@section('title', 'Mugallym-ders')
@section('content')

    @include('partitions.success')

    <div class="col-lg-12">
        <a class="float-left text-success mt-2 mr-2" href="{{route('settings')}}">
            <i class="fa fa-arrow-alt-circle-left fa-2x"></i>
        </a>
        <h1 class="page-header"> Agyrlyklar</h1>
        <hr class="hr-header">
    </div>

    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            <a href="#" data-toggle="modal" data-target="#addLoad" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"> Täze goş</i> </a>
        </div>
    </div>

    <table id="teachers" class="table table-bordered table-striped" style="width:100%">
        <thead>
        <tr>
            <th scope="col">Mugallym</th>
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
                    "url":"<?= route('load.teachersApi') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":{"_token":"<?= csrf_token() ?>"},
                },
                "columns":[
                    {"data":"teacher"},
                    {"data":"operations","orderable": false}
                ],
                order: [[0, 'desc']],
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


    <!--modal for load add-->
    <div class="modal fade" id="addLoad" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('load.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-header text-center ">
                        <h4 class="modal-title"> Täze nagruzka</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @if(auth()->user()->role[0]->id==3)
                        <input type="hidden" name="group_id" value="{{auth()->user()->group_id}}">
                    @else
                    <div class="modal-body mx-2">
                        <label>Torap:</label>
                        <div class="input-group">
                            <select style="width: 100%" class="js-example-theme-single form-control" name="group_id">
                                @foreach($groups as $group)
                                    <option value="{{$group->id}}">{{$group->name}} ({{$group->number}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="modal-body mx-2">
                        <label>Semestr:</label>
                        <div class="input-semester">
                            <select style="width: 100%" class="js-example-theme-single form-control" name="semester_id">
                                @foreach($semesters as $semester)
                                    <option value="{{$semester->id}}">{{$semester->number}}</option>
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
                    @if(auth()->user()->role[0]->id==2)
                        <input type="hidden" name="teacher_id" value="{{auth()->user()->teacher_id}}">
                    @else
                    <div class="modal-body mx-2">
                        <label>Mugallym:</label>
                        <div class="input-teacher">
                            <select style="width: 100%" class="js-example-theme-single form-control" name="teacher_id">
                                @foreach($teachers as $teacher)
                                    <option value="{{$teacher->id}}">{{$teacher->last_name}} {{$teacher->first_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="modal-footer d-flex">
                        <input type="submit" class="btn btn-primary float-right" value="Goş"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--modal for load add-->
    <script>
        $(document).ready(function() {
            $(".js-example-theme-single").select2({
                theme: "classic",
                "language": {
                    "noResults": function(){
                        return "Gözlege görä hiç zat tapylmady";
                    }
                }
            });
        });
    </script>

@endsection