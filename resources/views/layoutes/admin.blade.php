<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Admin Page' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>

<body class="bg-gray-100 flex min-h-screen ">

    @include('admins.partials.sidebar')

    @yield('main')
</body>

</html>
