<div class="row my-3 mx-1">
    <div class="col-md-12 text-right">
        <form action="{{route('teacher.setting')}}" method="GET">
            <input type="submit" class="btn bg-navbar float-right m-1" value="Gozle"/>
            <input type="date" class="btn bg-navbar float-right m-1" name="date" value="{{$date}}" placeholder="sene" title="sene">
            <select class="select2 btn bg-navbar float-right m-1" id="para" name="para" type="text">
                @for($i=1;  $i<=5; $i++)
                    <option {{$i==$para?'selected':''}} value="{{$i}}">{{$i}}-nji para</option>
                @endfor
            </select>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center bg-navbar text-light">
                {{auth()->user()->teacher->kathedra->name}} - Talyplaryň taýýarlyk we okuw sapaklarynyň gatnaşygynyň hasaby.
            </li>
            <br>
            <div class="ml-2 mr-2">
                <table id="group_report_week" class="table table-hover table-bordered text-center m-md-1" style="width:100%">
                    <thead>
                    <tr>
                        <th>Topar:</th>
                        <th>GM</th>
                        <th>R</th>
                        <th>Iş/t</th>
                        <th>D/b</th>
                        <th>Tab</th>
                        <th>LN</th>
                        <th>Has</th>
                        <th>Iş/s</th>
                        <th>M/ç</th>
                        <th>Tus</th>
                        <th>D/ý</th>
                        <th>Jemi</th>
                        <th>Amal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($groupReportForWeek as $group)
                        <tr>
                            <td>{{$group->number}}</td>
                            <td class="pr-4">
                                <h5><span class="badge badge-success badge-pill">{{$group->deuce}} </span></h5>
                            </td>
                            <td class="pr-4">
                                <h5><span class="badge badge-success badge-pill">{{$group->three}} </span></h5>
                            </td>
                            <td class="pr-4">
                                <h5><span class="badge badge-success badge-pill">{{$group->four}} </span></h5>
                            </td>
                            <td class="pr-4">
                                <h5><span class="badge badge-success badge-pill">{{$group->five}} </span></h5>
                            </td>
                            <td class="pr-4">
                                <h5><span class="badge badge-success badge-pill">{{$group->attire}} </span></h5>
                            </td>
                            <td class="pr-4">
                                <h5><span class="badge badge-success badge-pill">{{$group->medical_unit}} </span></h5>
                            </td>
                            <td class="pr-4">
                                <h5><span class="badge badge-success badge-pill">{{$group->hospital}} </span></h5>
                            </td>
                            <td class="pr-4">
                                <h5><span class="badge badge-success badge-pill">{{$group->official_trip}} </span></h5>
                            </td>
                            <td class="pr-4">
                                <h5><span class="badge badge-success badge-pill">{{$group->cultural_event}} </span></h5>
                            </td>
                            <td class="pr-4">
                                <h5><span class="badge badge-success badge-pill">{{$group->arist}} </span></h5>
                            </td>
                            <td class="pr-4">
                                <h5><span class="badge badge-success badge-pill">{{$group->porad}} </span></h5>
                            </td>
                            <td class="pr-4">
                                <h5><span class="badge badge-success badge-pill">{{$group->total_count}} </span></h5>
                            </td>
                            <td class="pr-4">
                                <h5><a href="{{route('open.expenditure',['para'=>$para, 'date'=>$date ,'group_id'=>$group->id])}}"> <span class="badge badge-success badge-pill">G o r m e k</span></a></h5>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </ul>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#group_report_week').DataTable({
            "pageLength": 10,
            "responsive": true,
            order: [[12, 'desc']],
            mark: true,
            scrollX: true,
            language: {
                emptyTable:       "Maglumat tapylmady.",
                info:             "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                infoEmpty:        "0 žurnal görkezilýär",
                infoFiltered:     "(_MAX_ maglumatdan gözleg esasynda)",
                infoPostFix:      "",
                lengthMenu:       "Görkez _MENU_ ",
                loadingRecords:   "Ýüklenýär...",
                processing:       "Dowam edýär...",
                search:           "Gözleg",
                zeroRecords:      "Gözlegiňize göra žurnal tapylmady :(",
                paginate: {
                    first:        "Ilkinji",
                    previous:     "Öňki",
                    next:         "Indiki",
                    last:         "Soňky"
                }
            }
        });
    });
</script>