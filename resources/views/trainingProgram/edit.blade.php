@extends('layouts.admin')
@section('title', 'Meýilnamalar')
@section('content')

    <div class="col-lg-12">
        <h1 class="page-header"> Meýilnamany üýtgetmek</h1>
        <hr class="hr-header">
    </div>

    <div class="row">
        <div class="col-xs-10 col-sm-7 col-md-4 offset-md-4">
            <form role="form" action="{{route('trainingProgram.store')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{--<hr class="colorgraph">--}}
                <div class="form-group ">
                    <label for="group_id">
                        Topar:&nbsp;&nbsp;
                        <select  class="js-example-theme-single form-control" name="group_id">
                            @foreach($groups as $group)
                                <option {{$trainingProgram->group->id==$group->id?'selected':''}} value="{{$group->id}}">{{$group->name}}({{$group->number}})</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="form-group ">
                    <label for="subject_id">
                        Ders:&nbsp;&nbsp;
                        <select  class="js-example-theme-single form-control" name="subject_id">
                            @foreach($subjects as $subject)
                                <option {{$trainingProgram->subject->id==$subject->id?'selected':''}} value="{{$subject->id}}">{{$subject->name}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="form-group ">
                    <label for="semester_id">
                        Semestr:&nbsp;&nbsp;
                        <select  class="js-example-theme-single form-control" name="semester_id">
                            @foreach($semesters as $semester)
                                <option {{$trainingProgram->semester->id==$semester->id?'selected':''}} value="{{$semester->id}}">{{$semester->number}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="form-group">
                    <input type="number" value="{{$trainingProgram->number_of_hours}}" name="number_of_hours" class="form-control input-lg" placeholder="Sagat sany" tabindex="1">
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