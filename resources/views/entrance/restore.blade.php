<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link rel="stylesheet" href="{{ URL::asset("css/entrance.css") }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Easy Test | Recovery</title>
</head>
<body>

<div class="auth-container">
    <form class="auth_form" method="POST">
        @csrf
        <div class="auth_reference">
            <a href="{{ route("login") }}" class="btn waves-effect waves-light button-auth" type="button">LOGIN
                <i class="material-icons right" style="font-size: 25px;">group</i>
            </a>
        </div>
        <div class="input-field">
            <i class="material-icons prefix">email</i>
            <input id="email" type="email" class="validate" name="email">
            <label for="email">E-mail</label>
        </div>

        @if ($errors->any())
            <div class="materialert error">
                <div class="material-icons">error_outline</div>
                {{ $errors->first() }}
            </div>
        @endif
        @if (Session::has('success'))
            <div class="materialert warning">
                <div class="material-icons">warning</div>
                {!! Session::get('success') !!}
            </div>
        @endif

        <div class="captcha-container">
            <div style="display: flex; align-items: center">
                <img src="{{ Captcha::src() }}" id="captcha">
                <a id="refreshCaptcha">
                    <i class="material-icons right" style="font-size: 40px;">rotate_right</i>
                </a>
            </div>

            <div class="input-field">
                <i class="material-icons prefix">edit</i>
                <input id="captchaCode" type="text" name="captcha">
                <label for="captchaCode">Captcha code</label>
            </div>
        </div>

        <div class="auth_bottom">
            <button class="btn waves-effect waves-light button-auth" type="submit">SEND MAIL
                <i class="material-icons right" style="font-size: 25px;">email</i>
            </button>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let refreshCaptcha = document.getElementById('refreshCaptcha');
        let captcha = document.getElementById('captcha');

        refreshCaptcha.addEventListener('click', () => {
            fetch('{{ route('refreshCaptcha') }}')
                .then(
                    function(response) {
                        if (response.status === 200) {
                            response.json().then(function(data) {
                                captcha.src = data.captcha;
                            });
                        }
                    }
                ).catch(function(err) {
                console.log('Fetch Error:', err);
            });
        });
    });

</script>
</body>
</html>
