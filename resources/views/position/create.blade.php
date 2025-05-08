@extends('layouts.admin')
@section('title', 'Wezipeler')
@section('content')

    <div class="col-lg-12">
        <h1 class="page-header"> Täze wezipe goşmak</h1>
        <hr class="hr-header">
    </div>
    @can('settings_show')
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-5 offset-md-3">
            <form role="form" action="{{route('position.store')}}" method="POST">
                {{ csrf_field() }}
                {{--<hr class="colorgraph">--}}
                <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control input-lg" placeholder="Ady" tabindex="1">
                </div>
                <br>
                <hr class="colorgraph">
                <input type="submit"  class="btn btn-success float-lg-right" value="Goş"/>
            </form>
        </div>
    </div>
    @endcan
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            $(".js-example-theme-single").select2({
                theme: "classic"
            });
        });
    </script>
    <script src="{{ asset('js/jquery.min.js')}}"> </script>
    <script src="{{ asset('js/bootstrap-select.min.js')}}"> </script>
@endsection