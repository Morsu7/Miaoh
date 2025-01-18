document.querySelector('.logo-header').addEventListener('click', () => {
    location.href = location.pathname; // Rimuove i parametri GET e ricarica la pagina
});