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

//JavaScript para pegar o os paises na criação do funcionário.

document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/countries')
      .then(response => response.json())
      .then(data => {
        const select = document.getElementById('nationality');
        data.forEach(country => {
          let option = document.createElement('option');
          option.value = country.code;
          option.text = country.name;
          select.appendChild(option);
        });
      })
      .catch(error => console.error('Erro ao buscar países:', error));
  });
  
