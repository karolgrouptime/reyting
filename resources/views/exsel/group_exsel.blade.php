@extends('layouts.admin')
@section('title', 'Žurnallar')
@section('content')
    <link href="{{ asset('css/flatpickr.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('js/flatpickr.js')}}"></script>
    @include('partitions.success')
    <div class="col-lg-12">
        <h4 class="page-header">&nbsp;{{$group->number}}: {{$subject->name}} dersi</h4>
    </div>
    <div id="table-scroll" class="table-scroll">
        <div class="table-wrap">
            <table id="teachers" class="table table-bordered table-sm table-striped main-table" >
                <thead>
                <tr>
                    <th scope="col" class="w-25 fixed-side"><h3 class="text-center">Talyp</h3></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th class="fixed-side"></th>
                    @foreach($lesson_dates as $date)
                        <td class="rotate border border-dark">{{\Carbon\Carbon::parse($date->date_lesson)->format('d.m.y')}}
                        </td>
                    @endforeach
                </tr>
                @php $i=0; $jem=0; $bal=0; $san=0; @endphp
                @foreach($journal->group->student as $student)
                        <tr>
                            <th class="w-25 fixed-side">
                              {{$student->last_name}} {{$student->first_name}}
                            </th>
                                @foreach($lesson_dates as $lesson_date)
                                    @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                        @if($student->id==$lesson_assessment->student_id)
                                        @if($score=$lesson_assessment->assessment_type->value=='N')
                                            <td style="display: inline;">
                                                <h5 class="d-inline-block ml-3" style="margin-right: 6px;">
                                                    <a id="edit" class="badge badge-info">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                    </a>
                                                </h5>
                                            </td>
                                            @elseif($score=$lesson_assessment->assessment_type->value=='Hasap')
                                                <td style="display: inline;">
                                                    <h6 class="d-inline-block " style="margin-left: 9px; margin-right: 6.4px;">
                                                        <a id="edit" class="badge badge-light" style="color: blue;">
                                                           Hsp
                                                        </a>
                                                    </h6>
                                                </td>
                                        @elseif($score=$lesson_assessment->assessment_type->id>1 and $score=$lesson_assessment->assessment_type->id<6)
                                            <td style="display: inline;">
                                                <h6 class="d-inline-block ml-3" style="margin-right: 11.5px;">
                                                    <a id="edit" class="badge badge-light">
                                                        {{$score=$lesson_assessment->assessment_type->value}}
                                                    </a>
                                                </h6>
                                            </td>
                                        @else
                                            <td style="display: inline;">
                                            <h6 class="d-inline-block ml-3" style="margin-right: 1.5px;">
                                                <a id="edit" class="badge badge-light">
                                                    {{$score=$lesson_assessment->assessment_type->value}}
                                                </a>
                                            </h6>
                                            </td>
                                        @endif
                                            @php  $i++; @endphp
                                        @endif
                                    @endforeach
                                    @if($i==0)
                                            <td style="display: inline;">
                                        <h5 class="d-inline-block ml-3 mr-2">
                                            <a class="badge badge-default text-success">
                                                x
                                            </a>
                                        </h5>
                                            </td>
                                    @endif
                                    @php $i=NULL; @endphp
                                @endforeach
                        </tr>
                        @endforeach
                </tbody>
                <tr class="p-4">
                    <td class="fixed-side">
                    </td>
                    <td>
                        <hr>
                    </td>
                {{--    @can('allJournalChange')
                        <td>
                            <hr>
                        </td>
                    @endcan--}}
                </tr>
                <tr>
                    <td class="w-25 fixed-side">
                        Tabşyrk
                    </td>
                        @foreach($lesson_dates as $lesson_date)
                            @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                    @if($score=$lesson_assessment->assessment_type->value=='N')
                                        @php $i++; @endphp
                                @endif
                            @endforeach
                            @if($i==0)
                                    <td style="display: inline;">
                                <h5 class="d-inline-block ml-3 mr-2"><span class="badge badge-primary" style="color: black;">0</span></h5>
                                    </td>
                            @else
                                    <td style="display: inline;">
                                <h5 class="d-inline-block ml-3 mr-2"><span class="badge badge-primary" style="color: black;">{{$i}}</span></h5>
                                    </td>
                            @endif
                            @php $i=NULL; @endphp
                        @endforeach
                </tr>
                <tr>
                    <td class="w-25 fixed-side">
                        Lukmançylyk nokady
                    </td>
                        @foreach($lesson_dates as $lesson_date)
                            @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                    @if($score=$lesson_assessment->assessment_type->value=='LN')
                                        @php $i++; @endphp
                                    @endif
                            @endforeach
                            @if($i==0)
                                    <td style="display: inline;">
                                <h5 class="d-inline-block ml-3 mr-2"><span class="badge badge-primary" style="color: black;">0</span></h5>
                                    </td>
                            @else
                                    <td style="display: inline;">
                                <h5 class="d-inline-block ml-3 mr-2"><span class="badge badge-primary" style="color: black;">{{$i}}</span></h5>
                                    </td>
                            @endif
                            @php $i=NULL; @endphp
                        @endforeach
                </tr>
                <tr>
                    <td class="w-25 fixed-side">
                        Hassahana
                    </td>
                        @foreach($lesson_dates as $lesson_date)
                            @foreach($lesson_date->lesson_assessments as $lesson_assessment)
                                    @if($score=$lesson_assessment->assessment_type->value=='H')
                                        @php $i++; @endphp
                                    @endif
                            @endforeach
                            @if($i==0)
                                    <td style="display: inline;">
                                <h5 class="d-inline-block ml-3 mr-2"><span class="badge badge-primary" style="color: black;">0</span></h5>
                                    </td>
                            @else
                                    <td style="display: inline;">
                                <h5 class="d-inline-block ml-3 mr-2"><span class="badge badge-primary" style="color: black;">{{$i}}</span></h5>
                                    </td>
                            @endif
                            @php $i=NULL; @endphp
                        @endforeach
                </tr>
            </table>
        </div>
    </div>
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
            $(".modal-body #dateId").val(dateId);
            $(".modal-body #studentId").val(studentId);

            // $('#editPermission').modal('show');
            // var url = '';
            // url = url.replace(':perm_id', id);
            // $("#forma").attr("action", url);
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

            display: inline-block;
            margin:20px -14px 23px 0.6px;
            border-bottom: #2B172E 1px solid;
        }

    </style>

@endsection