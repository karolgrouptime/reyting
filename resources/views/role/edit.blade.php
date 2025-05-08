@extends('layouts.admin')
@section('content')

    <div class="col-lg-12">
        <h1 class="page-header"> Roly täzelemek</h1>
        <hr class="hr-header">
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-3 offset-md-4">
            <form role="form" action="{{route('role.update')}}" method="POST">
                {{ csrf_field() }}
                {{--<hr class="colorgraph">--}}
                <div class="form-group">
                    <input type="text" name="name" value="{{$role->name}}" id="name" class="form-control input-lg" placeholder="Ady" tabindex="1">
                </div>

                @foreach($permissions as $permission)
                    <div class="text-center">
                    <input value="{{$permission->id}}"
                           @foreach($role->permission as $role_perm)
                                @if($role_perm->id==$permission->id)
                                    {{"checked"}}
                                @endif
                           @endforeach type="checkbox" multiple="multiple" id="check" name="permissions[]">{{$permission->name}}
                            <br>
                    </div>
                @endforeach
                <br>
                <hr class="colorgraph">

                <input type="hidden" name="role_id" value="{{$role->id}}"/>

                <input type="submit"  class="btn btn-success float-lg-right" value="Täzele"/>
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