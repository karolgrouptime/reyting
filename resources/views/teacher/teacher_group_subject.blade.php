@extends('layouts.admin')
@section('title', 'Žurnallar')
@section('content')

    <link href="{{ asset('css/flatpickr.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('js/flatpickr.js')}}"></script>

    @include('partitions.success')
    @php $i=0; $jem=0; $bal=0; $san=0; @endphp
    <div class="col-lg-12">
        @if($rate_can==1)
            <a href="#">
                <i class="fa fa-plus-circle fa-lg float-right" data-toggle="modal"
                           data-target="#addDate"></i><span data-toggle="modal" data-target="#addDate"
                                                            class="float-right"
                                                            style="margin-top: -5px;margin-right: 5px">Täze sene:</span></a>
        @endif
        <a class="float-left text-success mt-2" href="{{route('teacher.groupSubjects',['group_id'=>$group->id])}}">
            <i class="fa fa-arrow-alt-circle-left fa-2x"></i>
        </a>
        <h1 class="page-header"> &nbsp; {{$group->number}} : {{$subject->name}} </h1>
        <hr class="hr-header">
    </div>

    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
        </div>
    </div>
    <div id="table-scroll" class="table-scroll">
        <div class="table-wrap">
            <table id="teachers" class="table table-bordered table-sm table-striped main-table">
                <thead>
                <tr class="">
                    <th scope="col" class="w-25 fixed-side"><h3 class="text-center">Talyp</h3></th>
                    <th scope="col"></th>
                    @if($rate_can==1)
                        <th style="width:30px;">Sene we baha</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th class="fixed-side"></th>
                    @foreach($lesson_dates as $date)
                        @if($date->number_lesson==07)
                            <td class="bg-navbar rotate border border-dark "><a style="color:black" href="#"
                                                                                id="dataEdit" data-toggle="modal"
                                                                                data-studentid="{{$date->id}}"
                                                                                data-dateid="{{$date->date_lesson}}"
                                                                                data-target="#editDate">
                                    {{\Carbon\Carbon::parse($date->date_lesson)->format('d.m')."/J"}}
                                </a>
                            </td>
                            @elseif($date->number_lesson=='08')
                            <td class="badge-info rotate border border-dark "><a style="color:black" href="#"
                                                                                id="dataEdit" data-toggle="modal"
                                                                                data-studentid="{{$date->id}}"
                                                                                data-dateid="{{$date->date_lesson}}"
                                                                                data-target="#editDate">
                                    {{\Carbon\Carbon::parse($date->date_lesson)->format('d.m')."/H"}}
                                </a>
                            </td>
                        @elseif($date->number_lesson=='09')
                            <td class="badge-info rotate border border-dark "><a style="color:black" href="#"
                                                                              id="dataEdit" data-toggle="modal"
                                                                              data-studentid="{{$date->id}}"
                                                                              data-dateid="{{$date->date_lesson}}"
                                                                              data-target="#editDate">
                                    {{\Carbon\Carbon::parse($date->date_lesson)->format('d.m')."/S"}}
                                </a>
                            </td>
                        @else

                            <td class="rotate border border-dark"><a href="#" id="dataEdit" data-toggle="modal"
                                                                     data-studentid="{{$date->id}}"
                                                                     data-number_lessonid="{{$date->number_lesson}}"
                                                                     data-dateid="{{$date->date_lesson}}"
                                                                     data-target="#editDate">
                                    {{\Carbon\Carbon::parse($date->date_lesson)->format('d.m')."/".$date->number_lesson}}
                                </a>
                            </td>
                        @endif

                    @endforeach
                    @if($rate_can==1)
                        <td></td>
                    @endif
                </tr>
                @php $i=0; $j=1; @endphp
                @foreach($journal->group->student as $student)
                    <tr>
                        <th class="w-25 fixed-side"> {{$j++}}.
                            {{$student->last_name}}  {{$student->first_name}}
                        </th>
                        <td class="p-1" data-spy="scroll" data-target=".navbar" data-offset="50">
                            @foreach($lesson_dates as $lesson_date)
                                @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                    @if($student->id==$lesson_assessment->student_id)
                                        @if($score=$lesson_assessment->assessment_type->value=='N')
                                            <h5 class="d-inline-block" style="margin-right: 15px; margin-left: 20px;">
                                                <a class="badge badge-info" id="edit" data-toggle="modal"
                                                   data-dateid="{{$lesson_date->id}}"
                                                   data-lessondate="{{$lesson_date->date_lesson}}"
                                                   data-lesid="{{$lesson_date->number_lesson}}"
                                                   data-studentid="{{$student->id}}"
                                                   data-studentfname="{{$student->last_name}} {{$student->first_name}}"
                                                   data-target="#assesmentChange">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h5>
                                        @elseif($score=$lesson_assessment->assessment_type->value=='H')
                                            <h5 class="d-inline-block  ml-3" style="margin-right: 17.3px;">
                                                <a class="badge badge-info" id="edit" data-toggle="modal"
                                                   data-dateid="{{$lesson_date->id}}"
                                                   data-lessondate="{{$lesson_date->date_lesson}}"
                                                   data-lesid="{{$lesson_date->number_lesson}}"
                                                   data-studentid="{{$student->id}}"
                                                   data-studentfname="{{$student->last_name}} {{$student->first_name}}"
                                                   data-target="#assesmentChange">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h5>
                                        @elseif($score=$lesson_assessment->assessment_type->value=='LN')
                                            &nbsp;<h5 class="d-inline-block ml-3 mr-1">
                                                <a class="text-light badge badge-danger" id="edit" data-toggle="modal"
                                                   data-dateid="{{$lesson_date->id}}"
                                                   data-lessondate="{{$lesson_date->date_lesson}}"
                                                   data-lesid="{{$lesson_date->number_lesson}}"
                                                   data-studentid="{{$student->id}}"
                                                   data-studentfname=" {{$student->last_name}} {{$student->first_name}}"
                                                   data-target="#assesmentChange">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h5>

                                        @elseif($score=$lesson_assessment->assessment_type->value=='GM')
                                            &nbsp;<h6 class="d-inline-block  mr-3" style="margin-left: 7px;">
                                                <a id="edit" data-toggle="modal" data-dateid="{{$lesson_date->id}}"
                                                   data-lessondate="{{$lesson_date->date_lesson}}"
                                                   data-lesid="{{$lesson_date->number_lesson}}"
                                                   data-studentid="{{$student->id}}"
                                                   data-studentfname="{{$student->last_name}} {{$student->first_name}}"
                                                   data-target="#assesmentChange"
                                                   class="text-light badge badge-danger">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h6>
                                        @elseif($score=$lesson_assessment->assessment_type->value=='Iş/s')
                                            &nbsp;<h6 class="d-inline-block  mr-3" style="margin-left: 6.5px;">
                                                <a class="badge" id="edit" data-toggle="modal"
                                                   data-dateid="{{$lesson_date->id}}"
                                                   data-lessondate="{{$lesson_date->date_lesson}}"
                                                   data-lesid="{{$lesson_date->number_lesson}}"
                                                   data-studentid="{{$student->id}}"
                                                   data-studentfname="{{$student->last_name}} {{$student->first_name}}"
                                                   data-target="#assesmentChange"
                                                   class="badge badge-light">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h6>
                                        @elseif($score=$lesson_assessment->assessment_type->value=='M/ç')
                                            &nbsp;<h6 class="d-inline-block mr-2" style="margin-left: 14px;">
                                                <a class="badge" id="edit" data-toggle="modal"
                                                   data-dateid="{{$lesson_date->id}}"
                                                   data-lessondate="{{$lesson_date->date_lesson}}"
                                                   data-lesid="{{$lesson_date->number_lesson}}"
                                                   data-studentid="{{$student->id}}"
                                                   data-studentfname="{{$student->last_name}} {{$student->first_name}}"
                                                   data-target="#assesmentChange"
                                                   class="badge badge-light">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h6>
                                        @elseif($score=$lesson_assessment->assessment_type->value=='Hasap')
                                            &nbsp;<h6 class="d-inline-block mr-3" style="margin-left: 11.5px;">
                                                <a id="edit" data-toggle="modal" data-dateid="{{$lesson_date->id}}"
                                                   data-lessondate="{{$lesson_date->date_lesson}}"
                                                   data-lesid="{{$lesson_date->number_lesson}}"
                                                   data-studentid="{{$student->id}}"
                                                   data-studentfname="{{$student->last_name}} {{$student->first_name}}"
                                                   data-target="#assesmentChange"
                                                   class="badge badge-light">
                                                    <img src="{{asset('hasap.jpg')}}"
                                                         style="width: 15px; height: 23px;">
                                                </a>
                                            </h6>
                                        @elseif($score=$lesson_assessment->assessment_type->value=='R')
                                            <h5 class="d-inline-block ml-3" style="margin-right: 17.3px;">
                                                <a class="badge badge-info" id="edit" data-toggle="modal"
                                                   data-dateid="{{$lesson_date->id}}"
                                                   data-lessondate="{{$lesson_date->date_lesson}}"
                                                   data-lesid="{{$lesson_date->number_lesson}}"
                                                   data-studentid="{{$student->id}}"
                                                   data-studentfname="{{$student->last_name}} {{$student->first_name}}"
                                                   data-target="#assesmentChange">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h5>
                                        @elseif($score=$lesson_assessment->assessment_type->value=='Iş/t')
                                            &nbsp;<h6 class="d-inline-block  mr-3" style="margin-left: 9px;">
                                                <a class="badge" id="edit" data-toggle="modal"
                                                   data-dateid="{{$lesson_date->id}}"
                                                   data-lessondate="{{$lesson_date->date_lesson}}"
                                                   data-lesid="{{$lesson_date->number_lesson}}"
                                                   data-studentid="{{$student->id}}"
                                                   data-studentfname="{{$student->last_name}} {{$student->first_name}}"
                                                   data-target="#assesmentChange"
                                                   class="badge badge-light">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h6>
                                        @elseif($score=$lesson_assessment->assessment_type->value=='D/b')
                                            &nbsp;<h6 class="d-inline-block mr-2"
                                                      style="margin-left: 14.5px; color: green;">
                                                <a class="badge  badge-light" id="edit" data-toggle="modal"
                                                   data-dateid="{{$lesson_date->id}}"
                                                   data-lessondate="{{$lesson_date->date_lesson}}"
                                                   data-lesid="{{$lesson_date->number_lesson}}"
                                                   data-studentid="{{$student->id}}"
                                                   data-studentfname="{{$student->last_name}} {{$student->first_name}}"
                                                   data-target="#assesmentChange"
                                                   class="badge badge-light">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h6>
                                        @elseif($score=$lesson_assessment->assessment_type->value=='D/ý')
                                            &nbsp;<h6 class="d-inline-block mr-2" style="margin-left: 14.5px;">
                                                <a class="badge  badge-light" id="edit" data-toggle="modal"
                                                   data-dateid="{{$lesson_date->id}}"
                                                   data-lessondate="{{$lesson_date->date_lesson}}"
                                                   data-lesid="{{$lesson_date->number_lesson}}"
                                                   data-studentid="{{$student->id}}"
                                                   data-studentfname="{{$student->last_name}} {{$student->first_name}}"
                                                   data-target="#assesmentChange"
                                                   class="badge badge-light">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h6>
                                        @elseif($score=$lesson_assessment->assessment_type->value=='T/s')
                                            &nbsp;<h6 class="d-inline-block mr-2"
                                                      style="margin-left: 17px; color:blue;">
                                                <a id="edit" data-toggle="modal" data-dateid="{{$lesson_date->id}}"
                                                   data-studentid="{{$student->id}}"
                                                   data-lessondate="{{$lesson_date->date_lesson}}"
                                                   data-lesid="{{$lesson_date->number_lesson}}"
                                                   data-studentfname="{{$student->last_name}} {{$student->first_name}}"
                                                   data-target="#assesmentChange" class="badge badge-light">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h6>
                                        @else
                                            <h4 class="d-inline-block " style="margin-right: 15px; margin-left: 17px;">
                                                <a class="badge badge-light" id="edit"
                                                   data-toggle="modal"
                                                   data-dateid="{{$lesson_date->id}}"
                                                   data-lessondate="{{$lesson_date->date_lesson}}"
                                                   data-lesid="{{$lesson_date->number_lesson}}"
                                                   data-studentid="{{$student->id}}"
                                                   data-studentfname="{{$student->last_name}} {{$student->first_name}}"
                                                   data-target="#assesmentChange">
                                                    {{$score=$lesson_assessment->assessment_type->value}}</a>
                                            </h4>
                                            @if($score=='2'||$score=='3'||$score=='4'||$score=='5')
                                                @php $san++; $jem=$jem+(int)$score @endphp
                                            @endif
                                        @endif
                                        @php  $i++; @endphp
                                    @endif
                                @endforeach
                                @if($i==0)
                                    <h4 class="d-inline-block ml-3 mr-3">
                                        <a href="#" id="edit" data-toggle="modal" data-dateid="{{$lesson_date->id}}"
                                           data-lessondate="{{$lesson_date->date_lesson}}"
                                           data-lesid="{{$lesson_date->number_lesson}}"
                                           data-studentid="{{$student->id}}"
                                           data-studentfname="{{$student->last_name}} {{$student->first_name}}"
                                           data-target="#assesmentChange"
                                           class="badge badge-default text-success"
                                           style="border: 0.3px solid #293ced;">
                                            x
                                        </a>
                                    </h4>
                                    {{--<h4 class="d-inline-block ml-4 mr-4"><span class="badge badge-warning">x</span></h4>--}}
                                @endif
                                @php $i=NULL; @endphp
                            @endforeach
                        </td>
                        @if($rate_can==1)
                            <td style="width:7%;">
                                <form action="{{route('assessment.make')}}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="form-inline m-xs-0">
                                        <input class="float-left" style="width:35px;height: 20px" type="number"
                                               name="assessment"/>
                                        <input type="hidden" class="form-group" name="journal_id"
                                               value="{{$journal->id}}"/>
                                        <input type="hidden" name="student_id" value="{{$student->id}}"/>
                                        <select style="width:60px;" tabindex="-1" name="lesson_date_id"
                                                class="float-left">
                                            @foreach($journal->lesson_dates_limit as $date)
                                                <option value="{{$date->id}}">{{\Carbon\Carbon::parse($date->date_lesson)->format('d.m')."/".$date->number_lesson}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </td>
                        @endif
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
                    @if($rate_can==1)
                        <td>
                            <hr>
                        </td>
                    @endif
                </tr>
                <tr>
                    <td class="fixed-side">
                        Narýad
                    </td>
                    <td class="p-2" data-spy="scroll" data-target=".navbar" data-offset="50">
                        @foreach($lesson_dates as $lesson_date)
                            @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                @if($score=$lesson_assessment->assessment_type->value=='N')
                                    @php $i++; @endphp
                                @endif
                            @endforeach
                            @if($i==0)
                                <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">0</span></h4>
                            @else
                                <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">{{$i}}</span>
                                </h4>
                            @endif
                            @php $i=NULL; @endphp
                        @endforeach
                    </td>
                    @if($rate_can==1)
                        <td>
                        </td>
                    @endif
                </tr>
                <tr>
                    <td class="fixed-side">
                        Lukmançylyk nokady
                    </td>
                    <td class="p-2" data-spy="scroll" data-target=".navbar" data-offset="50">
                        @foreach($lesson_dates as $lesson_date)
                            @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                @if($score=$lesson_assessment->assessment_type->value=='LN')
                                    @php $i++; @endphp
                                @endif
                            @endforeach
                            @if($i==0)
                                <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">0</span></h4>
                            @else
                                <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">{{$i}}</span>
                                </h4>
                            @endif
                            @php $i=NULL; @endphp
                        @endforeach
                    </td>
                    @if($rate_can==1)
                        <td>
                        </td>
                    @endif
                </tr>
                <tr>
                    <td class="fixed-side">
                        Hassahana
                    </td>
                    <td class="p-2" data-spy="scroll" data-target=".navbar" data-offset="50">
                        @foreach($lesson_dates as $lesson_date)
                            @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                @if($score=$lesson_assessment->assessment_type->value=='H')
                                    @php $i++; @endphp
                                @endif
                            @endforeach
                            @if($i==0)
                                <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">0</span></h4>
                            @else
                                <h4 class="d-inline-block ml-1 mr-0">
                                    <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">{{$i}}</span>
                                    </h4>
                                </h4>
                            @endif
                            @php $i=NULL; @endphp
                        @endforeach
                    </td>
                    @if($rate_can==1)
                        <td>
                        </td>
                    @endif
                </tr>
                <tr>
                    <td class="fixed-side">
                        Çäre
                    </td>
                    <td class="p-2" data-spy="scroll" data-target=".navbar" data-offset="50">
                        @foreach($lesson_dates as $lesson_date)
                            @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                @if($score=$lesson_assessment->assessment_type->value=='M/ç')
                                    @php $i++; @endphp
                                @endif
                            @endforeach
                            @if($i==0)
                                <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">0</span></h4>
                            @else
                                <h4 class="d-inline-block ml-1 mr-0">
                                    <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">{{$i}}</span>
                                    </h4>
                                </h4>
                            @endif
                            @php $i=NULL; @endphp
                        @endforeach
                    </td>

                    @if($rate_can==1)
                        <td>
                        </td>
                    @endif
                </tr>
                <tr>
                    <td class="fixed-side">
                        Dabaraly ýöriş
                    </td>
                    <td class="p-2" data-spy="scroll" data-target=".navbar" data-offset="50">
                        @foreach($lesson_dates as $lesson_date)
                            @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                @if($score=$lesson_assessment->assessment_type->value=='D/ý')
                                    @php $i++; @endphp
                                @endif
                            @endforeach
                            @if($i==0)
                                <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">0</span></h4>
                            @else
                                <h4 class="d-inline-block ml-1 mr-0">
                                    <h4 class="d-inline-block ml-3 mr-3"><span class="badge badge-primary">{{$i}}</span>
                                    </h4>
                                </h4>
                            @endif
                            @php $i=NULL; @endphp
                        @endforeach
                    </td>

                    @if($rate_can==1)
                        <td>
                        </td>
                    @endif
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <style>
        .endMenu {
            color: #10201f;
            font-family: "Times New Roman";
            font-size: 22px;
        }
    </style>
    {{--End Relation subject--}}
    <style>
        .table-scroll {
            position: relative;
            overflow: hidden;
        }

        .table-wrap {
            width: 100%;
            overflow: auto;
        }

        .table-scroll th, .table-scroll td {
            white-space: nowrap;
            vertical-align: top;
        }

        .clone {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
        }

        .clone th, .clone td {
            visibility: hidden;
        }

        .clone tbody th {
            visibility: visible;
        }

        .clone .fixed-side {
            background: #eee;
            visibility: visible;
        }

        .clone thead, .clone tfoot {
            background: transparent;
        }

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

            display: inline-block;
            margin: 20px -4px 20px 0.6px;
            border-bottom: #2B172E 1px solid;
        }

    </style>

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
                                    <input id="date" type="date" name="date_lesson"
                                           value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" class="form-control">
                                </div>
                            </div>
                        </div>

                        @if($subject->id != 629)
                        <div class="col-md-4">
                            <div class="modal-body mx-2">
                                <label>Para:</label>
                                <div class="input-group">
                                    <!-- <input type="number" name="number_lesson" value="1" class="form-control"> -->
                                    <select class="select2" id="number_lesson" name="number_lesson" type="text"
                                            style="width: 250px;">
                                        <option value="1"> 1</option>
                                        <option value="2"> 2</option>
                                        <option value="3"> 3</option>
                                        <option value="4"> 4</option>
                                        <option value="07">Aralyk/J</option>
                                        <option value="08">Bahaly hasap</option>
                                        <option value="09">Synag</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                            @else
                            <input name="number_lesson" value="5" type="hidden">
                        @endif
                        <input type="hidden" name="journal_id" value="{{$journal->id}}"
                               class="form-control">
                        <div class="modal-footer d-flex">
                            <input type="submit" class="btn btn-primary float-right" value="Goş"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($rate_can==1)
        <!-- Modal -->
        <div class="modal fade" id="assesmentChange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{route('assessment.edit')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <input class="form-control" id="studentFname" name="studentFname" style="color: #1c71ff;">
                            <!-- <h5 class="modal-title" id="exampleModalLabel"></h5> -->
                            <!-- <h4> </h4> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <input id="teacher_id" name="teacher_id" value="{{auth()->user()->role[0]->id}}"
                                   type="hidden"/>
                            <input id="subject_id" name="subject_id" value="{{$subject->id}}" type="hidden"/>
                            <input id="lessonDate" name="lessonDate" type="hidden"/>
                            <input id="lesId" name="lesId" type="hidden"/>

                            <input id="dateId" name="dateId" type="hidden"/>
                            <input id="studentId" name="studentId" type="hidden"/><br>
                            <label>Baha:<br>
                                <select class="select2" id="assessmentId" name="assessmentId" type="text"
                                        style="width: 250px;">
                                    <option value="0">Ýok</option>
                                    @foreach($assessments as $assessment)
                                        @if($subject->id == 629 )
                                            @if($assessment->id>5)
                                        <option value="{{$assessment->id}}"> {{$assessment->value}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                            @endif
                                            @else
                                            <option value="{{$assessment->id}}"> {{$assessment->value}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                        @endif


                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Ýap</button>
                            <button type="submit" class="btn btn-primary">Üýtget</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if($subject->id != 629)
        <!--modal for dateUpdate-->
        <div class="col-md-4">
            <div class="modal fade" id="editDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{route('journalLessonDate.update')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="modal-header text-center">
                                <h4 class="modal-title">Senäni üýtgetmek: </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="col-md-12">
                                <div class="modal-body mx-2">
                                    <label>Sene :</label>
                                    <div class="input-group" style="width: 350px;">
                                        <input id="dateId" name="dateId" type="date" class="form-control"> <br>
                                        <input id="studentId" name="studentId" type="hidden">
                                        &nbsp; &nbsp; &nbsp;
                                        {{--                                        <input type="number" id="number_lessonId" name="number_lesson" class="form-control">--}}
                                        <select class="select2" name="number_lesson" type="number"
                                                style="width: 150px;">
                                            <option value="1"> 1</option>
                                            <option value="2"> 2</option>
                                            <option value="3"> 3</option>
                                            <option value="4"> 4</option>
                                            <option value="07">Aralyk/J</option>
                                            <option value="08">Bahaly hasap</option>
                                            <option value="09">Synag</option>
                                        </select>
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
            @endif
    @endif

    <!--modal for nationality-->
    <script>
        // requires jquery library
        jQuery(document).ready(function () {
            jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');
            var left = $('.table-wrap').width();
            $('.table-wrap').scrollLeft(left);

            $(".select2").select2({
                theme: "classic",
                "language": {
                    "noResults": function () {
                        return "Gözlege görä hiç zat tapylmady";
                    }
                }
            });
        });
        $(document).on("click", "#edit", function () {
            var dateId = $(this).data('dateid');
            var studentId = $(this).data('studentid');
            var studentFname = $(this).data('studentfname');
            var lessonDate = $(this).data('lessondate');
            var lesId = $(this).data('lesid');

            $(".modal-body #dateId").val(dateId);
            $(".modal-body #studentId").val(studentId);
            $(".modal-header #studentFname").val(studentFname);
            $(".modal-body #lessonDate").val(lessonDate);
            $(".modal-body #lesId").val(lesId);

            // $('#editPermission').modal('show');
            // var url = '';
            // url = url.replace(':perm_id', id);
            // $("#forma").attr("action", url);
        });
        //js date format
        $("#date").flatpickr({
            enableTime: false,
            dateFormat: "d-m-Y",
            defaultDate: "{{\Carbon\Carbon::now()->format('d-m-Y')}}",
        });
        //js date format

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
@endsection