@extends('layouts.admin')
@section('title', 'Talyplar')
@section('content')
    <link href="{{ asset('css/flatpickr.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('js/flatpickr.js')}}"></script>
    <div class="col-lg-12">
        <h2 class="page-header"> Täze talyp goşmak</h2>
        <hr class="hr-header">
    </div>
    <div class="container">
        <form role="form" action="{{route('student.store')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-3">
                    <!--left col-->
                    <div class="text-center">
                        <img src="{{asset('images/avatar.png')}}" class="avatar img-circle img-thumbnail" alt="avatar">
                        <input type="file" name="photo_path" class="text-center center-block file-upload">
                    </div> </hr> <br>
                    <div class="panel panel-default">
                        <div class="panel-heading">mail: <i class="fa fa-link fa-1x"></i></div>
                        <div class="panel-body"><a href="https://gmail.com">r.rejepovv@gmail.com</a></div>
                    </div>
                </div>  <!--/col-3-->
                <div class="col-sm-9">
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name"> <h5>Ady:</h5> </label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="first name" title="enter your first name if any.">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name"> <h5>Familiýasy:</h5></label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="last name" title="enter your last name if any.">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="father_name"><h5>Atasynyň ady:</h5></label>
                                        <input type="text" class="form-control" name="father_name" id="father_name" placeholder="father_name" title="father_name">
                                    </div>
                                </div>
                                <!-- <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="birth"> <h5>Doglan senesi:</h5></label>
                                        <input type="date" class="form-control" name="birth" id="birth"/>
                                    </div>
                                </div> -->
                            
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-xs-6">
                                                <label for="password"><h5>Okuwa giren ýyly:</h5></label>
                                                <input type="date" class="form-control" name="recept_date" id="recept_date"/>
                                            </div>
                                        </div>
                                    </div> -->
                                    <input type="hidden"  name="recept_date" value="2024-08-19"/>
                                    <input type="hidden"  name="birth" value="2005-01-01"/>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label for="nationality_id"><h5>Milleti:</h5></label>
                                            <select style="width: 100%" class="js-example-theme-single form-control" name="nationality_id">
                                                @foreach($nationalities as $nationality)
                                                    <option value="{{$nationality->id}}">{{$nationality->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                            </div>
                            <div class="row">
                           
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="group_id"><h5>Topary:</h5></label>
                                        <select style="width: 100%" class="js-example-theme-single form-control p-4" name="group_id">
                                            @foreach($groups as $group)
                                                <option value="{{$group->id}}">{{$group->number}} ({{$group->name}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                             
                                <div class="col-md-5">
                                    <div class="form-group ">
                                        <label for="rank_id"><h5>Ýagdaý:</h5></label>
                                        <select style="width: 100%" class="js-example-theme-single form-control" name="rank_id">
                                            @foreach($studentRanks as $studentRank)
                                                <option value="{{$studentRank->id}}">{{$studentRank->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="login"><h5>Login:</h5></label>
                                        <input autocomplete="off" type="hidden" class="form-control" name="login" id="login" placeholder="Ulanynjy ady..." title="Ulanynjy ady." >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="password"><h5>Password:</h5></label>
                                        <input type="hidden" class="form-control" name="password" id="password" placeholder="Açar söz" title="Açar söz">
                                    </div>
                                </div>
                            </div> -->
                        </div>
                            <!-- <input type="hidden" name="role_id" value="{{4}}" id="role_id"> -->
                        </div>
                            <div class="form-group float-right">
                                <div class="col-xs-12">
                                    <br>
                                    <button class="btn btn-md btn-dark" type="reset"><i class="glyphicon glyphicon-repeat"></i> Täzele</button>
                                    <button class="btn btn-md btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Goş</button>
                                </div>
                            </div>
                            <hr>
                        </div><!--/col-9-->
                    </div><!--/row-->
                </div>
        </form>
    </div>
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
        //js date format
        $("#recept_date,#birth").flatpickr({
            enableTime: true,
            dateFormat: "d-m-Y",
        });
        //js date format
    </script>
    <script src="{{ asset('js/jquery.min.js')}}"> </script>
@endsection