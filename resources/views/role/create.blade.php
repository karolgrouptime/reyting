@extends('layouts.admin')
@section('content')

    <div class="col-lg-12">
        <h1 class="page-header"> Täze rol goşmak</h1>
        <hr class="hr-header">
    </div>

    <div class="row">
        <div class="col-xs-10 col-sm-6 col-md-3 offset-md-4">
            <form role="form" action="{{route('role.store')}}" method="POST">
                {{ csrf_field() }}
                {{--<hr class="colorgraph">--}}
                <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control input-md" placeholder="Ady" tabindex="1">
                </div>
                <div class="text-center">
                    @foreach($permissions as $permission)
                        <span>
                            <input value="{{$permission->id}}" type="checkbox" id="check" multiple="multiple" name="permissions[]">&nbsp;&nbsp;{{$permission->name}}
                        </span>
                        <br>
                    @endforeach
                </div>
                <hr class="colorgraph">
                <input type="submit"  class="btn btn-success float-lg-right" value="Goş"/>
            </form>
        </div>
    </div>
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

    <style>
        #check
        {
            width:20px; height:20px;
        }
    </style>
@endsection