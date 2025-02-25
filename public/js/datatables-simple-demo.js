window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

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
});
