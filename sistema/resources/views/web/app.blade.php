<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="title" content="Shop | IncanatoApps.com" />
        <meta name="author" content="IncanatoApps" />
        <meta name="description" content="Shop | IncanatoApps.com"/>
        <meta name="keywords" content="Shop, IncanatoApps"
        />
        <title>@yield('titulo', 'Shop - IncanatoApps')</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
        @stack('estilos')
    </head>
    <body>
        <!-- Navigation-->
        @include('web.partials.nav')
        <!-- Header-->
        @if(View::hasSection('header'))
            @include('web.partials.header')
        @endif
        <!-- Search and Filter Section -->
        @yield('contenido')
        <!-- Footer-->
        @include('web.partials.footer')
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{asset('js/scripts.js')}}"></script>
        @stack('scripts')
    </body>
</html>
