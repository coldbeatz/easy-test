@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@include('header', ['title' => 'Settings'])

<div class="container" style="text-align: center">
    <p>{{ config('app.name') }} - 2022</p>
</div>

@include('footer')

