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
      /* Configura o fundo para as páginas de autenticação */
      body {
          margin: 0;
          padding: 0;
          min-height: 100vh;
          background: url('{{ asset("auth/img/infosi2.png") }}') no-repeat center center fixed;
          background-size: 120em;
          position: relative;
      }
      /* Overlay opcional para um leve tom branco para melhorar a legibilidade */
      body::before {
          content: "";
          position: absolute;
          top: 0;
          right: 0;
          bottom: 0;
          left: 0;
          background: rgba(255, 255, 255, 0.5);
          z-index: 0;
      }
      /* Garante que o conteúdo das views fique acima do overlay */
      .auth-container {
          position: relative;
          z-index: 1;
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
