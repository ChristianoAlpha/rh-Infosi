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

    <!-- Seu CSS principal -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
      /* Botão de alternar tema (só ícone) */
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
  <body class="sb-nav-fixed">
    <!-- Barra de navegação superior -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
      <!-- Navbar Brand -->
      <a class="navbar-brand ps-3" href="{{ asset('/') }}">INFOSI RH</a>
      <!-- Sidebar Toggle -->
      <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" title="Recolher/Expandir Menu">
        <i class="fas fa-bars"></i>
      </button>
      <!-- Botão de alternar tema (apenas ícone) na navbar -->
      <button id="themeToggleNav" class="theme-toggle ms-auto me-3" title="Alternar Tema">
        <i class="fas fa-sun"></i>
      </button>
      <!-- Menus à direita -->
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

    <!-- Layout principal com menu lateral e conteúdo -->
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
               <!-- Fim Departamento -->

              <!-- Cargos -->
              <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#positionsMenu"
                 aria-expanded="false" aria-controls="positionsMenu">
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
              <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#specialtiesMenu"
                 aria-expanded="false" aria-controls="specialtiesMenu">
                <div class="sb-nav-link-icon"><i class="fas fa-star"></i></div>
                Especialidades
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="specialtiesMenu" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-link" href="{{ url('specialties') }}">Ver Todos</a>
                  <a class="nav-link" href="{{ url('specialties/create') }}">Adicionar Novo</a>
                </nav>
              </div>
              <!-- Fim Especialidade -->
              
              <!-- Tipos de Licença -->
              <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#leaveTypeMenu"
                 aria-expanded="false" aria-controls="leaveTypeMenu">
                <div class="sb-nav-link-icon"><i class="fas fa-file-contract"></i></div>
                Tipos de Licença
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="leaveTypeMenu" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-link" href="{{ url('leaveType') }}">Ver Todos</a>
                  <a class="nav-link" href="{{ url('leaveType/create') }}">Adicionar Novo</a>
                </nav>
              </div>
               <!-- Fim Tipo de Licença -->
              
              <!-- Pedidos de Licença -->
              <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#leaveRequestMenu"
                 aria-expanded="false" aria-controls="leaveRequestMenu">
                <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                Pedidos de Licença
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="leaveRequestMenu" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-link" href="{{ url('leaveRequest') }}">Ver Todos</a>
                  <a class="nav-link" href="{{ url('leaveRequest/create') }}">Adicionar Novo</a>
                </nav>
              </div>
               <!-- Fim Pedido de Licença -->

              

              <!-- Tipos de Funcionários -->
              <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#employeeTypeMenu"
                 aria-expanded="false" aria-controls="employeeTypeMenu">
                <div class="sb-nav-link-icon"><i class="fas fa-id-badge"></i></div>
                Tipos de Funcionários
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="employeeTypeMenu" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-link" href="{{ url('employeeType') }}">Ver Todos</a>
                  <a class="nav-link" href="{{ url('employeeType/create') }}">Adicionar Novo</a>
                </nav>
              </div>
               <!-- Fim Funcionários -->

              <!-- Mobilidade -->
              <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#mobilityMenu"
                 aria-expanded="false" aria-controls="mobilityMenu">
                <div class="sb-nav-link-icon"><i class="fas fa-exchange-alt"></i></div>
                Mobilidade
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="mobilityMenu" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-link" href="{{ url('mobility') }}">Ver Todos</a>
                  <a class="nav-link" href="{{ url('mobility/create') }}">Buscar ID</a>
                </nav>
              </div>
               <!-- Fim Mobilidade -->
              
              <!-- Área de Destacamento de Funcionários -->
              <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#secondmentMenu"
              aria-expanded="false" aria-controls="secondmentMenu">
              <div class="sb-nav-link-icon"><i class="fa-solid fa-users-rays"></i></div>
              Destacamento
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="secondmentMenu" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
              <a class="nav-link" href="{{ url('secondment') }}">Ver Todos</a>
              <a class="nav-link" href="{{ url('secondment/create') }}">Adicionar Novo</a>
              </nav>
              </div>
              <!-- Fim Destacamento -->



               <!-- Pedido de Férias (Vacation Request) -->
              <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#vacationRequestMenu"
              aria-expanded="false" aria-controls="vacationRequestMenu">
              <div class="sb-nav-link-icon"><i class="fas fa-umbrella-beach"></i></div>
              Pedido de Férias
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="vacationRequestMenu" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
              <a class="nav-link" href="{{ url('vacationRequest') }}">Ver Todos</a>
              <a class="nav-link" href="{{ url('vacationRequest/create') }}">Adicionar Novo</a>
              </nav>
              </div>
              <!-- Fim Pedido de Férias -->



              <!-- Funcionários -->
              <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#empMenu"
                 aria-expanded="false" aria-controls="empMenu">
                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                Funcionários
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="empMenu" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-link" href="{{ url('employeee') }}">Ver Todos</a>
                  <a class="nav-link" href="{{ url('employeee/create') }}">Adicionar Novo</a>
                </nav>
              </div>
               <!-- Fim Funcionários -->

              <!-- Estagiários -->
              <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#internMenu"
                 aria-expanded="false" aria-controls="internMenu">
                <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
                Estagiários
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="internMenu" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-link" href="{{ url('intern') }}">Ver Todos</a>
                  <a class="nav-link" href="{{ url('intern/create') }}">Adicionar Novo</a>
                </nav>
              </div>
               <!-- Fim Estagiários -->

            </div>
          </div>
        </nav>
      </div>

      <!-- Conteúdo Principal -->

      <div id="layoutSidenav_content">

        <main>
          <div class="container-fluid px-4">
            @yield('content')
          </div>
        </main>

        <footer class="py-4 bg-light mt-auto">
          <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
              <div class="text-muted">
                Copyright &copy; INFOSI-RH Website 2025
              </div>
              <div>
                <a href="#">política de Privacidade</a>
                &middot;
                <a href="#">Termos &amp; Condições</a>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>

    <!-- Modal de Sucesso -->

    @if(session('msg'))
      <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-success text-white">
              <h5 class="modal-title" id="successModalLabel">
                <i class="bi bi-check-circle-fill me-2"></i>Sucesso
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              {{ session('msg') }}
            </div>
          </div>
        </div>
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          var successModalEl = document.getElementById('successModal');
          var successModal = new bootstrap.Modal(successModalEl);
          successModal.show();
        });
      </script>
    @endif

    <!-- Modal de Erro -->

    @if($errors->any())
      <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-danger text-white">
              <h5 class="modal-title" id="errorModalLabel">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>Erro(s) de Validação
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              @foreach($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          var errorModalEl = document.getElementById('errorModal');
          var errorModal = new bootstrap.Modal(errorModalEl);
          errorModal.show();
        });
      </script>
    @endif

    <!-- Modal de Confirmação de Deleção -->

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

    <!-- Scripts do Bootstrap e as demais bibliotecas -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <!-- Carrega os scripts dos gráficos Carrega o Chart.js -->
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    <!-- Botão flutuante de alternar tema, ainda em desenvolvimento. -->

    <button id="themeToggleFloat" class="btn btn-secondary" style="position: fixed; bottom: 20px; right: 20px; z-index: 2000;" title="Alternar Cor do Dashboard">
      <i class="fas fa-sun"></i>
    </button>
  </body>
</html>
