<!-- Barra de navegação superior -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand -->
    <a class="navbar-brand ps-3" href="{{ asset('/') }}">INFOSI RH</a>
    <!-- Sidebar Toggle -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" title="Recolher/Expandir Menu">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Botão de alternar tema (ícone) -->
    <button id="themeToggleNav" class="theme-toggle ms-auto me-3" title="Alternar Tema">
      <i class="fas fa-sun"></i>
    </button>

    <!-- Menu do usuário (logout e outros) -->
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
          <li>
            <!-- Link para Logout sendo referenciado pelo Auth do Laravel-Sactum -->
            <a class="dropdown-item" href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               Sair
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </nav>