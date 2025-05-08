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
{{--            <a href="{{route('video')}}" class="btn bg-navbar btn-dark float-right"><i class="fa fa-plus-circle"> </i> Wideolar</a>--}}
        </div>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th scope="col">T/b</th>
            <th scope="col">Ady</th>
            <th scope="col">Fakultet</th>
            @can('settings_show')
            <th scope="col">Operasiýalar</th>
            @endcan
        </tr>
        </thead>
        <tbody>
        @php($i=1)
        @foreach($kathedras as $kathedra)
            @if($kathedra->status==1)
                <tr style="background-color: #7ffc93">
                    <td>{{$i++}}.</td>
                    <td>{{$kathedra->name}}</td>
                    <td>{{$kathedra->faculty->name}}</td>
                    @can('settings_show')
                        <td>
                            <a href="{{route('report.kathedra',['kathedra_id' => $kathedra->id])}}">  <span class="badge badge-success badge-pill">Girmek </span></a>
                            <a href="{{route('report.block',['kathedra_id' => $kathedra->id])}}">  <span class="badge badge-danger badge-pill">Gaýtarmak</span></a>
                        </td>
                    @endcan
                </tr>
            @else
                <tr>
                    <td>{{$i++}}.</td>
                    <td>{{$kathedra->name}}</td>
                    <td>{{$kathedra->faculty->name}}</td>
                    @can('settings_show')
                        <td>
                            <a href="#">  <span class="badge badge-success badge-pill">Girmek </span></a>
                        </td>
                    @endcan
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
@endsection