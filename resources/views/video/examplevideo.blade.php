@extends('layouts.admin')
@section('title', 'Wideolar')
@section('content')
    @include('partitions.success')

    <div class="main-content-wrapper section-padding-100-0">
        <div class="container-fluid justify-content-center col-lg-10">
            <div class="row justify-content-center">
                <!-- Intro News Tabs Area -->
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <script type="text/javascript" src="{{ asset('js/afterglow.min.js')}}"></script>

                        <div class="card mt-4">
                            <div class="card-header h5 text-uppercase">
                                Ähli wideolar
                            </div>
                            @foreach($kvideo as $kvid)
                                <div class="bg-white" style="padding: 1.25rem">
                                    <div class="h5">
                                        {{ $kvid->name }}
                                    </div>
                                    <hr>
                                    <div class="row">
                                        @foreach($kvid->video as $new)

                                            <br/>
                                            <div class="col-lg-2 col-sm-4 mt-2" >
                                                <a class="afterglow"
                                                   href="{{ $new->slug }}">
                                                    <div class="hovereffect">
                                                        <img class="video-image  " style="width= 193px; height= 130px;"
                                                             src="{{ url('storage/'.$new->vphoto_path) }}"
                                                             alt="Wideo">
                                                        <img src="img/core-img/Play-Icon-Logo-4.svg" alt="Wideo" class="play-button">
                                                    </div>
                                                </a>
                                                <video id="{{ $new->slug }}" width="856" height="480"  data-overscale="false" preload="none" class="d-none">
                                                    <source type="video/mp4" src="{{ url('storage/'.$new->video_path) }}" />
                                                </video>
                                                <h6 style="text-align: center; margin-top: -30px; padding: 10px;">{{$new->title}}</h6>
                                            </div>

                                        @endforeach
                                    </div>

                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="d-flex justify-content-center mt-2">{{$kvideo->links("pagination::bootstrap-4")}}</div>
                    <!-- Sidebar Widget -->
                </div>
            </div>

        </div>
    </div>

    <style>
        .bg-primary-light {
            background-color: #fcfaf6;
        }
        .hovereffect {
            width: 100%;
            height: 100%;
            float: left;
            overflow: hidden;
            position: relative;
            text-align: center;
            margin-bottom: 1.25rem;
        }
        .hovereffect img.video-image {
            max-height:212px;
            object-fit:cover;
        }
        .hovereffect img.play-button  {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
            width: 25%;
            height: 25%;
            -webkit-transition: all 0.5s;
            transition: all 0.5s;
        }
        .hovereffect:hover img.play-button {
            width: 30%;
            height: 30%;
        }
    </style>

    <style class="vjs-styles-defaults">
        .video-js {
            width: 300px;
            height: 150px;
        }

        .vjs-fluid {
            padding-top: 56.25%
        }
    </style>
    <div class="col-12 col-md-8 col-lg-4 mt-30"></div>
@endsection()