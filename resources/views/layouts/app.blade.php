<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    </head>
    <body>

        @include('partials.sidebar')

        <div class="content-wrapper">

            @include('partials.header')

            <div class="main-content">
                @yield('content')
            </div>

        </div>
        @include('layouts.notificacion-emergente')
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/showtoast.js') }}"></script>
    @stack('scripts')
</html>
