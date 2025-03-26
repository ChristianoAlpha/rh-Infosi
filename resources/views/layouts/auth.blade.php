<!DOCTYPE html>
<html lang="pt-pt" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('auth/img/infosi2.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('auth/css/bootstrap.min.css') }}">
    
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('auth/css/fontawesome-all.min.css') }}">
    
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{ asset('auth/font/flaticon.css') }}">
    
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('auth/style.css') }}">


<style>
  
</style>
</head>
<body>
    @yield('content')

    <!-- jQuery -->
    <script src="{{ asset('auth/js/jquery-3.5.0.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('auth/js/bootstrap.min.js') }}"></script>

    <!-- Imagesloaded JS -->
    <script src="{{ asset('auth/js/imagesloaded.pkgd.min.js') }}"></script>

    <!-- Validator JS -->
    <script src="{{ asset('auth/js/validator.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('auth/js/main.js') }}"></script>

</body>
</html>
