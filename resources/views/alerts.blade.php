@if (Session::has('success'))
    <div class="materialert success">
        <div class="material-icons">done</div>
        {!! Session::get('success') !!}
    </div>
@endif

@if ($errors->any())
    <div class="materialert error">
        <div class="material-icons">error_outline</div>
        {{ $errors->first() }}
    </div>
@endif
