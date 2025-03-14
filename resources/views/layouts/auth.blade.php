<!DOCTYPE html>
<html lang="pt-pt" data-bs-theme="light">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <style>
      body {
        background-color: #f8f9fa;
      }
      .login-card {
        margin-top: 100px;
      }
    </style>
  </head>
  <body>
    @yield('content')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
