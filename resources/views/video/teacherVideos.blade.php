@extends('layouts.admin')
@section('title', 'Wideolar')
@section('content')
    @include('partitions.success')
    <div class="col-lg-12">
        <a class="float-left text-success mt-2 mr-2" href="{{route('dashboard')}}">
            <i class="fa fa-arrow-alt-circle-left fa-2x"></i>
        </a>
        <h1 class="page-header">Wideolar </h1>
        <hr class="hr-header">
    </div>
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            <form role="form" action="{{route('video.store')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="submit" class="btn bg-navbar float-right m-1" value="Ugratmak"/>
                <input type="text" class="btn float-right m-1" name="name" style="width: 500px; height: 43px; border: 0.5px solid #374ea2;" placeholder="Wideo ady" title="enter your  name if any.">
                <input type="file" name="video_path" class="btn float-right m-1" style="border: 0.5px solid #374ea2;" placeholder="WIDEONY SAÝLA" title="WIDEONY SAÝLA">
                <i class="badge badge-success badge-pill"> W i d e o </i>
            </form>
        </div>
    </div>
    <!-- Intro News Tabs Area -->
    <div class="card mt-4">
        <div class="card-header h5 text-uppercase">
            Ähli wideolar
        </div>
        <div class="bg-white" style="padding:1.25rem">
            <hr>
            <div class="row">
                <script type="text/javascript" src="{{ asset('js/afterglow.min.js')}}"></script>
                @foreach($videos as $new)
                    <br/>
                    <div class="col-lg-2 col-sm-4 mt-2">
                        <a class="afterglow"
                           href="{{ $new->slug }}">
                            <div class="hovereffect">
                                <img class="video-image" style="width:193px; height:130px;"
                                     src="{{ url('storage/'.$new->photo_path) }}"
                                     alt="Wideo">
                                <img src="{{asset('images/Play-Icon-Logo-4.svg')}}" alt="Wideo"
                                     class="play-button"> <br/>
                                <i class="fa">{{str_limit($new->name, 30)}}</i>
                            </div>
                        </a>
                        <video id="{{ $new->slug }}" width="900" height="524" data-overscale="false" preload="none"
                               class="d-none">
                            <source type="video/mp4" src="{{ url('storage/'.$new->video_path) }}"/>
                        </video>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-2">{{$videos->links("pagination::bootstrap-4")}}</div>
    <!-- Sidebar Widget -->
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
            max-height: 212px;
            object-fit: cover;
        }

        .hovereffect img.play-button {
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