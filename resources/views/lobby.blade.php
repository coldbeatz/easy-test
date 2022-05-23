@push("styles")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
@endpush
@include('header', ['title' => 'Settings'])

<div class="container" style="text-align: center; margin: auto;">
    <p>Android version:</p>

    <a class="btn waves-effect waves-light" href="https://exp-shell-app-assets.s3.us-west-1.amazonaws.com/android/%40milka_vlad/easy-test-mobile-d9b1ba742f1e49aface47206b3a3a451-signed.apk">
        download .apk
        <i class="material-icons right" style="font-size: 25px;">file_download</i>
    </a>

    <p>{{ config('app.name') }} - 2022</p>
</div>

@include('footer')

