async function deleteProduct(productId) {
    if (confirm('Sei sicuro di voler eliminare questo prodotto?')) {
        try {
            const response = await fetch('public/api/admin/delete_product.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: productId }),
            });

            if (response.ok) {
                const result = await response.json();
                if (result.success === true) {
                    const row = document.querySelector(`.single-product[data-id="${productId}"]`);
                    if (row) row.remove();
                } else {
                    showModal('Errore durante il recupero del prodotto da eliminare: ' + result.message);
                }
            } else {
                showModal('Errore durante il recupero del prodotto da eliminare.');
            }
        } catch (error) {
            console.error('Errore durante la richiesta:', error);
            showModal("Errore: Impossibile completare l'operazione.");
        }
    }
}

const searchInput = document.querySelector('.search-input');
const productList = document.querySelectorAll('.single-product-container');

// Aggiungi un listener per l'input
searchInput.addEventListener('input', function (event) {
    const searchQuery = event.target.value.toLowerCase(); // Ottieni il testo della ricerca e convertilo in minuscolo

    productList.forEach(card => {
        const productName = card.querySelector('.card-title').textContent.toLowerCase(); // Nome prodotto in minuscolo
        if (productName.includes(searchQuery)) {
            // Mostra la card se il nome del prodotto corrisponde alla ricerca
            card.classList.remove('d-none');
        } else {
            // Nascondi la card se il nome del prodotto non corrisponde
            card.classList.add('d-none');
        }
    });
});

// Ricerca prodotto
const loadingSpinner = document.getElementById('loadingSpinner');

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('liveSearchInput');
    const productList = document.querySelector('.product-list');
    const paginationContainer = document.querySelector('.pagination');  // Aggiunto per la paginazione

    let timeout = null;

    searchInput.addEventListener('input', () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            const searchTerm = searchInput.value.trim();
            loadingSpinner.style.display = 'block'; // Mostra il caricamento

            fetch(`?action=adminpage&subAction=products&search=${encodeURIComponent(searchTerm)}&ajax=1`)
                .then(response => response.json())  // Modificato per ricevere JSON
                .then(data => {
                    // Aggiorna la lista dei prodotti
                    productList.innerHTML = data.productList;

                    // Aggiorna la paginazione
                    paginationContainer.innerHTML = data.pagination;

                    loadingSpinner.style.display = 'none'; // Nascondi il caricamento
                })
                .catch(error => {
                    console.error('Errore durante la ricerca:', error);
                    loadingSpinner.style.display = 'none'; // Nascondi il caricamento
                });
        }, 300); // Ritarda l'esecuzione della ricerca di 300 ms
    });
});

function showModal(message) {
    const modalMessage = document.getElementById('modalMessage');
    modalMessage.textContent = message;

    const modal = new bootstrap.Modal(document.getElementById('alertModal'));
    modal.show();
}