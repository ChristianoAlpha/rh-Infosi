\<!DOCTYPE html>
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
          <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user fa-fw"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#!">Settings</a></li>
            <li><a class="dropdown-item" href="#!">Activity Log</a></li>
            <li><hr class="dropdown-divider" /></li>
            <li>
              <!-- Link que chama um form hidden -->
              <a class="dropdown-item" href="#"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                 Sair
              </a>
              <!-- Formulário hidden para enviar via POST -->
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </nav>

    <!-- Layout principal com menu lateral e conteúdo -->
    <div id="layoutSidenav">
      @if(Auth::check())
        @php
          $userRole = Auth::user()->role ?? 'employee'; 
          // Caso não tenha role definido, considere "employee" como default
        @endphp

        <div id="layoutSidenav_nav">
          <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
              <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ route('dashboard') }}">
                  <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Menus</div>

                {{-- EXEMPLO: Somente ADMIN e DIRECTOR enxergam Departamentos, Cargos etc. --}}
                @if(in_array($userRole, ['admin','director']))
                  <!-- Departamentos -->
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                     aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Departamentos
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="collapseLayouts" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                      <a class="nav-link" href="{{ url('depart') }}">Ver Todos</a>
                      <a class="nav-link" href="{{ url('depart/create') }}">Adicionar Novo</a>
                    </nav>
                  </div>

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

                  <!-- Usuários -->
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#usersMenu"
                     aria-expanded="false" aria-controls="usersMenu">
                    <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                    Usuários
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="usersMenu" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                      <a class="nav-link" href="{{ url('admins') }}">Ver Todos</a>
                      <a class="nav-link" href="{{ url('admins/create') }}">Adicionar Novo</a>
                    </nav>
                  </div>
                @endif

                {{-- Tipos de Licença, Pedidos de Licença: Admin e Director (e se quiser, department_head) --}}
                @if(in_array($userRole, ['admin','director','department_head']))
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
                @endif

                {{-- Se for Intern, por exemplo, não mostra nada além do que se definir. --}}

                <!-- Pedido de Férias (todos podem ver, ou restrinja se quiser) -->
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

                {{-- Funcionários: só admin e director podem ver todos; se for employee normal, não vê esse menu --}}
                @if(in_array($userRole, ['admin','director']))
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
                @endif

                {{-- Estagiários: admin e director também, ou se preferir outro role --}}
                @if(in_array($userRole, ['admin','director']))
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
                @endif

                {{-- Mobilidade e Destacamento: admin, director e (se quiser) department_head --}}
                @if(in_array($userRole, ['admin','director','department_head']))
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

                  <!-- Destacamento -->
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
                @endif

                <!-- Portal do Chefe de Departamento -->
                @if(in_array($userRole, ['admin','director','department_head']))
                  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#deptHeadMenu"
                     aria-expanded="false" aria-controls="deptHeadMenu">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                    Portal do Chefe Dept.
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                  </a>
                  <div class="collapse" id="deptHeadMenu" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                      <a class="nav-link" href="{{ route('dh.myEmployees') }}">Meus Funcionários</a>
                      <a class="nav-link" href="{{ route('dh.pendingVacations') }}">Férias Pendentes</a>
                    </nav>
                  </div>
                @endif

                <!-- EXEMPLO: Link de “Meu Perfil” para TODOS -->
                <a class="nav-link" href="{{ route('profile') }}">
                  <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                  Meu Perfil
                </a>

              </div>
            </div>
          </nav>
        </div>
      @else
        <!-- Se não estiver logado, mostre algo ou apenas “Área de Login” -->
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh; width: 100%;">
          <h4>Você não está logado.</h4>
        </div>
      @endif

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

    <!-- Scripts do Bootstrap e demais bibliotecas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
  </body>
</html>
