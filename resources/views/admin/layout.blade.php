<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PhotoBook</title>

    <!-- Scripts -->
    <script src="{{ asset('js/admin.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>

<body>
    <div class="app">
        @include('admin.partials.side-menu')

        <div class="main">
            @include('admin.partials.header')

            <main class="py-4">
                @yield('content')
            </main>
        </div>

        @if($errors->has('permission'))
            <div class="alert alert-danger alert-animated" role="alert">
                <strong>{{ $errors->first('permission') }}</strong>
            </div>
        @endif
    </div>

    @yield('extra')
</body>

</html>
