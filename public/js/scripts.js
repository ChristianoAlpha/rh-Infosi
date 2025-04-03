/*!
 * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
 * Copyright 2013-2023 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
 */

document.addEventListener('DOMContentLoaded', function() {

  // Toggle da sidebar
  const sidebarToggle = document.getElementById('sidebarToggle');
  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', event => {
      event.preventDefault();
      document.body.classList.toggle('sb-sidenav-toggled');
      localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
    });
  }

  // 2) Inicializar DataTables (id="datatablesSimple")
  const datatablesSimple = document.getElementById('datatablesSimple');
  if (datatablesSimple) {
    new simpleDatatables.DataTable(datatablesSimple, {
      labels: {
        placeholder: "Pesquisar...",
        perPage: "Número de páginas",
        noRows: "Nenhum registro encontrado",
        info: "Exibindo {start} a {end} de {rows} registros (Página {page} de {pages})"
      }
    });
  }

  // 3) Preencher SELECT de nacionalidade via API
  const nationalitySelect = document.getElementById('nationality');
  if (nationalitySelect) {
    fetch('/api/countries')
      .then(response => response.json())
      .then(data => {
        console.log('[DEBUG] /api/countries retornou:', data);
        data.forEach(country => {
          const option = document.createElement('option');
          option.value = `${country.name} (${country.code})`;
          option.textContent = `${country.name} (${country.code})`;
          nationalitySelect.appendChild(option);
        });
      })
      .catch(error => console.error('Erro ao buscar países:', error));
  } else {
    console.warn('Elemento #nationality não encontrado.');
  }

  // 4) Preencher dropdown de códigos de telefone via API
  const phoneCodeMenu = document.getElementById('phone_code_menu');
  const selectedCodeButton = document.getElementById('selected_code');
  // Observação: o id do input oculto é "phoneCode"
  const hiddenPhoneCode = document.getElementById('phoneCode');
  if (phoneCodeMenu && selectedCodeButton && hiddenPhoneCode) {
    fetch('/api/countries')
      .then(response => response.json())
      .then(data => {
        console.log('[DEBUG] /api/countries (códigos) retornou:', data);
        data.forEach(country => {
          if (country.phone) {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.classList.add('dropdown-item');
            a.textContent = `${country.name} (${country.phone})`;
            a.addEventListener('click', function(e) {
              e.preventDefault();
              selectedCodeButton.textContent = country.phone;
              hiddenPhoneCode.value = country.phone;
            });
            li.appendChild(a);
            phoneCodeMenu.appendChild(li);
          }
        });
      })
      .catch(error => console.error('Erro ao buscar códigos de telefone:', error));
  } else {
    console.warn('Elementos do dropdown de telefone não encontrados.');
  }

  // 5) Botão de confirmação de deleção
  document.addEventListener('click', function(e) {
    const btn = e.target.closest('.delete-btn');
    if (btn) {
      e.preventDefault();
      const url = btn.getAttribute('data-url');
      const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
      if (confirmDeleteBtn) {
        confirmDeleteBtn.setAttribute('href', url);
      }
      const deleteModalEl = document.getElementById('deleteModal');
      if (deleteModalEl) {
        const modal = new bootstrap.Modal(deleteModalEl);
        modal.show();
      }
    }
  });

  // Botão de alternar tema (claro/escuro)
  function toggleTheme() {
    const htmlElement = document.documentElement;
    const currentTheme = htmlElement.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    htmlElement.setAttribute('data-bs-theme', newTheme);
    localStorage.setItem('theme', newTheme);

    // Atualiza os ícones de tema
    const allThemeIcons = document.querySelectorAll('#themeToggleNav i, #themeToggleFloat i');
    allThemeIcons.forEach(icon => {
      icon.className = newTheme === 'dark' ? 'fas fa-moon' : 'fas fa-sun';
    });
  }

  // Eventos para os botões de tema
  const themeToggleNav = document.getElementById('themeToggleNav');
  const themeToggleFloat = document.getElementById('themeToggleFloat');
  if (themeToggleNav) {
    themeToggleNav.addEventListener('click', toggleTheme);
  }
  if (themeToggleFloat) {
    themeToggleFloat.addEventListener('click', toggleTheme);
  }

  // Aplicar tema salvo
  const savedTheme = localStorage.getItem('theme') || 'light';
  document.documentElement.setAttribute('data-bs-theme', savedTheme);
  const allThemeIcons = document.querySelectorAll('#themeToggleNav i, #themeToggleFloat i');
  allThemeIcons.forEach(icon => {
    icon.className = savedTheme === 'dark' ? 'fas fa-moon' : 'fas fa-sun';
  });

});
