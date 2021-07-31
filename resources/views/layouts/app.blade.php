<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lucky Winners | Admin @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/materialdesignicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-grid.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-reboot.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">

    {{-- jquery --}}
    <script src="{{asset('js/jquery.js')}}"></script>
</head>
<body>
    <div class="pre-loader"><div></div><div></div></div>
    @if(Session::has('success'))
    <div class="notification success">
        <p><i class="mdi mdi-check-circle mr-2"></i>Success</p>
        <span>{{ Session::get('success') }}</span>
    </div>
    @endif
    @if(Session::has('error'))
    <div class="notification error">
        <p><i class="mdi mdi-alert-octagon mr-2"></i>Error</p>
        <span>{{ Session::get('error') }}</span>
    </div>
    @endif
    <div id="app">
        
        @include('layouts.navbar')

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    {{-- js --}}
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
</body>
</html>
