@extends('layouts.admin')
@section('title', 'Meýilnama goşmak')
@section('content')
    @include('partitions.success')
    @include('partitions.error')
    <div class="col-lg-12">
        <a class="float-left text-success mt-2 mr-3" href="{{route('dashboard')}}">
            <i class="fa fa-arrow-alt-circle-left fa-2x"> </i>
        </a>
        <h1 class="page-header">Meýilnamalaryň sanawy:</h1>
        <hr class="hr-header">
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="assessments-tab" data-toggle="tab" href="#assessments" role="tab"
               aria-controls="assessments"
               aria-selected="false">Mugallymlar</a>
        </li>
            <li class="nav-item">
                <a class="nav-link" id="positions-tab" data-toggle="tab" href="#positions" role="tab"
                   aria-controls="positions"
                   aria-selected="false">Meýilnamalar</a>
            </li>
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#semesters" role="tab"
               aria-controls="semesters"
               aria-selected="true">Rashod</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <!-- semesters tab-->
        <div class="tab-pane fade" id="assessments" role="tabpanel" aria-labelledby="assessments-tab">
            @include('report.teacher_off')
        </div>
        <div class="tab-pane fade" id="positions" role="tabpanel" aria-labelledby="positions-tab">
            @include('report.teacher_pro')
        </div>
        <div class="tab-pane fade show active" id="semesters" role="tabpanel" aria-labelledby="home-tab">
            {{--            @if(auth()->user()->teacher->position->id==7)--}}
            @include('report.kathedra_rashod')
            {{--            @endif--}}
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(".js-example-theme-single").select2({
                theme: "classic",
                "language": {
                    "noResults": function () {
                        return "Gözlege görä maglumat tapylmady.";
                    }
                }
            });
        });
        $(function () {
            // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                // save the latest tab; use cookies if you like 'em better:
                localStorage.setItem('lastTab', $(this).attr('href'));
            });

            // go to the latest tab, if it exists:
            var lastTab = localStorage.getItem('lastTab');
            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            }
        });
    </script>
@endsection