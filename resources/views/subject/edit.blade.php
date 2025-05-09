@extends('layouts.admin')
@section('title', 'Dersi üýtgetmek')
@section('content')
    <div class="col-lg-12">
        <h1 class="page-header"> Dersi üýtgetmek</h1>
        <hr class="hr-header">
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-5 offset-md-3">

            <form role="form" action="{{route('subject.update',['subject_id'=>$subject->id])}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control input-lg" value="{{$subject->name}}" placeholder="Ders" tabindex="1">
                </div>
                <hr class="colorgraph">
                <input type="submit"  class="btn btn-success float-lg-right" value="Üýtget"/>
            </form>
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