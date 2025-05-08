@extends('layouts.admin')
@section('title', 'Ulanyjylar')
@section('content')
    <div class="col-lg-12">
        <h1 class="page-header"> Täze ulanyjy goşmak</h1>
        <hr class="hr-header">
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-5 offset-md-3">
            <form autocomplete="off" role="form" action="{{route('user.store')}}" method="POST">
                {{ csrf_field() }}
                {{--<hr class="colorgraph">--}}
                <div class="form-group">
                    <input type="text" name="last_name" id="last_name" class="form-control input-lg"
                           placeholder="Familiýasy" tabindex="1">
                </div>
                <div class="form-group">
                    <input type="text" name="first_name" id="first_name" class="form-control input-lg" placeholder="Ady"
                           tabindex="1">
                </div>
                <div class="form-group">
                    <input type="text" name="father_name" id="father_name" class="form-control input-lg"
                           placeholder="Atasynyň ady" tabindex="1">
                </div>
                <div class="form-group">
                    <input type="text" name="login" id="login" class="form-control input-lg" placeholder="Login"
                           tabindex="1">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control input-lg"
                           placeholder="Açar söz" tabindex="1">
                </div>
                <div class="form-group">
                    <label for="role_id">
                        Role:&nbsp; &nbsp;
                        <select class="js-example-theme-single form-control" name="role_id">
                            @foreach($roles as $role)
                                @if($role->id<>2 and $role->id<>4)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </label>
                </div>
                {{--<h5 style="display: inline;">Žurnalist maglumatlary::</h5>--}} <p style="display: inline; color: red;">(Roly žurnalist bolsa aşakdaky maglumatlar goşulýar);</p>
                <div class="row" style="border:1px solid #d8d8d8; border-radius: 5px;">
                <div class="col-md-6">
                    <label> Topary:&nbsp;&nbsp;</label>
                    <select class="js-example-theme-single form-control" name="group_id">
                        <option value="{{NULL}}" selected>Ýok</option>
                        @foreach($groups as $group)
                            <option value="{{$group->id}}">{{$group->number}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Okuwa giren ýyly:</label>
                    <input type="date" class="form-control" name="recept_date" id="recept_date"/>
                </div>
                </div>
                <div class="custom-control form-control-lg custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="status">
                    <label class="custom-control-label" for="customCheck1"> &nbsp;Status</label>
                </div>
                <br>
                <hr class="colorgraph">
                <input type="submit" class="btn btn-success float-lg-right" value="Goş"/>
            </form>
        </div>
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