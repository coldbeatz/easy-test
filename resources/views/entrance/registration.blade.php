<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link rel="stylesheet" href="{{ URL::asset("css/entrance.css") }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Easy Test | Registration</title>
</head>
<body>

<div class="auth-container">
    <form class="auth_form" method="POST" action="{{ route('register') }}">
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

        <div class="input-field">
            <i class="material-icons prefix">assignment_ind</i>
            <input id="name" type="text" class="validate" name="name">
            <label for="name">Name</label>
        </div>

        <div class="input-field">
            <i class="material-icons prefix">no_encryption</i>
            <input id="password" type="password" name="password">
            <label for="password">Password</label>
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

        <div class="captcha-container">
            <div style="display: flex; align-items: center">
                <img src="{{ Captcha::src() }}" id="captcha">
                <a href="#" id="refreshCaptcha">
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
            <button class="btn waves-effect waves-light button-auth" type="button" id="button">REGISTRATION
                <i class="material-icons right" style="font-size: 25px;">account_circle</i>
            </button>
            <a href="{{ route('restore') }}" class="auth_reference">Restore password</a>
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

        let password = document.getElementById('password');
        let passwordConfirm = document.getElementById('passwordConfirm');
        let email = document.getElementById('email');
        let name = document.getElementById('name');

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
            if (email.value.length === 0) {
                toast("Email required");
                inputInvalid(email);
            }
            if (name.value.length === 0) {
                toast("Name required");
                inputInvalid(name);
            }

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
