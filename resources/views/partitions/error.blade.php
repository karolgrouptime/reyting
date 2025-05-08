
@isset($error)
    <div class="row" id="error">
        <div class="col-md-6 m-3">
            <div class="alert alert-danger ">
                <strong>Ýalňyşlyk!</strong> {{$success}}.
            </div>
        </div>
    </div>
@endisset

@if (session('error'))
    <div class="row" id="error">
        <div class="col-md-6 m-3">
            <div class="alert alert-danger ">
                <strong>Ýalňyşlyk!</strong> {{ session('error') }}.
            </div>
        </div>
    </div>
@endif

<script>
    $('#error').show();
    setTimeout(function(){ $('#error').hide(4000);},5000);
</script>