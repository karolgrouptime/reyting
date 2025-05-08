
<div class="row my-3 mx-1">
    <div class="col-md-12 text-right">
        {{--<a href="#" data-toggle="modal" data-target="#addPermission" class="btn bg-navbar btn-dark float-right m-1"><i class="fa fa-plus-circle"></i> </a>--}}
    </div>
</div>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Baha ýa-da ady</th>
        <th scope="col">Operasiýalar</th>
    </tr>
    </thead>
    <tbody>
    @foreach($permissions as $permission)
        <tr>
            <td>{{$permission->id}}</td>
            <td>{{$permission->name}}</td>
            <td>
                <a href="#editPermission" data-toggle="modal"  data-id="{{$permission->id}}" data-name="{{$permission->name}}" data-target="#editPermission" id="edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    $(document).on("click", "#edit", function () {
        var name = $(this).data('name');
        var id = $(this).data('id');
        $(".modal-body #name").val(name);
        $('#editPermission').modal('show');
        var url = '{{ route("permission.update", ":perm_id") }}';
        url = url.replace(':perm_id', id);
        $("#forma").attr("action", url);
    });

</script>
<!--modal for permission add-->
<div class="modal fade" id="addPermission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('permission.store')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header text-center ">
                    <h4 class="modal-title"> Täze rugsat</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-2">
                    <label>Ady:</label>
                    <div class="input-group">
                        <input type="char" name="name" class="form-control">
                    </div>
                </div>
                <div class="modal-footer d-flex">
                    <input type="submit" class="btn btn-primary float-right" value="Goş"/>
                </div>
            </form>
        </div>
    </div>
</div>
<!--modal for permission add-->

<!-- edit modal for permission-->
<div class="modal fade" id="editPermission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="forma" action="" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header text-center ">
                    <h4 class="modal-title"> Rugsady üýtgetmek</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-2">
                    <label>Ady:</label>
                    <div class="input-group">
                        <input type="char" name="name" id="name" class="form-control">
                    </div>
                </div>
                <div class="modal-footer d-flex">
                    <input type="submit" class="btn btn-primary float-right" value="Goş"/>
                </div>
            </form>
        </div>
    </div>
</div>
<!--edit modal for permission-->

