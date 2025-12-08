<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ config('app.name', 'Laravel') }} | @yield('titre')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('Pro/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('Pro/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('Pro/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Vendors CSS (si nécessaire pour les formulaires) -->
    <link rel="stylesheet" href="{{ asset('Pro/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Custom CSS -->
   
    @yield('header')
</head>
<body>
    <div class="container mt-5 mb-5">
        <!-- Carte rectangulaire avec image d'arrière-plan -->
        <div class="header-card"></div>
        
        @yield('content')
    </div>

    <!-- Core JS -->
    <script src="{{ asset('Pro/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('Pro/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('Pro/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @if (session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
    @endif
    @if (session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
    @endif
    @yield('scripts')
</body>
</html>