@extends('layouts.admin')
@section('title', 'Umumy statistika')
@section('content')
    @include('partitions.success')
    @include('partitions.error')
    <div class="col-lg-12">
        <a href="{{route('expenditure')}}" class="btn text-light bg-navbar float-right mt-3"> Rashod </a>
        <h1 class="page-header"> Umumy statistika </h1>
        <hr class="hr-header">
    </div>
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center bg-navbar text-light">
                    Düzüm boýunça mugallym
                </li>
                @foreach($countPositionTeachers as $countPositionTeacher)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{$countPositionTeacher->name}}
                        <h5><span class="badge badge-success badge-pill">{{$countPositionTeacher->count}}</span></h5>
                    </li>
                @endforeach

            </ul>
        </div>
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center bg-navbar text-light">
                    Fakultetlerde talyp sany
                </li>
                @foreach($facultyStudents as $facultyStudent)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{$facultyStudent->name}}
                        {{$facultyStudent->sum}}
                        <h5><span class="badge badge-success badge-pill"> {{$facultyStudent->count}}</span></h5>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
<br>
    <br>
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center bg-navbar text-light">
                    Kafedralarda talyp sany
                </li>
                @foreach($facultyStudents as $facultyStudent)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{$facultyStudent->name}}
                        {{$facultyStudent->sum}}
                        <h5><span class="badge badge-success badge-pill"> {{$facultyStudent->count}}</span></h5>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection