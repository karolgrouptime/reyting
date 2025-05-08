@extends('layouts.admin')
@section('title', 'Ulanyjylar')
@section('content')

    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}"/>

    <div class="col-lg-12">
        <h1 class="page-header"> Ulanyjy üýtgetmek</h1>
        <hr class="hr-header">
    </div>

        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-5 offset-md-3">
                <form autocomplete="off" role="form" action="{{route('user.update',['user_id'=>$user->id])}}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="last_name" id="last_name" class="form-control input-lg" value="{{$user->last_name}}" placeholder="Familiýasy" tabindex="1">
                    </div>
                    <div class="form-group">
                        <input type="text" name="first_name" id="first_name" class="form-control input-lg" value="{{$user->first_name}}" placeholder="Ady" tabindex="1">
                    </div>
                    <div class="form-group">
                        <input type="text" name="father_name" id="father_name" class="form-control input-lg" value="{{$user->father_name}}" placeholder="Atasynyň ady"  tabindex="1">
                    </div>
                    <div class="form-group">
                        <input type="text" name="login" id="login" class="form-control input-lg" value="{{$user->login}}" placeholder="Login" tabindex="1">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control input-lg"  placeholder="Açar söz" tabindex="1">
                    </div>
                        <hr class="colorgraph">
                        <input type="submit"  class="btn btn-success float-lg-right" value="Täzele"/>
                    </form>
                </div>
            </div>
        </div>


    <script src="{{ asset('js/jquery.min.js')}}"> </script>
    <script src="{{ asset('js/bootstrap-select.min.js')}}"> </script>

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