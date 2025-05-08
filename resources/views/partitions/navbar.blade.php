
<nav class="navbar  navbar-expand-md navbar-dark bg-navbar">
    <i class="fa fa-list" id="menu-toggle" style="font-size: 23px"> </i>

    <button tabindex="-1" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a tabindex="-1" class="nav-link text-light" href="#">
{{--               <h6> <i class="fa">Admin: 40-52-01</i> </h6>--}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" tabindex="-1" href="#">
                    @if(isset(auth()->user()->role[0]))
                  <h6 style="color:yellow;"> <i class="fa fa-user" > </i> {{ auth()->user()->role[0]->name }}: {{ auth()->user()->last_name }} {{ auth()->user()->first_name }}</h6>
                    @else
                       Myhman
                    @endif

                </a>
            </li>
            <li>
                <span class="nav-link text-light display-5" id="MyClockDisplay" onload="showTime()"></span>
            </li>
        </ul>
    </div>
</nav>
{{--@if(isset(auth()->user()->teacher))--}}
{{--    <div class="modal fade" id="TeacherHelp" role="dialog" aria-labelledby="myModalLabel"--}}
{{--         aria-hidden="true">--}}
{{--        <div class="modal-dialog" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <form action="{{route('teacherHelp.store')}}" method="POST" enctype="multipart/form-data">--}}
{{--                    {{ csrf_field() }}--}}
{{--                    <div class="modal-header text-center">--}}
{{--                        <h6 class="modal-title">Mugallym şahsy bellikleri üçin:</h6>--}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                            <span aria-hidden="true">&times;</span>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body mx-2">--}}
{{--                        <textarea type="text" name="text" class="form-control input-lg" placeholder="parollarym" rows="4">--}}
{{--                            {{\App\Teacher::where('id',auth()->user()->teacher->id)->first()->photo_path}}--}}
{{--                            </textarea>--}}
{{--                    </div>--}}
{{--                    <input type="hidden" name="teacher_id" value="{{auth()->user()->teacher->id}}">--}}
{{--                    <div class="modal-footer d-flex">--}}
{{--                        <p style="color: green;">Login-parollar, bellikler we ş.m üçin 400simwol</p>--}}
{{--                        <input type="submit" class="btn btn-primary float-right" value="Ýatda sakla"/>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endif--}}
<!-- digital watch -->
<script>

    function showTime(){
        var date = new Date();

        var h = date.getHours(); // 0 - 23
        var m = date.getMinutes(); // 0 - 59
        var s = date.getSeconds(); // 0 - 59

        if(h == 0){
            h = 12;
        }
        if(h > 12){
            h = h - 12;
            session = "PM";
        }

        h = (h < 10) ? "0" + h : h;
        m = (m < 10) ? "0" + m : m;
        s = (s < 10) ? "0" + s : s;

        var time = h + ":" + m + ":" + s;
        document.getElementById("MyClockDisplay").innerText = time;
        document.getElementById("MyClockDisplay").textContent = time;

        setTimeout(showTime, 1000);
    }
    showTime();
</script>