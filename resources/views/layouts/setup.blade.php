<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Come') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="setup">
<div id="app">

    <main class="main container mt-5">
        @yield('content')
    </main>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')

</div>
</body>
</html>
