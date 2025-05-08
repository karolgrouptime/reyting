@extends('layouts.admin')
@section('title', 'Žurnallar')
@section('content')
    @include('partitions.success')
    <link href="{{ asset('css/flatpickr.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('js/flatpickr.js')}}"> </script>

    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datatables.mark.js') }}"></script>
    <link href="{{ asset('css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    @can('allJournalChange')
    <div style="margin-left: 3%;">
    </div>
    @endcan
    <div class="col-lg-12">
        @can('allJournalChange')
            <a href="#"> <i class="fa fa-plus-circle fa-lg float-right" data-toggle="modal" data-target="#addDate"></i> <span data-toggle="modal" data-target="#addDate" class="float-right" style="margin-top: -5px;margin-right: 5px">Täze sene:</span></a>
        @endcan
            <a class="float-left text-success mt-2" href="{{route('groupCourseSubjects',['group_id'=>Crypt::encrypt($group->id),'course_id'=>Crypt::encrypt($course_id)])}}">
                <i class="fa fa-arrow-alt-circle-left fa-2x"> </i>
            </a>
        <h1 class="page-header"> &nbsp;{{$group->number}}: {{$subject->name}} dersi</h1>
        <hr class="hr-header">
    </div>
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
        </div>
    </div>
    <div id="table-scroll" class="table-scroll">
        <div class="table-wrap">
            <table id="export-info" class="table table-bordered table-sm table-striped main-table">
                <thead>
                <tr class="">
                    <th scope="col" class="w-25 fixed-side"><h3 class="text-center">Talyp</h3></th>
                    <th scope="col"></th>
                    @can('allJournalChange')
                        <th style="width:30px;">Sene we baha</th>
                    @endcan
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th class="fixed-side"></th>
                    @foreach($lesson_dates as $date)
                        <td class="rotate border border-dark"> <a href="#"  id="dataEdit" data-toggle="modal" data-studentid="{{$date->id}}"  data-dateid="{{$date->date_lesson}}" data-number_lessonid="{{$date->number_lesson}}"   data-target="#editDate">
                                {{\Carbon\Carbon::parse($date->date_lesson)->format('d.m')."/".$date->number_lesson}}
                            </a>
                        </td>
                    @endforeach

                    @can('allJournalChange')
                        <td></td>
                    @endcan
                </tr>
                @php $i=0; $jem=0; $bal=0; $san=0; @endphp
                @foreach($journal->group->student as $student)
                    @if(auth()->user()->role[0]->id==4 and auth()->user()->student_id==$student->id)
                        @php  @endphp
                    <tr>
                        <th class="w-25 fixed-side">
                            <p>{{$student->last_name}} {{$student->first_name}}</p>
                        </th>
                        <td class="p-1 ml-3" data-spy="scroll" data-target=".navbar" data-offset="50">

                            @foreach($lesson_dates as $lesson_date)

                                @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                    @if($student->id==$lesson_assessment->student_id)

                                        @if($score=$lesson_assessment->assessment_type->value=='N')
                                        <h5 class="d-inline-block ml-3 mr-3">
                                            <a id="edit" data-toggle="modal"
                                               data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-info">
                                                {{$score=$lesson_assessment->assessment_type->value}}
                                            </a>
                                        </h5>
                                        @elseif($score=$lesson_assessment->assessment_type->value=='LN')
                                            <h5 class="d-inline-block ml-3 mr-2">
                                                <a id="edit" data-toggle="modal" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="text-light badge badge-danger">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h5>
                                        @elseif($score=$lesson_assessment->assessment_type->value=='GM')
                                            &nbsp;<h5 class="d-inline-block  ml-3 mr-2">
                                                <a id="edit" data-toggle="modal" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-light">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h5>
                                            @elseif($score=$lesson_assessment->assessment_type->value=='R')
                                                <h5 class="d-inline-block ml-3" style="margin-right: 17.3px;">
                                                    <a id="edit" data-toggle="modal"
                                                       data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-info">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                    </a>
                                                </h5>
                                        @else
                                            <h4 class="d-inline-block ml-3 mr-3">
                                                <a id="edit" data-toggle="modal" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-light">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                    @if($score=='2'||$score=='3'||$score=='4'||$score=='5')
                                                    @php $san++; $jem=$jem+(int)$score @endphp
                                                        @endif
                                                </a>
                                            </h4>
                                        @endif
                                            @php  $i++; @endphp
                                    @endif
                                @endforeach
                                    @if($i==0)
                                        <h4 class="d-inline-block ml-3 mr-3">
                                            <a id="edit" data-toggle="modal" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-default text-success">
                                                x
                                            </a>
                                        </h4>
                                    @endif
                                    @php $i=NULL; @endphp
                            @endforeach
                         </td>
                        @elseif(auth()->user()->role[0]->id=1)
                        <tr>
                            <th class="w-25 fixed-side">
                                <p>{{$student->last_name}}  {{$student->first_name}}</p>
                            </th>
                            <td class="p-1 ml-3" data-spy="scroll" data-target=".navbar" data-offset="50">
                                @foreach($lesson_dates as $lesson_date)
                                    @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                        @if($student->id==$lesson_assessment->student_id)

                                            @if($score=$lesson_assessment->assessment_type->value=='N')
                                                <h5 class="d-inline-block ml-3" style="margin-right: 17.3px;">
                                                    <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}"
                                                       data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-info">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                    </a>
                                                </h5>
                                                @elseif($score=$lesson_assessment->assessment_type->value=='H')
                                                    <h5 class="d-inline-block ml-3" style="margin-right: 17.3px;">
                                                        <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}"
                                                           data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-info">
                                                            {{$score=$lesson_assessment->assessment_type->value}}
                                                        </a>
                                                    </h5>
                                            @elseif($score=$lesson_assessment->assessment_type->value=='LN')
                                                <h5 class="d-inline-block ml-3 mr-2">
                                                    <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="text-light badge badge-danger">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                    </a>
                                                </h5>
                                            @elseif($score=$lesson_assessment->assessment_type->value=='GM')
                                                &nbsp;<h6 class="d-inline-block  mr-3" style="margin-left: 0.4rem;">
                                                    <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-light">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                    </a>
                                                </h6>
                                            @elseif($score=$lesson_assessment->assessment_type->value=='Iş/s')
                                                &nbsp;<h6 class="d-inline-block  mr-3" style="margin-left: 6.5px;">
                                                    <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-light">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                    </a>
                                                </h6>
                                            @elseif($score=$lesson_assessment->assessment_type->value=='M/ç')
                                                &nbsp;<h6 class="d-inline-block mr-2" style="margin-left: 13.4px;">
                                                    <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-light">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                    </a>
                                                </h6>
                                                @elseif($score=$lesson_assessment->assessment_type->value=='D/ý')
                                                &nbsp;<h6 class="d-inline-block mr-2" style="margin-left: 13.4px;">
                                                    <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-light">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                    </a>
                                                </h6>
                                                @elseif($score=$lesson_assessment->assessment_type->value=='D/b')
                                                &nbsp;<h6 class="d-inline-block mr-2" style="margin-left: 13.4px;">
                                                    <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-light">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                    </a>
                                                </h6>
                                                @elseif($score=$lesson_assessment->assessment_type->value=='Hasap')
                                                    &nbsp;<h6 class="d-inline-block mr-3" style="margin-left: 0.7rem;">
                                                        <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-light">
                                                            <img src="{{asset('hasap.jpg')}}" style="width: 15px; height: 25px;">
                                                        </a>
                                                    </h6>
                                                    @elseif($score=$lesson_assessment->assessment_type->value=='R')
                                                <h5 class="d-inline-block ml-3" style="margin-right: 17.3px;">
                                                    <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}"
                                                       data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-info">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                    </a>
                                                </h5>
                                                @elseif($score=$lesson_assessment->assessment_type->value=='Iş/t')
                                                &nbsp;<h6 class="d-inline-block  mr-3" style="margin-left: 8px;">
                                                    <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-light">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                    </a>
                                                </h6>
                                            @elseif($score=$lesson_assessment->assessment_type->value=='T/s')
                                                &nbsp;<h6 class="d-inline-block mr-2" style="margin-left: 14.4px; color:blue;">
                                                    <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-light">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                    </a>
                                                </h6>
                                                @else
                                                <h4 class="d-inline-block ml-3 mr-3">
                                                    <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-light">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                        @if($score=='2'||$score=='3'||$score=='4'||$score=='5')
                                                            @php $san++; $jem=$jem+(int)$score @endphp
                                                        @endif
                                                    </a>
                                                </h4>
                                            @endif
                                            @php  $i++; @endphp
                                        @endif
                                    @endforeach
                                    @if($i==0)
                                        <h4 class="d-inline-block ml-3 mr-3">
                                            <a id="edit" data-toggle="modal" data-lessondate="{{$lesson_date->date_lesson}}" data-lesid="{{$lesson_date->number_lesson}}" data-dateid="{{$lesson_date->id}}" data-studentid="{{$student->id}}" data-target="#assesmentChange" class="badge badge-default text-success">
                                                x
                                            </a>
                                        </h4>
                                    @endif
                                    @php $i=NULL; @endphp
                                @endforeach
                            </td>
                        @endif
                        @can('allJournalChange')
                        <td style="width:7%;">
                            <form action="{{route('assessment.make')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-inline m-xs-0">
                                    <input  class="float-left" style="width:38px;height: 25px" type="number" name="assessment"/>
                                <input type="hidden" class="form-group" name="journal_id" value="{{$journal->id}}"/>
                                <input type="hidden" name="student_id" value="{{$student->id}}"/>
                                <select style="width:80px;" tabindex="-1" name="lesson_date_id" class="float-left">
                                    @foreach($journal->lesson_dates_limit as $date)
                                        <option value="{{$date->id}}">{{\Carbon\Carbon::parse($date->date_lesson)->format('d.m')."/".$date->number_lesson}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </form>
                        </td>
                        @endcan
                    </tr>
                @endforeach
                </tbody>
                    <tfoot class="mt-4">
                    <tr class="p-4">
                        <td class="fixed-side">
                        </td>
                        <td>
                           <hr>
                        </td>
                        @can('allJournalChange')
                            <td>
                                <hr>
                            </td>
                        @endcan
                    </tr>
                        <tr>
                            <td class="fixed-side">
                                Narýad
                            </td>
                            <td class="p-2" data-spy="scroll" data-target=".navbar" data-offset="50">
                                @foreach($lesson_dates as $lesson_date)
                                    @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                        @if(auth()->user()->role[0]->id==4 and auth()->user()->student_id==$lesson_assessment->student_id)
                                        @if($score=$lesson_assessment->assessment_type->value=='N')
                                            @php $i++; @endphp
                                        @endif
                                        @elseif(auth()->user()->role[0]->id<>4)
                                            @if($score=$lesson_assessment->assessment_type->value=='N')
                                                @php $i++; @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                    @if($i==0)
                                        <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">0</span></h4>
                                    @else
                                            <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">{{$i}}</span></h4>
                                        @endif
                                    @php $i=NULL; @endphp
                                @endforeach
                            </td>
                            @can('allJournalChange')
                                <td>
                                </td>
                            @endcan
                        </tr>
                        <tr>
                            <td class="fixed-side">
                                Lukmançylyk nokady
                            </td>
                            <td class="p-2" data-spy="scroll" data-target=".navbar" data-offset="50">
                                @foreach($lesson_dates as $lesson_date)
                                    @foreach($lesson_date->lesson_assessments as $lesson_assessment)

                                        @if(auth()->user()->role[0]->id==4 and auth()->user()->student_id==$lesson_assessment->student_id)

                                        @if($score=$lesson_assessment->assessment_type->value=='LN')
                                            @php $i++; @endphp
                                        @endif
                                        @elseif(auth()->user()->role[0]->id<>4)
                                            @if($score=$lesson_assessment->assessment_type->value=='LN')
                                                @php $i++; @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                    @if($i==0)
                                        <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">0</span></h4>
                                    @else
                                        <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">{{$i}}</span></h4>
                                    @endif
                                    @php $i=NULL; @endphp
                                @endforeach
                            </td>
                            @can('allJournalChange')
                                <td>
                                </td>
                            @endcan
                        </tr>
                        <tr>
                            <td class="fixed-side">
                                Hassahana
                            </td>
                            <td class="p-2" data-spy="scroll" data-target=".navbar" data-offset="50">
                                @foreach($lesson_dates as $lesson_date)
                                    @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                        @if(auth()->user()->role[0]->id==4 and auth()->user()->student_id==$lesson_assessment->student_id)
                                        @if($score=$lesson_assessment->assessment_type->value=='H')
                                            @php $i++; @endphp
                                        @endif
                                            @elseif(auth()->user()->role[0]->id<>4)
                                            @if($score=$lesson_assessment->assessment_type->value=='H')
                                                @php $i++; @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                    @if($i==0)
                                        <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">0</span></h4>
                                    @else
                                        <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">{{$i}}</span></h4>
                                    @endif
                                    @php $i=NULL; @endphp
                                @endforeach
                            </td>
                            @can('allJournalChange')
                                <td>
                                </td>
                            @endcan
                        </tr>
                    </tfoot>
            </table>
        </div>
    </div>
    <div class="float-right mr-5">
{{--        <p class="endMenu">Bahalaryň sany: {{$san}}</p>
        <p class="endMenu"> Jemi: {{$jem}}</p>--}}
        @if($san<>0)
        @php $bal=$jem/$san; @endphp
        @endif
        <p class="endMenu">Ortaça baha:{{$bal}}</p>
     
            <a href="{{route('exdanny',['subject_id'=>$subject->id,'group_id'=>$group->id,'semester_id'=>$semester_id])}}" class="btn" style="border: 1px solid black"><i class="fa fa-download">Export</i> </a>
       
    </div>
    <style>
        .endMenu{
           color: #cd2709;
            font-family: "Times New Roman";
            font-size: 22px;
        }
    </style>
@can('assessment_change')
    <div class="modal fade" id="assesmentChange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{route('assessment.edit')}}" method="POST">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    <input id="teacher_id" name="teacher_id" value="{{auth()->user()->role[0]->id}}" type="hidden"/>
                        <input id="subject_id" name="subject_id" value="{{$subject->id}}" type="hidden"/>
                        <input id="lessonDate" name="lessonDate" type="hidden"/>
                        <input id="lesId" name="lesId" hidden/>
                    
                        <input id="dateId" name="dateId" type="hidden"/>
                        <input id="studentId" name="studentId" type="hidden"/><br>
                        <label>Baha:<br>
                            <select class="select2" id="assessmentId" name="assessmentId" type="text" style="width: 250px;">
                                <option value="0">Ýok</option>
                                @foreach($assessments as $assessment)
                                    <option value="{{$assessment->id}}"> {{$assessment->value}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ýap</button>
                        <button type="submit"  class="btn btn-primary">Üýtget</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

          <div class="col-md-4">
            <div class="modal fade" id="editDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{route('journalLessonDate.update')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="modal-header text-center">
                                <h4 class="modal-title">Senäni üýtgetmek</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="col-md-12">
                                <div class="modal-body mx-2">
                                    <label>Sene:</label>
                                    <div class="input-group"   style="width: 350px;">
                                        <input id="dateId" name="dateId" type="date" class="form-control">
                                        <input id="studentId" name="studentId" type="hidden" class="form-control">
                                        &nbsp; &nbsp; &nbsp;
                                        <input type="number" id="number_lessonId" name="number_lesson" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex">
                                <input type="submit" class="btn btn-primary float-right" value="Üýtget"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endcan
    <!--modal for nationality-->
    <div class="col-md-4">
    <div class="modal fade" id="addDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('journalLessonDate.store')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-header text-center ">
                        <h4 class="modal-title"> Täze sene</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="col-md-12">
                        <div class="modal-body mx-2">
                            <label>Sene:</label>
                            <div class="input-group">
                                <input id="date" name="date_lesson" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                    <div class="modal-body mx-2">
                        <label>Para:</label>
                        <div class="input-group">
                            <input type="number" name="number_lesson" value="1" class="form-control">
                            <input type="hidden" name="journal_id" value="{{$journal->id}}" class="form-control">
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer d-flex">
                        <input type="submit" class="btn btn-primary float-right" value="Goş"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script>
        $('#export-info').DataTable({
            dom:'Bfrtip',
            buttons:[
              'copy'
            ]
        });
    </script>
    <!--modal for nationality-->
    <script>
        // requires jquery library
        $(document).ready(function() {
            jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');
            var left = $('.table-wrap').width();
            $('.table-wrap').scrollLeft(left);

        $(".select2").select2({
            theme: "classic",
            "language": {
                "noResults": function(){
                    return "Gözlege görä hiç zat tapylmady";
                }
            }
        });
        });
        //js date format
        $("#date").flatpickr({
            enableTime: false,
            dateFormat: "d-m-Y",
            defaultDate: "{{\Carbon\Carbon::now()->format('d-m-Y')}}",
        });
        //js date format
        $(document).on("click", "#edit", function () {
            var dateId = $(this).data('dateid');
            var studentId = $(this).data('studentid');
             var lessonDate = $(this).data('lessondate');
             var lesId = $(this).data('lesid');

            $(".modal-body #dateId").val(dateId);
            $(".modal-body #studentId").val(studentId);
            $(".modal-body #lessonDate").val(lessonDate);
            $(".modal-body #lesId").val(lesId);

            // $('#editPermission').modal('show');
            // var url = '';
            // url = url.replace(':perm_id', id);
            // $("#forma").attr("action", url);
        });
           //js date toggle
           $(document).on("click", "#dataEdit", function () {
            var studentId = $(this).data('studentid');
            var dateId = $(this).data('dateid');
            var number_lessonId = $(this).data('number_lessonid');

            $(".modal-body #studentId").val(studentId);
            $(".modal-body #dateId").val(dateId);
            $(".modal-body #number_lessonId").val(number_lessonId);
        });
    </script>

    <style>
        .table-scroll {
            position:relative;
            overflow:hidden;
        }
        .table-wrap {
            width:100%;
            overflow:auto;
        }

        .table-scroll th, .table-scroll td {
            white-space:nowrap;
            vertical-align:top;
        }

        .clone {
            position:absolute;
            top:0;
            left:0;
            pointer-events:none;
        }
        .clone th, .clone td {
            visibility:hidden;
        }

        .clone tbody th {
            visibility:visible;
        }
        .clone .fixed-side {
            background:#eee;
            visibility:visible;
        }
        .clone thead, .clone tfoot{background:transparent;}

        .rotate {
            /* Safari */
            -webkit-transform: rotate(-90deg);
            /* Firefox */
            -moz-transform: rotate(-90deg);
            /* IE */
            -ms-transform: rotate(-90deg);
            /* Opera */
            -o-transform: rotate(-90deg);
            /* Internet Explorer */
            filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);

            display: inline-block; margin:20px -5px 20px 0.6px;
            border-bottom: #2B172E 1px solid;
        }

    </style>

@endsection