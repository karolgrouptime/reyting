@extends('layouts.admin')
@section('title', 'Ulanyjylar')
@section('content')

    @include('partitions.success')

    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <div class="col-lg-12">
        <h1 class="page-header">Adminler</h1>
        <hr class="hr-header">
    </div>
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            @can('users_change')
                <a href="{{route('user.create')}}" class="btn bg-navbar btn-dark float-right"><i class="fa fa-plus-circle"></i> Täze goşmak</a>
            @endcan
        </div>
    </div>
    <table id="users" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
        <tr>
        <th scope="col">Id</th>
            <th scope="col">F.A.a</th>
            <th scope="col">login</th>
            <th scope="col">rol</th>
        </tr>
        </thead>
        <tbody>
        @foreach($user_roles as $user_role)
            <tr>
                <td>{{$user_role->user->id}}</td>
                <td>{{$user_role->user->first_name}} {{$user_role->user->last_name}}</td>
                <td>{{$user_role->user->login}}</td>
                <td>{{$user_role->role->name}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection