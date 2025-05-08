
    <div class="row my-3 mx-1">
        <div class="col-md-12 text-right">
            @can('settings_show')
            <a href="#" data-toggle="modal" data-target="#addAssessment" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"></i> </a>
            @endcan
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Baha ýa-da ady</th>
            @can('settings_show')
            <th scope="col">Operasiýalar</th>
            @endcan
        </tr>
        </thead>
        <tbody>
        @foreach($assessments as $assessment)
            <tr>
                <td>{{$assessment->id}}</td>
                <td>{{$assessment->value}}</td>
                @can('settings_show')
                <td>
                    <a href="#{{--{{route('assessment.delete',['assessment_id'=>$assessment->id])}}--}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </a>
                </td>
                    @endcan
            </tr>
        @endforeach
        </tbody>
    </table>

    <!--modal for assessment add-->
    <div class="modal fade" id="addAssessment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('assessment.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-header text-center ">
                        <h4 class="modal-title"> Täze baha ýa-da bellik</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-2">
                        <label>Baha ýa-da bellik:</label>
                        <div class="input-group">
                            <input type="char" name="value" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer d-flex">
                        <input type="submit" class="btn btn-primary float-right" value="Goş"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--modal for assessment add-->
