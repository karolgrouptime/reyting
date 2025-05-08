<table class="table table-bordered table-striped" id="bestStudent" width="100%">
    <thead>
    <tr>
        <th scope="col">F.A.a</th>
        <th scope="col">Kafedra</th>
        <th scope="col">Topar</th>
        <th scope="col">Ortaça baha</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#bestStudent').DataTable({
            "processing":true,
            "pageLength": 10,
            "responsive": true,
            "ajax":{
                "url":"<?= route('bests.Api') ?>",
                "dataType":"json",
                "type":"POST",
                "data":{"_token":"<?= csrf_token() ?>"},
            },
            "columns":[
                {"data":"name" },
                {"data":"kathedra" },
                {"data":"group" },
                {"data":"baha" },
            ],
            order: [[3, 'desc']],
            mark: true,
        });
    });
</script>


