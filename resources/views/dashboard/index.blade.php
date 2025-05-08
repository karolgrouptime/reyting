@extends('layouts.admin')
@section('title', 'Baş sahypa')
@section('content')
<script src="{{ asset('js/app.js')}}"defer></script>
    <div class="col-md-12">
        <h1> Baş sahypa</h1>
        <hr class="hr-header">
    </div>
    <br>
    <div class="row mb-3" id="app">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5 style="color:green;"><span class="fa fa-chart-bar fa-md"> {{\Carbon\Carbon::now()->startOfWeek()->format('d.m.y')}} - {{\Carbon\Carbon::now()->endOfWeek()->format('d.m.y')}} göreldeli toparlar (Top 15)</span></h5>
                </div>
                <div class="card-body">
                    <best-groups-component> </best-groups-component>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5  style="color:green;"><span class="fa fa-chart-bar fa-md"> {{\Carbon\Carbon::now()->startOfWeek()->format('d.m.y')}} - {{\Carbon\Carbon::now()->endOfWeek()->format('d.m.y')}} pes toparlar (Top 15) </span></h5>
                </div>
                <div class="card-body">
                    <worse-groups-component></worse-groups-component>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12">
        <div class="card">
            <div class="card-header text-center">
                <h5 style="color:green;"><span class="fa fa-chart-bar fa-md"> {{\Carbon\Carbon::now()->startOfWeek()->format('d.m.y')}} - {{\Carbon\Carbon::now()->endOfWeek()->format('d.m.y')}}  ýokary baha alan talyplar(Top 10) </span></h5>
            </div>
    <table class="table table-bordered  table-hover">
    <thead>
    <tr>
        <th scope="col">№</th>
        <th scope="col">Talyp</th>
        <th scope="col">Topar</th>
        <th scope="col">Kafedra</th>
        <th scope="col">Baha sany</th>
    </tr>
    </thead>
    <tbody>
    @php($i=1)
    @foreach($student_reports as $report)
        <tr>
            <td>{{$i++}}.</td>
            <td>{{$report->student->last_name}} {{$report->student->first_name}} </td>
            <td>{{$report->student->group->number}}</td>
            <td>{{$report->student->group->kathedra->name}} </td>
            <td class="pr-4">
               <span class="badge badge-success badge-pill">&nbsp;{{$report->five}} </span>
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>
        </div>
    </div>
    <br>
        <div class="col-md-12">
        <div class="card">
            <div class="card-header text-center">
                <h5 style="color:green;"><span class="fa fa-chart-bar fa-md"> {{\Carbon\Carbon::now()->startOfWeek()->format('d.m.y')}} - {{\Carbon\Carbon::now()->endOfWeek()->format('d.m.y')}} pes baha alan talyplar</span></h5>
            </div>
    <table class="table table-bordered  table-hover">
    <thead>
    <tr>
        <th scope="col">№</th>
        <th scope="col">Talyp</th>
        <th scope="col">Topar</th>
        <th scope="col">Kafedra</th>
        <th scope="col">Baha sany</th>
    </tr>
    </thead>
    <tbody>
    @php($i=1)
    @foreach($student_reports_two as $report)
        <tr>
            <td>{{$i++}}.</td>
            <td>{{$report->student->last_name}} {{$report->student->first_name}}</td>
            <td>{{$report->student->group->number}}</td>
            <td>{{$report->student->group->kathedra->name}} </td>
            <td class="pr-4">
               <span class="badge badge-success badge-pill"> &nbsp;{{$report->deuce}} </span>
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>
        </div>
    </div>
        
@endsection
