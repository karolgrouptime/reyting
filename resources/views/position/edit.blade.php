@extends('layouts.admin')
@section('title', 'Wezipeler')
@section('content')

    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}"/>

    <div class="col-lg-12">
        <h1 class="page-header"> Wezipäni üýtgetmek</h1>
        <hr class="hr-header">
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-5 offset-md-3">
            <form role="form" action="{{route('position.update',['position_id'=>$position->id])}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    @can('settings_show')
                    <input type="text" name="name" id="name" class="form-control input-lg" value="{{$position->name}}" placeholder="Familiýasy" tabindex="1">
                        @endcan
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