<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SENA | Formación que transforma</title>

    @include('includes.dependencias')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="{{ request()->routeIs('home') ? 'home-body' : 'app-body' }}">

    <!-- Navbar -->
    @include('includes.navbar')

    @yield('content')

    <!-- vista de traer los registros-->



    @include('includes.footer')

    @include('includes.dependenciasBody')
    @stack('scripts')


</body>

</html>
