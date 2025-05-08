@extends('layouts.admin')
@section('title', 'Kafedralar')
@section('content')

    @include('partitions.success')

    <div class="col-lg-12">
        <a class="float-left text-success mt-2 mr-2" href="{{route('faculties')}}">
            <i class="fa fa-arrow-alt-circle-left fa-2x"></i>
        </a>
        <h1 class="page-header"> Kafedralaryň sanawy</h1>
        <hr class="hr-header">
    </div>

    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            <a href="{{route('kathedra.create')}}" class="btn bg-navbar btn-dark float-right"><i class="fa fa-plus-circle"></i> Täze goşmak</a>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Ady</th>
            <th scope="col">Fakultet</th>
            <th scope="col">Operasiýalar</th>
        </tr>
        </thead>
        <tbody>
        @foreach($kathedras as $kathedra)
            <tr>
                <td>{{$kathedra->id}}</td>
                <td>{{$kathedra->name}}</td>
                <td>{{$kathedra->faculty->name}}</td>
                <td><a href="{{route('kathedra.edit',['faculty_id' => $kathedra->id])}}" class="btn btn-info btn-sm"> Üýtget</a>
                    <a href="{{route('kathedra.delete',['faculty_id' => $kathedra->id])}}" class="btn btn-danger"><i class="fa fa-trash"></i> </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection