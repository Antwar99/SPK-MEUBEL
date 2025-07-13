<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="SPK Pemilihan Bahan Baku Kayu Terbaik" />
    <meta name="author" content="Syaiful Anwar" />
    <link rel="icon" href="{{ asset('Woods_DSS_Logo.png') }}" type="image/png"/>
    <title>SPK | {{ $title }}</title>

    {{-- style --}}
    @include('includes.admin.style')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="sb-nav-fixed">

    {{-- navbar --}}
    @include('includes.admin.navbar')


    <div id="layoutSidenav">

        {{-- sidenav --}}
        @include('includes.admin.sidenav')

        {{-- content --}}
        <div id="layoutSidenav_content">
            {{-- content --}}
            @yield('content')

            {{-- footer --}}
            @include('includes.admin.footer')
        </div>
    </div>

    @include('includes.admin.script')

</body>

</html>
