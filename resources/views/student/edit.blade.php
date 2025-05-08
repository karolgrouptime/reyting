@extends('layouts.admin')
@section('title', 'Talyplar')
@section('content')

    <div class="col-lg-12">
        <h1 class="page-header"> Talyby üýtgetmek</h1>
        <hr class="hr-header">
    </div>
    <div class="row">
        <div class="col-xs-10 col-sm-7 col-md-5 offset-sm-3">
            <form role="form" action="{{route('student.update',['student_id' => $student->id])}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{--<hr class="colorgraph">--}}
                <div class="form-group">
                    <input type="text" value="{{$student->last_name}}" name="last_name" id="name" class="form-control input-lg" placeholder="Familiýasy" tabindex="1">
                </div>
                <div class="form-group">
                    <input type="text" value="{{$student->first_name}}" name="first_name" id="name" class="form-control input-lg" placeholder="Ady" tabindex="1">
                </div>
                <div class="form-group">
                    <input type="text" value="{{$student->father_name}}" name="father_name" id="name" class="form-control input-lg" placeholder="Atasynyň ady" tabindex="1">
                </div>

                <div class="form-group row">
                    <label for="recept_date" class="col-sm-4 col-form-label">Okuwa giren ýyly:</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" value="{{$student->recept_date}}" name="recept_date" id="recept_date" placeholder="date">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="birth" class="col-sm-4 col-form-label">Doglan senesi: </label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" value="{{$student->birth}}" name="birth" id="birth" placeholder="date">
                    </div>
                </div>
                <br>
                <div class="form-group ">
                    <label for="student_rank_id">
                    Ýagdaý:&nbsp;&nbsp;
                        <select  class="js-example-theme-single form-control" name="student_rank_id">
                            @foreach($studentRanks as $studentRank)
                                <option {{$student->student_rank->id==$studentRank->id?'selected':''}} value="{{$studentRank->id}}">{{$studentRank->name}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            
                <div class="form-group ">
                    <label for="group_id">
                        Topary:&nbsp;&nbsp;
                        <select  class="js-example-theme-single form-control" name="group_id">
                            @foreach($groups as $group)
                                <option {{$student->group->id==$group->id?'selected':''}} value="{{$group->id}}">{{$group->number}} ({{$group->name}})</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="form-group">
                    <label for="nationality_id">
                        Milleti:&nbsp;&nbsp;
                        <select  class="js-example-theme-single form-control" name="nationality_id">
                            @foreach($nationalities as $nationality)
                                <option {{$student->nationality->id==$nationality->id?'selected':''}} value="{{$nationality->id}}">{{$nationality->name}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <!-- <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-xs-6">
                            <label for="login"><h5>Login:</h5></label>
                            @if(isset($student->user->login))
                                <input value="{{$student->user->login}}" type="text" class="form-control" name="login" id="login" placeholder="Ulanynjy ady..." title="Ulanynjy ady.">
                            @else
                                <input value="" type="text" class="form-control" name="login" id="login" placeholder="Ulanynjy ady..." title="Ulanynjy ady.">
                            @endif
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
                    <input type="hidden" name="role_id" value="{{4}}">
        </div> -->
                <div class="form-group">
                    <input type="file" name="photo_path" id="photo_path" class="input-lg" tabindex="1">
                </div>
                <hr class="colorgraph">
                <input type="submit"  class="btn btn-success float-lg-right" value="Goş"/>
            </form>
        </div>
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