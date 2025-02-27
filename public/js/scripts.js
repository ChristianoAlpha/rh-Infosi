/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

/*!
 * Scripts do SB Admin adaptados
 */
window.addEventListener('DOMContentLoaded', event => {

  // Toggle the side navigation
  const sidebarToggle = document.body.querySelector('#sidebarToggle');
  if (sidebarToggle) {
      sidebarToggle.addEventListener('click', event => {
          event.preventDefault();
          document.body.classList.toggle('sb-sidenav-toggled');
      });
  }
});

// Exemplo de buscar países via API (caso tenha um /api/countries)

document.addEventListener('DOMContentLoaded', function() {
  const nationalitySelect = document.getElementById('nationality');
  if(nationalitySelect) {
      fetch('/api/countries')
        .then(response => response.json())
        .then(data => {
          data.forEach(country => {
            let option = document.createElement('option');
            option.value = country.code; // ex: "AO"
            // Exibir "Angola (AO)" se quiser
            option.value = `${country.name} (${country.code})`;
            option.text  = `${country.name} (${country.code})`;

            nationalitySelect.appendChild(option);
          });
        })
        .catch(error => console.error('Erro ao buscar países:', error));
  }
});



document.addEventListener('DOMContentLoaded', function() {
  const phoneCodeMenu = document.getElementById('phone_code_menu');
  const selectedCodeButton = document.getElementById('selected_code');
  const hiddenPhoneCode = document.getElementById('phone_code');

  if (phoneCodeMenu && selectedCodeButton && hiddenPhoneCode) {
    fetch('/api/countries')
      .then(response => response.json())
      .then(data => {
        data.forEach(country => {
          if (country.phone) {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.classList.add('dropdown-item');
            // Exibe "Angola (+244)" no dropdown
            a.textContent = `${country.name} (${country.phone})`;
            a.addEventListener('click', function(e) {
              e.preventDefault();
              // Atualiza o botão para exibir somente o código
              selectedCodeButton.textContent = country.phone;
              hiddenPhoneCode.value = country.phone;
            });
            li.appendChild(a);
            phoneCodeMenu.appendChild(li);
          }
        });
      })
      .catch(error => console.error('Erro ao buscar códigos de telefone:', error));
  }
});
