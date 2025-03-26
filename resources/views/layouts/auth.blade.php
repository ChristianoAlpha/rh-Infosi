<!DOCTYPE html>
<html lang="pt-pt" data-bs-theme="light">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title')</title>

  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('auth/img/infosi2.png') }}">
  <link rel="stylesheet" href="{{ asset('auth/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('auth/css/fontawesome-all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('auth/font/flaticon.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('auth/style.css') }}">

  <style>
    /* Define fundo branco fixo sem efeitos de piscar */
    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background-color: #ffffff;
      position: relative;
    }
    body::before {
      content: none;
    }
  </style>
</head>
<body>
  @yield('content')


  <script src="{{ asset('auth/js/jquery-3.5.0.min.js') }}"></script>
  <script src="{{ asset('auth/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('auth/js/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('auth/js/validator.min.js') }}"></script>
  <script src="{{ asset('auth/js/main.js') }}"></script>
</body>
</html>
