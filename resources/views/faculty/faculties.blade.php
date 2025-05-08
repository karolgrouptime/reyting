@extends('layouts.admin')
@section('content')

    @include('partitions.success')

    <div class="col-lg-12">
        <h1 class="page-header"> Fakultetleriň sanawy</h1>
        <hr class="hr-header">
    </div>

    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            <a href="{{route('faculty.create')}}" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"></i> Täze goşmak</a>
            <a href="{{route('kathedras')}}" title="Kafedralar" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-chalkboard"></i> Kafedralar</a>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Ady</th>
            <th scope="col">Operasiýalar</th>
        </tr>
        </thead>
        <tbody>
        @foreach($faculties as $faculty)
            <tr>
                <td>{{$faculty->id}}</td>
                <td>{{$faculty->name}}</td>
                <td><a href="{{route('faculty.edit',['faculty_id' => $faculty->id])}}" class="btn btn-info"> <i class="fa fa-edit"></i></a>
                    <a href="{{route('faculty.delete',['faculty_id' => $faculty->id])}}" class="btn btn-danger"><i class="fa fa-trash"></i> </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection