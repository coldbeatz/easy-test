<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link rel="stylesheet" href="{{ URL::asset("css/verification.css") }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Easy Test | Activation</title>
</head>
<body>

<div class="verification-container">
    <div class="materialert info">
        <div class="material-icons">info_outline</div>
        <span>Email <b>{{ $email }}</b> has already been confirmed!</span>
    </div>
    <a href="#" class="btn waves-effect waves-light button-auth" type="submit">Main page
        <i class="material-icons right" style="font-size: 25px;">reply</i>
    </a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
