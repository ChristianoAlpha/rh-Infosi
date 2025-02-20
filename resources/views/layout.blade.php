<!DOCTYPE html>
<html lang="pt-pt">
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

    <!-- Seu CSS principal -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">

    <!-- Barra de navegação superior -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ asset('/') }}">INFOSI RH</a>

        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Menus à direita (usuário, logout, etc.) -->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" 
                   role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="{{ url('admin/login') }}">Sair</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Layout principal com o menu lateral e conteúdo -->
    <div id="layoutSidenav">
        <!-- Menu Lateral -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="{{ asset('/') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Todos os campos</div>

                        <!-- Departamentos -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" 
                           aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Departamentos
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('depart') }}">Ver Todos</a>
                                <a class="nav-link" href="{{ url('depart/create') }}">Adicionar Novo</a>
                            </nav>
                        </div>
                        <!-- Fim Departamentos -->

                        <!-- Cargos (Positions) -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#positionsMenu">
                            <div class="sb-nav-link-icon"><i class="fas fa-briefcase"></i></div>
                            Cargos
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="positionsMenu" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('positions') }}">Ver Todos</a>
                                <a class="nav-link" href="{{ url('positions/create') }}">Adicionar Novo</a>
                            </nav>
                        </div>
                        <!-- Fim Cargos -->

                        <!-- Especialidades -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#specialtiesMenu">
                            <div class="sb-nav-link-icon"><i class="fas fa-star"></i></div>
                            Especialidades
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="specialtiesMenu" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ asset('specialties') }}">Ver Todos</a>
                                <a class="nav-link" href="{{ asset('specialties/create') }}">Adicionar Novo</a>
                            </nav>
                        </div>
                        <!-- Fim Especialidades -->

                        <!-- Funcionários (Employeee) -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#empMenu" 
                           aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Funcionarios
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="empMenu" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ asset('employeee') }}">Ver Todos</a>
                                <a class="nav-link" href="{{ asset('employeee/create') }}">Adicionar Novo</a>
                            </nav>
                        </div>
                        <!-- Fim Funcionarios -->

                        <!-- Outros itens de menu (ex: Tabelas, Charts) -->
                        <!-- ... -->

                    </div>
                </div>
            </nav>
        </div>

        <!-- Conteúdo Principal -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <!-- Aqui será injetado o conteúdo de cada view -->
                    @yield('content')
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">
                            Copyright &copy;
                            Your Website 2023
                        </div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- ==================== MODAL DE SUCESSO ==================== -->
    @if(session('msg'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <!-- Cabeçalho do Modal com fundo verde (bg-success) -->
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="successModalLabel">
              <i class="bi bi-check-circle-fill me-2"></i>Sucesso
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <!-- Corpo do Modal exibindo a mensagem -->
          <div class="modal-body">
            {{ session('msg') }}
          </div>
        </div>
      </div>
    </div>
    <!-- Script para abrir o modal de sucesso automaticamente -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var successModalEl = document.getElementById('successModal');
        var successModal = new bootstrap.Modal(successModalEl);
        successModal.show();
      });
    </script>
    @endif
    <!-- Fim Modal de Sucesso -->

    <!-- ==================== MODAL DE ERRO DE VALIDAÇÃO ==================== -->
    @if($errors->any())
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <!-- Cabeçalho do Modal com fundo vermelho (bg-danger) -->
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="errorModalLabel">
              <i class="bi bi-exclamation-triangle-fill me-2"></i>Erro(s) de Validação
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <!-- Corpo do Modal listando todos os erros -->
          <div class="modal-body">
            @foreach($errors->all() as $error)
              <p class="mb-0">{{ $error }}</p>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <!-- Script para abrir o modal de erro automaticamente -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var errorModalEl = document.getElementById('errorModal');
        var errorModal = new bootstrap.Modal(errorModalEl);
        errorModal.show();
      });
    </script>
    @endif
    <!-- Fim Modal de Erro -->

    <!-- ==================== MODAL DE CONFIRMAÇÃO DE DELEÇÃO ==================== -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="deleteModalLabel">
              <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Exclusão
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            Tem certeza que deseja deletar este registro?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Deletar</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Script de delegação de eventos para deleção -->
    <script>
      document.addEventListener('click', function(e) {
        const btn = e.target.closest('.delete-btn');
        if (btn) {
          e.preventDefault();
          const url = btn.getAttribute('data-url');
          document.getElementById('confirmDeleteBtn').setAttribute('href', url);
          const deleteModalEl = document.getElementById('deleteModal');
          const modal = new bootstrap.Modal(deleteModalEl);
          modal.show();
        }
      });
    </script>
    <!-- Fim Modal de Deleção -->

    <!-- Scripts do Bootstrap e terceiros -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
</body>
</html>
