@extends('layouts.admin')
@section('title', 'Sazlamalar')
@section('content')

    @include('partitions.success')
    <div class="col-lg-12">
        <h1 class="page-header"> Sazlamalar sahypasy</h1>

        <hr class="hr-header">
    </div>
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
        @if(auth()->user()->role[0]->id==2)
                <a href="{{route('load.teachers')}}" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"></i> Mugallym-ders</a>
            <a href="{{route('trainingPrograms')}}" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"></i> Meýilnamalar</a>
                @endif
                @can('settings_show')
                    <a href="{{route('load.teachers')}}" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"></i> Mugallym-ders</a>
                    <a href="{{route('trainingPrograms')}}" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"></i> Meýilnamalar</a>
                    <a href="{{route('subjects')}}" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"></i>Dersler</a>
                    <a href="{{route('studentConfigure')}}" title="Talyplar sazlamalary" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-users"></i> Talyplar sazlamalary </a>
                    @endcan
        </div>
    </div>

    @if(auth()->user()->role[0]->id==2)
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="assessments-tab" data-toggle="tab" href="#assessments" role="tab" aria-controls="assessments"
                   aria-selected="false">Bahalar</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- assessments tab-->
            <div class="tab-pane fade show active" id="assessments" role="tabpanel" aria-labelledby="assessments-tab">
                @include('assessment.assessments')
            </div>
            <!-- assessments tab-->
        </div>
    @endif
    @can('settings_show')
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#semesters" role="tab" aria-controls="semesters"
               aria-selected="true"> Ýarymýyllyklar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="assessments-tab" data-toggle="tab" href="#assessments" role="tab" aria-controls="assessments"
               aria-selected="false">Bahalar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="positions-tab" data-toggle="tab" href="#positions" role="tab" aria-controls="positions"
               aria-selected="false">Wezipeler</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="degrees-tab" data-toggle="tab" href="#degrees" role="tab" aria-controls="degrees"
               aria-selected="false">Derejeler</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="roles-tab" data-toggle="tab" href="#roles" role="tab" aria-controls="roles"
               aria-selected="false">Rollar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="permission-tab" data-toggle="tab" href="#permission" role="tab" aria-controls="permission"
               aria-selected="false">Rugsatlar</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <!-- semesters tab-->
        <div class="tab-pane fade show active" id="semesters" role="tabpanel" aria-labelledby="home-tab">
            @include('semester.semesters')
        </div>
        <!-- semesters tab-->
        <!-- assessments tab-->
        <div class="tab-pane fade" id="assessments" role="tabpanel" aria-labelledby="assessments-tab">
            @include('assessment.assessments')
        </div>
        <!-- assessments tab-->

        <!-- positions tab-->
        <div class="tab-pane fade" id="positions" role="tabpanel" aria-labelledby="positions-tab">
            @include('position.positions')
        </div>
        <!-- positions tab-->

        <!-- degrees tab-->
        <div class="tab-pane fade" id="degrees" role="tabpanel" aria-labelledby="degrees-tab">
            @include('degree.degrees')
        </div>
        <!-- degrees tab-->

        <!-- roles tab-->
        <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">
            @include('role.roles')
        </div>
        <!-- roles tab-->

        <!-- permission tab-->
        <div class="tab-pane fade" id="permission" role="tabpanel" aria-labelledby="permission-tab">
            @include('permission.permissions')
        </div>
        <!-- permission tab-->

    </div>

    <script>
        $(function() {
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
    @endcan
@endsection