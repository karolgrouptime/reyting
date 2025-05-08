@extends('layouts.admin')
@section('title', 'Okuw bölümi')
@section('content')

    @include('partitions.success')

    <div class="col-lg-12">
        <a class="float-left text-success mt-2 mr-2" href="{{route('settings')}}">
            <i class="fa fa-arrow-alt-circle-left fa-2x"></i>
        </a>
        <h1 class="page-header"> Maglumatlar</h1>
        <hr class="hr-header">
    </div>       
            <div class="card">
                <div class="card-header bg-navbar">
                    <h5 class="text-light"> Toparlar</h5>
                </div>
                <div class="card-body">
                    <div class="col-md-1 float-right">
                        <a href="#" data-toggle="modal" data-target="#addGroup" class="btn bg-navbar btn-dark "><i class="fa fa-plus-circle"></i></a>
                    </div>
                    <table id="groups" class="table table-bordered table-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">Şifiri</th>
                            <th scope="col">Ady</th>
                            <th scope="col">Kafedrasy</th>
                            <th scope="col">Fakuteti</th>
                            <th scope="col">Operasiýalar</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
       
    </div>
    <hr class="hr-middle">
    <div class="row">
        <div class="col-lg-6 col-md-12 col-xs-12">
            <div class="card">
                <div class="card-header bg-navbar">
                    <h5 class="text-light"> Milletler</h5>
                </div>
                <div class="card-body">
                    <div class="col-md-1 float-right">
                        <a href="#" data-toggle="modal" data-target="#addNationality" class="btn bg-navbar btn-dark "><i class="fa fa-plus-circle"></i></a>
                    </div>
                    <table id="nationalities" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">Ady</th>
                            <th scope="col">Operasiýalar</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-xs-12">
            <div class="card">
                <div class="card-header bg-navbar">
                    <h5 class="text-light"> Ýagdaý</h5>
                </div>
                <div class="card-body">
                    <div class="col-md-1 float-right">
                        <a href="#" data-toggle="modal" data-target="#addStRank" class="btn bg-navbar btn-dark "><i class="fa fa-plus-circle"></i></a>
                    </div>
                    <table id="stRanks" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">Ady</th>
                            <th scope="col">Operasiýalar</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#groups').DataTable({
                "processing":true,
                "serverSide":true,
                "pageLength": 10,
                "responsive": true,
                "ajax":{
                    "url":"<?= route('group.api') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":{"_token":"<?= csrf_token() ?>"},
                },
                "columns":[
                    {"data":"number"},
                    {"data":"name"},
                    {"data":"kathedra"},
                    {"data":"faculty"},
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
                    zeroRecords:      "Gözlegiňize göra topar tapylmady :(",
                    paginate: {
                        first:        "Ilkinji",
                        previous:     "Öňki",
                        next:         "Indiki",
                        last:         "Soňky"
                    }
                }
            });
            $('#nationalities').DataTable({
                "processing":true,
                "serverSide":true,
                "pageLength": 4,
                "responsive": true,
                "ajax":{
                    "url":"<?= route('nationality.api') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":{"_token":"<?= csrf_token() ?>"},
                },
                "columns":[
                    {"data":"name"},
                    {"data":"operations","orderable": false}
                ],
                order: [[1, 'desc']],
                mark: true,
                language: {
                    emptyTable:       "Millet tapylmady",
                    info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty:        "0 millet görkezilýär",
                    infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                    infoPostFix:      "",
                    lengthMenu:       "Görkez _MENU_ ",
                    loadingRecords:   "Ýüklenýär...",
                    processing:       "Dowam edýär...",
                    search:           "Gözleg",
                    zeroRecords:      "Gözlegiňize göra millet tapylmady :(",
                    paginate: {
                        first:        "Ilkinji",
                        previous:     "Öňki",
                        next:         "Indiki",
                        last:         "Soňky"
                    }
                }
            });
            $('#stRanks').DataTable({
                "processing":true,
                "serverSide":true,
                "pageLength": 4,
                "responsive": true,
                "ajax":{
                    "url":"<?= route('studentRank.api') ?>",
                    "dataType":"json",
                    "type":"POST",
                    "data":{"_token":"<?= csrf_token() ?>"},
                },
                "columns":[
                    {"data":"name"},
                    {"data":"operations","orderable": false}
                ],
                order: [[1, 'desc']],
                mark: true,
                language: {
                    emptyTable:       "Ýagdaý tapylmady",
                    info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty:        "0 Ýagdaý görkezilýär",
                    infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                    infoPostFix:      "",
                    lengthMenu:       "Görkez _MENU_ ",
                    loadingRecords:   "Ýüklenýär...",
                    processing:       "Dowam edýär...",
                    search:           "Gözleg",
                    zeroRecords:      "Gözlegiňize göra Ýagdaý tapylmady :(",
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
    <!--modal for groups-->
    <div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('group.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-header text-center ">
                        <h4 class="modal-title"> Täze topar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-2">
                        <label>Şifiri:</label>
                        <div class="input-group">
                            <input type="char" name="number" class="form-control">
                        </div>
                        <label>Ady:</label>
                        <div class="input-group">
                            <input type="text" name="name" class="form-control">
                        </div>
                        <label>Kafedrasy:</label>
                        <div class="input-group">
                            <select name="kathedra_id" class="form-control">
                                @foreach($kathedras as $kathedra)
                                    <option value="{{$kathedra->id}}">{{$kathedra->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex">
                        <input type="submit" class="btn btn-primary float-right" value="Goş"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--modal for groups-->


    <!--modal for nationality-->
    <div class="modal fade" id="addNationality" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('nationality.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-header text-center ">
                        <h4 class="modal-title"> Täze millet</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-2">
                        <label>Ady:</label>
                        <div class="input-group">
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer d-flex">
                        <input type="submit" class="btn btn-primary float-right" value="Goş"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--modal for nationality-->

    <!--modal for nationality-->
    <div class="modal fade" id="addStRank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('studentRank.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-header text-center ">
                        <h4 class="modal-title"> Ýagdaý</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-2">
                        <label>Ady:</label>
                        <div class="input-group">
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer d-flex">
                        <input type="submit" class="btn btn-primary float-right" value="Goş"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--modal for nationality-->
@endsection