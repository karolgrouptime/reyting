@extends('layouts.admin')
@section('title', 'Hasabad')
@section('content')
    @include('partitions.success')
    @include('partitions.error')

    <div class="col-lg-12">
        <a class="float-left text-success mt-2 mr-2" href="{{route('dashboard')}}">
            <i class="fa fa-arrow-alt-circle-left fa-2x"></i>
        </a>
        <h1 class="page-header">Maglumatlar</h1>
        <hr class="hr-header">
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12 col-xs-12">
            <div class="card">
                <div class="card-header bg-navbar">
                    <h5 class="text-light"> {{$group->number}} {{$date}}/{{$para}} </h5>
                </div>
                <ul class="list-group">
                    @php($j=0)
                    @foreach($group_rashods as $group_rashod)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                           {{$j=$j+1}}.
                            {{$group_rashod->last_name}} {{$group_rashod->first_name}}
                            <h5><span class="badge badge-success badge-pill">{{$group_rashod->value}}</span></h5>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-xs-12">
            <div class="card">
                <div class="card-header bg-navbar">
                    <h5 class="text-light"> {{$group->number}}   {{$date}}/{{$para}} </h5>
                </div>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        San/b
                        <h5><span class="badge badge-success badge-pill">{{$student_count}}</span></h5>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                       Ýüz/ý
                        <h5><span class="badge badge-success badge-pill">{{$student_count-$j}}</span></h5>
                    </li>
                    @foreach($assessments as $assessment)
                        @php($i=0)
                        @foreach($group_rashods as $group_rashod)
                            @if($assessment->id==$group_rashod->id)
                                @php($i=$i+1)
                            @endif
                        @endforeach
                        @if($i>0)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{$assessment->value}}
                                <h5><span class="badge badge-success badge-pill">{{$i}}</span></h5>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
    <hr class="hr-middle">
@endsection