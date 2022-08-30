<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @routes
    <script src="{{ asset(mix('js/app.js')) }}" defer></script>
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    <script src="{{ asset(mix('js/manifest.js')) }}" defer></script>
    <script src="{{ asset(mix('js/main.js')) }}" defer></script>
    <script src="{{ asset(mix('js/vendor.js')) }}" defer></script>

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Favicons -->
    <link href="{{asset('NiceAdmin/img/favicon.png')}}" rel="icon">
    <link href="{{asset('NiceAdmin/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
    <!-- Vendor CSS Files -->
    <!-- CSS only -->
    <link href="{{asset('NiceAdmin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('NiceAdmin/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('NiceAdmin/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('NiceAdmin/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('NiceAdmin/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{asset('NiceAdmin/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('NiceAdmin/vendor/simple-datatables/style.css')}}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{asset('NiceAdmin/css/style.css')}}" rel="stylesheet">

    @inertiaHead
</head>

<body>
@inertia

<script src="{{asset('NiceAdmin/vendor/bootstrap/js/bootstrap.bundle.js')}}"></script>
<script>
    @auth
        window.Auth = {!! auth()->user() !!};
    @else
        window.Auth = null;
    @endauth
</script>
</body>

</html>
