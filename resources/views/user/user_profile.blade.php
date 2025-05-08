@extends('layouts.main')


@section('content')


    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}"/>


    <div class="col-lg-12">
        <h1 class="page-header"> Profile</h1>
    </div>


    <div class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-2">
                <div class="row">
                    <table class="table">

                       <tbody>
                        <tr>
                            <th>F.A.A.a</th>    <td>{{$user->name}}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>
                                @foreach($user->roles as $role)
                                {{$role->name}}
                                @endforeach
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/jquery.min.js')}}"> </script>
    <script src="{{ asset('js/bootstrap-select.min.js')}}"> </script>


@endsection