<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('Login')) - Admin</title>

    <link rel="shortcut icon" href="{{ asset('assets/admin/images/auth-images/favicon.ico') }}">
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/admin/dist/css/auth/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('assets/admin/dist/css/auth/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('assets/admin/dist/css/auth/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
    @stack('styles')
</head>
<body>
    @yield('content')

    <script src="{{ asset('assets/admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/admin/dist/js/auth/app.js') }}"></script>
    @stack('scripts')
</body>
</html>