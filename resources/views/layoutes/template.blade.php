<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ $title ?? 'home page' }} </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-light antialiased">

    @include('partials.header')
    @yield('main')
    @include('partials.footer')
</body>

</html>
