<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @routes
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    <script src="{{ asset(mix('js/manifest.js')) }}" defer></script>
    <script src="{{ asset(mix('js/vendor.js')) }}" defer></script>
    <script src="{{ asset(mix('js/app.js')) }}" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="76x76" href="{{('Ardor/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('Ardor/img/favicon.png')}}">    
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{asset('Ardon/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('Ardon/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{asset('Ardon/css/nucleo-svg.css')}}" rel="stylesheet" />        
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('Ardon/css/argon-dashboard.css?v=2.0.2')}}" rel="stylesheet" />
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>