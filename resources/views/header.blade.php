<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link rel="stylesheet" href="{{ URL::asset("css/left-nav-style.css") }}">
    <link rel="stylesheet" href="{{ URL::asset("css/shared.css") }}">

    @stack('styles')

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | {{ $title }}</title>
</head>
<body>

<nav>
    <div class="nav-wrapper">
        <a href="/" class="brand-logo center">{{ config('app.name') }}</a>

        <div data-target="slide-out" class="sidenav-trigger menu-toggle">
            <i class="material-icons">menu</i>
        </div>

        <ul class="right hide-on-med-and-down">
            <li><a href="{{ route('testings') }}">Testings</a></li>
            <li><a href="{{ route('settings') }}">Settings</a></li>
            <li><a href="{{ route('logout') }}">Logout</a></li>
        </ul>
    </div>
</nav>

<ul id="slide-out" class="sidenav">
    <li>
        <div class="user-view">
            <a href="/">
                <img class="circle" src="{{ URL::asset('storage/' . Auth::user()->avatar) }}">
            </a>
            <a>{{ Auth::user()->name }}</a>
            <a>{{ Auth::user()->email }}</a>
        </div>
    </li>
    <li>
        <a href="/"><i class="material-icons">home</i>Main</a>
    </li>
    <!--<li>
        <a class="subheader"><i class="material-icons">computer</i>Classes</a>
    </li>-->
    <li>
        <a href="{{ route('testings') }}"><i class="material-icons">check</i>Testings</a>
    </li>
    <li>
        <a class="subheader"><i class="material-icons">folder_shared</i>Results</a>
    </li>
    <li>
        <div class="divider"></div>
    </li>
    <li>
        <a href="{{ route('settings') }}"><i class="material-icons">settings</i>Settings</a>
    </li>
    <li>
        <a href="{{ route('logout') }}"><i class="material-icons">close</i>Logout</a>
    </li>
</ul>
