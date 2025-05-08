@extends('layouts.admin')
@section('title', 'Kafedralar')
@section('content')

    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}"/>

    <div class="col-lg-12">
        <h1 class="page-header"> Kafedra üýtgetmek</h1>
        <hr class="hr-header">
    </div>
        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-5 offset-md-3">
                    <form role="form" action="{{route('kathedra.update',['faculty_id'=>$kathedra->id])}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control input-lg" value="{{$kathedra->name}}" placeholder="Familiýasy" tabindex="1">
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group ">
                                    <label for="faculty_id"><h5>Fakulteti:</h5></label>
                                    <select style="width: 100%" class="js-example-theme-single form-control p-4" name="faculty_id">
                                        @foreach($faculties as $faculty)
                                            <option {{$faculty->id==$kathedra->faculty->id?'selected':''}} value="{{$faculty->id}}">{{$faculty->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="colorgraph">
                        <input type="submit"  class="btn btn-success float-lg-right" value="Üýtget"/>
                    </form>
                </div>
            </div>
        </div>

    <script src="{{ asset('js/jquery.min.js')}}"> </script>
    <script src="{{ asset('js/bootstrap-select.min.js')}}"> </script>

    <script>
        $(document).ready(function() {
            $(".js-example-theme-single").select2({
                theme: "classic"
            });
        });
    </script>
@endsection