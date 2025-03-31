<!DOCTYPE html>
<html lang="pt-pt" data-bs-theme="light">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>

    <!-- Simple-DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- meu CSS principal -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
      /* Botão de alternar tema */
      .theme-toggle {
        cursor: pointer;
        padding: 5px 10px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        color: #fff;
        background-color: rgba(255, 255, 255, 0.1);
        border: none;
      }
      .theme-toggle:hover {
        background-color: rgba(255, 255, 255, 0.2);
      }

      /* Modo escuro */
      html[data-bs-theme="dark"] body {
        background-color: #212529;
        color: #f8f9fa;
      }
      html[data-bs-theme="dark"] .sb-sidenav {
        background-color: #343a40 !important;
      }
      html[data-bs-theme="dark"] #layoutSidenav_content {
        background-color: #212529;
        color: #f8f9fa;
      }
      html[data-bs-theme="dark"] .card,
      html[data-bs-theme="dark"] .table {
        background-color: #2c2c2c;
        color: #f8f9fa;
      }
      html[data-bs-theme="dark"] a {
        color: #90caf9;
      }
      html[data-bs-theme="dark"] .btn-outline-light {
        color: #ffffff;
        border-color: #ffffff;
      }
      html[data-bs-theme="dark"] .modal-content {
        background-color: #343a40;
        color: #f8f9fa;
      }
      html[data-bs-theme="dark"] .bg-light {
        background-color: #343a40 !important;
        color: #f8f9fa !important;
      }
      html[data-bs-theme="dark"] .text-muted {
        color: #adb5bd !important;
      }
      html[data-bs-theme="dark"] input, 
      html[data-bs-theme="dark"] select, 
      html[data-bs-theme="dark"] textarea {
        background-color: #2c3034;
        color: #f8f9fa;
        border-color: #495057;
      }
      html[data-bs-theme="dark"] .form-control:focus {
        background-color: #2c3034;
        color: #f8f9fa;
      }
      html[data-bs-theme="dark"] .dropdown-menu {
        background-color: #343a40;
        color: #f8f9fa;
      }
      html[data-bs-theme="dark"] .dropdown-item {
        color: #f8f9fa;
      }
      html[data-bs-theme="dark"] .dropdown-item:hover {
        background-color: #495057;
      }
    </style>
  </head>