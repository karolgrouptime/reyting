@extends('layouts.admin')
@section('title', 'Mygallymlar')
@section('content')

    <div class="col-lg-12">
        <h1 class="page-header"> Täze mugallym goşmak</h1>
        <hr class="hr-header">
    </div>
    <div class="container">
        <form role="form" action="{{route('teacher.store')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-3">
                <!--left col-->
                <div class="text-center">
                    <img src="{{asset('images/avatar.png')}}" class="avatar img-circle img-thumbnail" alt="avatar">
                    <input type="file" name="photo_path" class="text-center center-block file-upload">
                </div> <br>
                <div class="panel panel-default">
                    <div class="panel-heading">mail: <i class="fa fa-link fa-1x"></i><a href="https://gmail.com">r.rejepovv@gmail.com</a></div>
                </div>
            </div>
               <div class="col-sm-9">
                <div class="tab-content">
                    <div class="tab-pane active" id="home">
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name"><h5>Ady:</h5></label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="first name" title="enter your first name if any.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name"><h5>Familiýasy:</h5></label>
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
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="birth"><h5>Doglan senesi: </h5></label>
                                        <input type="date" class="form-control" name="birth" id="birth" placeholder="enter mobile number" title="enter your mobile number if any.">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group ">
                                        <label for="faculty_id"><h5>Fakulteti:</h5></label>
                                        <select style="width: 100%" class="js-example-theme-single form-control p-4" name="faculty_id">
                                            @foreach($faculties as $faculty)
                                                <option value="{{$faculty->id}}">{{$faculty->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            <div class="col-md-7">
                                <div class="form-group ">
                                    <label for="kathedra_id"><h5>Kafedrasy:</h5></label>
                                    <select style="width: 100%" class="js-example-theme-single form-control p-4" name="kathedra_id">
                                        @foreach($kathedras as $kathedra)
                                            <option value="{{$kathedra->id}}">{{$kathedra->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group ">
                                    <label for="position_id"><h5>Wezipesi:</h5></label>
                                    <select style="width: 100%" class="js-example-theme-single form-control" name="position_id">
                                        @foreach($positions as $position)
                                            <option value="{{$position->id}}">{{$position->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group ">
                                    <label for="degree_id"><h5>Derejesi:</h5></label>
                                    <select style="width: 100%" class="js-example-theme-single form-control" name="degree_id">
                                        <option value="{{NULL}}" selected>Ýok</option>
                                        @foreach($degrees as $degree)
                                            <option value="{{$degree->id}}">{{$degree->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="email"><h5>Telefon:</h5></label>
                                        <input type="phone" class="form-control" name="phone" id="phone">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="login"><h5>Login:</h5></label>
                                        <input autocomplete="off" type="text" class="form-control" name="login" id="login" placeholder="Ulanynjy ady..." title="Ulanynjy ady.">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="password"><h5>Password:</h5></label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Açar söz" title="Açar söz">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="role_id"><h5>Role:</h5></label>
                                    <select style="width: 100%" class="js-example-theme-single form-control p-4" name="role_id">
                                        @foreach($roles as $role)
                                            <option {{$role->name=="teacher" || $role->name=="mugallym" || $role->name=="Mugallym"?"selected":""}} value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
    </script>
    <script src="{{ asset('js/jquery.min.js')}}"> </script>

@endsection