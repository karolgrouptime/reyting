@extends('layouts.admin')
@section('title', 'Dersler')
@section('content')

    @include('partitions.success')

    <div class="col-lg-12">
        <a class="float-left text-success mt-2 mr-3" href="{{route('settings')}}">
            <i class="fa fa-arrow-alt-circle-left fa-2x"></i>
        </a>
        <h1 class="page-header"> Dersleriň sanawy</h1>

        <hr class="hr-header">
    </div>
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
        <h5 class="text-right" style="color:red;">Unüs beriň! Dersleri gaýtalap goşmak bolmaýar;</h5>
            <a href="#" data-toggle="modal" data-target="#addSubject" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"></i> Täze goşmak</a>
        </div>
    </div>
   
    <table id="teachers" class="table table-bordered table-striped" style="width:100%">
        <thead>
        <tr>
            <th scope="col">Ady</th>
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
                    "url":"{{ route('subject.api') }}",
                    "dataType":"json",
                    "type":"POST",
                    "data":{"_token":"{{ csrf_token() }}"},
                },
                "columns":[
                    {"data":"name" },
                    {"data":"operations","orderable": false}
                ],
                order: [[0, 'desc']],
                mark: true,
                language: {
                    emptyTable:       "Ders tapylmady",
                    info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                    infoEmpty:        "0 ders görkezilýär",
                    infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                    infoPostFix:      "",
                    lengthMenu:       "Görkez _MENU_ ",
                    loadingRecords:   "Ýüklenýär...",
                    processing:       "Dowam edýär...",
                    search:           "Gözleg",
                    zeroRecords:      "Gözlegiňize göra ders tapylmady :(",
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

    <!--modal for assessment add-->
    <div class="modal fade" id="addSubject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('subject.store')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body mx-2">
                        <label>Dersiň ady:</label>
                        <div class="input-group">
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="modal-body mx-2">
                        <label>Görnüşi:</label>
                        <div class="input-group">
                            <select type="text" name="type_subject" class="form-control">
                                @foreach($typeSubjects as $typeSubject)
                                    <option value="{{$typeSubject->id}}">{{$typeSubject->name}}</option>
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
    <!--modal for assessment add-->
@endsection