@extends('layouts.admin')
@section('title', 'Reyting')
@section('content')
{{--    <script src="{{ asset('js/app.js')}}"defer></script>--}}
    <div class="col-md-12">
        <h2>Reýting</h2>
        <hr class="hr-header">
    </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h6 style="color:green;"><span class="fa fa-chart-bar fa-md"></span>Soňky aralyk bahalar boýunça talyplaryň reýtingi</h6>
                </div>
                <div class="ml-2 mr-2">
                <table class="table table-hover" id="Reyting" style="width: 100%">
                    <thead>
                    <tr>
                        <th scope="col">Orny</th>
                        <th scope="col">Talyp</th>
                        <th scope="col">Topar</th>
                        <th scope="col">Kafedra</th>
                        <th scope="col">Ortaça baha</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i=1)
                    @foreach($student_reytings as $report)
                        <tr>
                            <td>{{$i++}}.</td>
                            <td>{{$report->student->last_name}} {{$report->student->first_name}} </td>
                            <td>{{$report->student->group->number}}</td>
                            <td>{{$report->student->group->kathedra->name}} </td>
                            <td class="pr-4">
                                <span class="badge badge-success badge-pill">&nbsp;{{$report->average}} </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
<script>
    $(document).ready(function () {
        $('#Reyting').DataTable({
            "pageLength": 200,
            "responsive": true,
            mark: true,
            scrollX: true,
            language: {
                emptyTable: "Žurnal tapylmady",
                info: "_START_ - _END_ aralygy görkezilýär | Jemi _TOTAL_",
                infoEmpty: "0 žurnal görkezilýär",
                infoFiltered: "(_MAX_ maglumatdan gözleg esasynda)",
                infoPostFix: "",
                lengthMenu: "Görkez _MENU_ ",
                loadingRecords: "Ýüklenýär...",
                processing: "Dowam edýär...",
                search: "Gözleg",
                zeroRecords: "Gözlegiňize göra žurnal tapylmady :(",
                paginate: {
                    first: "Ilkinji",
                    previous: "Öňki",
                    next: "Indiki",
                    last: "Soňky"
                }
            }
        });
    });
</script>
@endsection
