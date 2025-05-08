@extends('layouts.admin')
@section('title', 'Kafedralar')
@section('content')

    <div class="col-lg-12">
        <h1 class="page-header"> Täze kafedra goşmak</h1>
        <hr class="hr-header">
    </div>



<div class="row">
    <div class="col-xs-10 col-sm-7 col-md-4 offset-md-4">
        <form role="form" action="{{route('kathedra.store')}}" method="POST">
            {{ csrf_field() }}
            {{--<hr class="colorgraph">--}}
            <div class="form-group">
                <input type="text" name="name" id="name" class="form-control input-lg" placeholder="Ady" tabindex="1">
            </div>
            <br>
            <div class="form-group ">
                <label for="id_label_single">
                    Fakulteti:&nbsp;&nbsp;
                    <select  class="js-example-theme-single form-control" name="faculty_id">
                    @foreach($faculties as $faculty)
                        <option value="{{$faculty->id}}">{{$faculty->name}}</option>
                    @endforeach
                </select>
                </label>
            </div>



            <hr class="colorgraph">
            <input type="submit"  class="btn btn-success float-lg-right" value="Goş"/>
        </form>
    </div>
</div>
    <script>
        $(document).ready(function() {
            $(".js-example-theme-single").select2({
                theme: "classic",
                "language": {
                    "noResults": function(){
                        return "Gözlege görä hiç zat tapylmady";
                    }
                }
            });
        });
    </script>
    <script src="{{ asset('js/jquery.min.js')}}"> </script>

@endsection