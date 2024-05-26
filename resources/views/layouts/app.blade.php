<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME')}} | {{ $title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body class="min-h-screen flex flex-col font-sans" x-data="{ open: true }">
    @include('layouts.partials.navbar')

    <div class="flex flex-1 w-full">
        @include('layouts.partials.sidebar')

        <div class="flex-1 px-10 py-5 bg-sky-50">
            @include('components.flash')
            <div class="flex items-center justify-between mt-5">
                <h1 class="text-[#3d3d5c] font-semibold text-xl">{{ $title }}</h1>
                @yield('tambah')
            </div>
            <div class="bg-white p-5 mt-5">
                @yield('content')
            </div>
            @yield('second-content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    @vite('resources/js/app.js')
    @yield('script')
</body>
</html>
