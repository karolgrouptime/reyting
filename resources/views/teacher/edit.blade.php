@extends('layouts.admin')
@section('title', 'Mygallymlar')
@section('content')

    <div class="col-lg-12">
        <h1 class="page-header"> Mugallymy üýtgetmek</h1>
        <hr class="hr-header">
    </div>

    <div class="container">
        <form role="form" action="{{route('teacher.update',['teacher_id'=>$teacher->id])}}" method="POST"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">

                <div class="col-sm-9">
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name"><h5>Ady:</h5></label>
                                        <input type="text" value="{{$teacher->first_name}}" class="form-control"
                                               name="first_name" id="first_name" placeholder="first name"
                                               title="enter your first name if any.">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name"><h5>Familiýasy:</h5></label>
                                        <input type="text" value="{{$teacher->last_name}}" class="form-control"
                                               name="last_name" id="last_name" placeholder="last name"
                                               title="enter your last name if any.">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="father_name"><h5>Atasynyň ady:</h5></label>
                                        <input type="text" value="{{$teacher->father_name}}" class="form-control"
                                               name="father_name" id="father_name" placeholder="enter phone"
                                               title="enter your phone number if any.">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="birth"><h5>Doglan senesi: </h5></label>
                                        <input type="date" value="{{$teacher->birth}}" class="form-control" name="birth"
                                               id="birth" placeholder="enter mobile number"
                                               title="enter your mobile number if any.">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group ">
                                        <label for="faculty_id"><h5>Fakulteti:</h5></label>
                                        <select style="width: 100%" class="js-example-theme-single form-control p-4"
                                                name="faculty_id">
                                            @foreach($faculties as $faculty)
                                                <option {{$faculty->id==$teacher->faculty->id?'selected':''}} value="{{$faculty->id}}">{{$faculty->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group ">
                                        <label for="kathedra_id"><h5>Kafedrasy:</h5></label>
                                        <select style="width: 100%" class="js-example-theme-single form-control p-4"
                                                name="kathedra_id">
                                            @foreach($kathedras as $kathedra)
                                                <option {{$kathedra->id==$teacher->kathedra->id?'selected':''}} value="{{$kathedra->id}}">{{$kathedra->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group ">
                                        <label for="degree_id"><h5>Derejesi:</h5></label>
                                        <select style="width: 100%" class="js-example-theme-single form-control"
                                                name="degree_id">
                                            @if(!$teacher->degree)
                                                <option value="{{NULL}}" selected>Ýok</option>
                                                @foreach($degrees as $degree)
                                                    <option value="{{$degree->id}}">{{$degree->name}}</option>
                                                @endforeach
                                            @else
                                                <option value="{{NULL}}">Ýok</option>

                                                @foreach($degrees as $degree)
                                                    <option {{$degree->id==$teacher->degree->id?'selected':''}} value="{{$degree->id}}">{{$degree->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="email"><h5>Telefon:</h5></label>
                                            <input type="phone" class="form-control" name="phone"
                                                   value="{{$teacher->phone}}" id="phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="login"><h5>Login:</h5></label>
                                            @if(isset($teacher->user->login))
                                                <input value="{{$teacher->user->login}}" type="text"
                                                       class="form-control" name="login" id="login"
                                                       placeholder="Ulanynjy ady..." title="Ulanynjy ady.">
                                            @else
                                                <input value="" type="text" class="form-control" name="login" id="login"
                                                       placeholder="Ulanynjy ady..." title="Ulanynjy ady.">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="password"><h5>Password:</h5></label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                   placeholder="Açar söz" title="Açar söz">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="file" name="photo_path" id="photo_path" class="input-lg" tabindex="1">
                            </div>
                            <div class="form-group float-right">
                                <div class="col-xs-12">
                                    <br>
                                    <button class="btn btn-md btn-dark" type="reset"><i
                                                class="glyphicon glyphicon-repeat"></i> Täzele
                                    </button>
                                    <button class="btn btn-md btn-success" type="submit"><i
                                                class="glyphicon glyphicon-ok-sign"></i> Goş
                                    </button>
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
        $(document).ready(function () {
            $(".js-example-theme-single").select2({
                theme: "classic",
                "language": {
                    "noResults": function () {
                        return "Gözlege görä hiç zat tapylmady";
                    }
                }
            });
        });
    </script>
    <script src="{{ asset('js/jquery.min.js')}}"></script>

@endsection