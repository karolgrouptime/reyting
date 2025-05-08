<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">TGMHI </div>
    <div class="list-group">
    @if(isset(auth()->user()->role[0]))
        <a href="{{route('dashboard')}}" tabindex="-1" title="Baş sahypa" class="list-group-item list-group-item-action bg-light">Baş sahypa <i class="fa fa-tachometer-alt float-right"></i></a>
            @else
            <a href="{{route('login')}}" tabindex="-1" title="Baş sahypa" class="list-group-item list-group-item-action bg-light">Içeri girmek<i class="fa fa-angle-right float-right"></i></a>
{{--            <a href="{{route('reyting')}}" tabindex="-1" title="Reyting" class="list-group-item list-group-item-action bg-light">Reyting<i class="fa fa-tachometer-alt float-right"></i></a>--}}
{{--            <a href="{{asset('/journal.mp4')}}"  class="list-group-item list-group-item-action bg-light">Wideo gollanma<i class="fa fa-download float-right"></i></a>--}}
        @endif
        @can('serviceManInfo')
            <a href="{{route('expenditure')}}" tabindex="-1" title="Umumy maglumat" class="list-group-item list-group-item-action bg-light">Umumy maglumat<i class="fa fa-info float-right mr-1"></i></a>
        @endcan
        @can('teacher_show')
        <a href="{{route('teachers')}}" title="Mugallymlar" tabindex="-1" class="list-group-item list-group-item-action bg-light"><i class="fa fa-graduation-cap float-right"></i> Mugallymlar</a>
        @endcan
        @can('faculties_show')
            <a href="{{route('faculties')}}" tabindex="-1" title="Fakultet-kafedralar" class="list-group-item list-group-item-action bg-light"><i class="fa fa-chalkboard-teacher float-right"></i> Fakultet-kafedralar</a>
        @endcan
        @can('users_show')
            <a href="{{route('users')}}" tabindex="-1" title="Ulanyjylar" class="list-group-item list-group-item-action bg-light">Ulanyjylar <i class="fa fa-address-card float-right"></i></a>
            <a href="{{route('report')}}" title="Hasabatlar" tabindex="-1" class="list-group-item list-group-item-action bg-light"> <i class="fa fa-pen float-right"> </i>Hasabatlar</a>
            @endcan
        @can('student_show')
            <a href="{{route('students')}}" tabindex="-1" title="Talyplar" class="list-group-item list-group-item-action bg-light">Talyplar <i class="fa fa-users float-right"></i></a>
        @endcan
        @can('allJournal')
        <a href="{{route('journals')}}" tabindex="-1" title="Elektron žurnal" class="list-group-item list-group-item-action bg-light">Elektron žurnal<i class="fa fa-journal-whills float-right"></i></a>
        @endcan
        @can('myJournal')
                <a href="{{route('teacher.setting')}}" title="Sazlamalar" tabindex="-1" class="list-group-item list-group-item-action bg-light">Sazlamalar<i class="fa fa-cog fa-spin float-right"></i></a>
                <a href="{{route('teacher.groups')}}" tabindex="-1" title="Žurnallar" class="list-group-item list-group-item-action bg-light">Žurnallar<i class="fa fa-journal-whills float-right"></i></a>
                <a href="{{route('report.preparation')}}" tabindex="-1" title="Özbaşdak taýýarlyk" class="list-group-item list-group-item-action bg-light">Özbaşdak-taýýarlyk<i class="fa fa-journal-whills float-right"></i></a>
            @endcan
        @can('settings_show')
        <a href="{{route('settings')}}" title="Sazlamalar" tabindex="-1" class="list-group-item list-group-item-action bg-light">Sazlamalar <i class="fa fa-cog fa-spin float-right"></i></a>
        @endcan
        @can('logs_show')
        <a href="{{route('logs')}}" tabindex="-1" title="Loglar" class="list-group-item list-group-item-action bg-light">Loglar <i class="fa fa-search-location float-right"></i></a>
        @endcan
        <!-- @if(isset(auth()->user()->role[0])) -->
        <a class="list-group-item list-group-item-action bg-light" href="{{route('logout')}}" onclick="return logout(event);">
            Çykmak<i class="fa fa-door-open float-right"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        <!-- @endif -->
    </div>
</div>
<script type="text/javascript">
    function logout(event){
        event.preventDefault();
        var check = confirm("Do you really want to logout?");
        if(check){
            document.getElementById('logout-form').submit();
        }
    }
</script>