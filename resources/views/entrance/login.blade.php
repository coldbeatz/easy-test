<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link rel="stylesheet" href="{{ URL::asset("css/entrance.css") }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Easy Test | Login</title>
</head>
<body>

<div class="auth-container">

    <form class="auth_form" method="POST" action="{{ route("auth") }}">
        @csrf
        <div class="auth_reference">
            <a href="{{ route("registration") }}" class="btn waves-effect waves-light button-auth" type="button">REGISTRATION
                <i class="material-icons right" style="font-size: 25px;">account_circle</i>
            </a>
        </div>

        <div class="input-field">
            <i class="material-icons prefix">email</i>
            <input id="email" type="email" class="validate" name="email" value="{{ Session::get('email') }}">
            <label for="email">E-mail</label>
        </div>

        <div class="input-field">
            <i class="material-icons prefix">no_encryption</i>
            <input id="password" type="password" class="validate" name="password" value="{{ Session::get('password') }}">
            <label for="password">Password</label>
        </div>

        @if ($errors->any())
            <div class="materialert error">
                <div class="material-icons">error_outline</div>
                {{ $errors->first() }}
            </div>
        @endif

        <p style="margin-left: 45px;">
            <label>
                <input type="checkbox" class="filled-in" checked="checked" name="remember"/>
                <span>Remember</span>
            </label>
        </p>

        <div class="auth_bottom">
            <button class="btn waves-effect waves-light button-auth" type="submit">LOGIN
                <i class="material-icons right" style="font-size: 25px;">group</i>
            </button>
            <a href="{{ route('restore') }}" class="auth_reference">Restore password</a>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
