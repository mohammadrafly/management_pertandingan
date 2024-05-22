<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME')}} | {{ $title }}</title>
    @vite('resources/css/app.css')
</head>
<body class="flex justify-center items-center bg-sky-200 min-h-screen">
    @yield('content')

    @vite('resources/js/app.js')
</body>
</html>