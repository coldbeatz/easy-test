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
        <h4 class="center" style="margin-top: 0;">Change password</h4>
        <h6 class="center">Email: <b>{{ $email }}</b></h6>

        <div class="input-field">
            <i class="material-icons prefix">no_encryption</i>
            <input id="password" type="password" name="password">
            <label for="password">New password</label>
        </div>

        <div class="input-field">
            <i class="material-icons prefix">no_encryption</i>
            <input id="passwordConfirm" type="password">
            <label for="passwordConfirm">Password confirm</label>
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

        <div class="auth_bottom">
            <button class="btn waves-effect waves-light button-auth" type="button" id="button">SAVE
                <i class="material-icons right" style="font-size: 25px;">done</i>
            </button>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let password = document.getElementById('password');
        let passwordConfirm = document.getElementById('passwordConfirm');

        password.addEventListener('focusout', validatePasswords);
        passwordConfirm.addEventListener('keyup', validatePasswords);

        function inputInvalid(elem) {
            elem.classList.remove("valid");
            elem.classList.add("invalid");
        }

        function inputValid(elem) {
            elem.classList.remove("invalid");
            elem.classList.add("valid");
        }

        function validatePasswords() {
            if (password.value !== passwordConfirm.value) {
                inputInvalid(passwordConfirm);
                return false;
            }

            inputValid(password);
            inputValid(passwordConfirm);
            return true;
        }

        function toast(text) {
            M.toast({
                html: text,
                classes: 'rounded'
            });
        }

        let button = document.getElementById('button');
        button.addEventListener('click', () => {
            if (validatePasswords()) {
                if (password.value.length === 0) {
                    toast("Password required");
                    inputInvalid(password);
                } else {
                    button.type = 'submit';
                }
            } else {
                toast("Passwords don't match");
            }
        });
    });
</script>
</body>
</html>
