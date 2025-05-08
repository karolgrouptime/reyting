@extends('layouts.admin')
@section('content')

    <div class="col-lg-12">
        <h1 class="page-header"> Topary üýtgetmek</h1>
        <hr class="hr-header">
    </div>

        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-5 offset-md-3">
                    <form role="form" action="{{route('group.update',['group_id'=>$group->id])}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" name="number" id="number" class="form-control input-lg" value="{{$group->number}}" placeholder="Topar nomeri" tabindex="1">
                        </div>
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control input-lg" value="{{$group->name}}" placeholder="Topar ady" tabindex="1">
                        </div>
                        <div class="form-group ">
                    <label for="group_id">
                      Kafedrasy:&nbsp;&nbsp;
                        <select  class="js-example-theme-single form-control" name="kathedra_id">
                            @foreach($kathedries as $kathedra)
                                <option {{$group->kathedra->id==$kathedra->id?'selected':''}} value="{{$kathedra->id}}">{{$kathedra->name}} </option>
                            @endforeach
                        </select>
                    </label>
                </div>
                        <hr class="colorgraph">
                        <input type="submit"  class="btn btn-success float-lg-right" value="Üýtget"/>
                    </form>
                </div>
            </div>
        </div>
    <script src="{{ asset('js/jquery.min.js')}}"> </script>
    <script>
        $(document).ready(function() {
            $(".js-example-theme-single").select2({
                theme: "classic"
            });
        });
    </script>
@endsection