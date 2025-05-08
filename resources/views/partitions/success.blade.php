@isset($success)
        <div class="row" id="success">
        <div class="col-md-6 m-3">
            <div class="alert alert-success ">
                <strong>Üstünlik!</strong> {{$success}}.
            </div>
        </div>
        </div>
@endisset

@if (session('success'))
    <div class="row" id="success">
        <div class="col-md-6 m-3">
            <div class="alert alert-success ">
                <strong>Üstünlik!</strong> {{ session('success') }}.
            </div>
        </div>
    </div>
@endif

<script>
    $('#success').show();
        setTimeout(function(){ $('#success').hide(4000);},5000);
</script>