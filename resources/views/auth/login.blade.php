@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div style="background: white; margin-top: 100px" class="panel panel-default">
                <div class="panel-heading" style="background: #e8eee7"><p class="h3 text-center"> Elektron žurnala hoş geldiňiz</p> </div>
                    <div style="margin: 25px"  >
                        <img width="32%" src="{{asset('images/gerb.png')}}">
                        <img width="38%" class="pull-right mt-4" src="{{asset('images/flag.gif')}}">
                    </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{route('login')}}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                            <label for="login" class="col-md-4 control-label"> Ulanyjy ady:</label>
                            <div class="col-md-6">
                                <input id="login" type="login" class="form-control" name="login" value="{{ old('login') }}" required autofocus>
                                @if ($errors->has('login'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Açar söz:</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password"  required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-11">
                                <button class="btn btn-primary pull-right" type="submit">
                                    Gir
                                </button>
                                
                            </div>
                            <!-- <p style="float:right; font-size:18px; color:green;">TEL:5345 </p> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <style>
        body{
            height: 100%;
            font-family: 'PT Sans Narrow', sans-serif;
            background: url(images/banner1.jpg) no-repeat;
            background-size: cover;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -ms-background-size: cover;
            -o-background-size: cover;
        }
    </style>
@endsection
