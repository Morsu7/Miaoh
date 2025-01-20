const editProductModal = document.getElementById('editProductModal');
editProductModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const nome = button.getAttribute('data-nome');
    const descrizione = button.getAttribute('data-descrizione');
    const prezzo = button.getAttribute('data-prezzo');
    const sconto = button.getAttribute('data-sconto');
    const quantita = button.getAttribute('data-quantita');

    const modalId = document.getElementById('editProductId');
    const modalNome = document.getElementById('editProductName');
    const modalDescrizione = document.getElementById('editProductDescription');
    const modalPrezzo = document.getElementById('editProductPrice');
    const modalSconto = document.getElementById('editProductDiscount');
    const modalQuantita = document.getElementById('editProductQuantity');

    modalId.value = id;
    modalNome.value = nome;
    modalDescrizione.value = descrizione;
    modalPrezzo.value = prezzo;
    modalSconto.value = sconto;
    modalQuantita.value = quantita;
});

// TODO: Cambiare test
const editForm = document.getElementById('test');
editForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const productId = document.getElementById('editProductId').value;
    const originalData = {
        nome: document.getElementById('editProductName').dataset.originalValue,
        descrizione: document.getElementById('editProductDescription').dataset.originalValue,
        prezzo: document.getElementById('editProductPrice').dataset.originalValue,
        sconto: document.getElementById('editProductDiscount').dataset.originalValue,
        quantita: document.getElementById('editProductQuantity').dataset.originalValue,
    };

    const updatedData = {
        nome: document.getElementById('editProductName').value,
        descrizione: document.getElementById('editProductDescription').value,
        prezzo: document.getElementById('editProductPrice').value,
        sconto: document.getElementById('editProductDiscount').value,
        quantita: document.getElementById('editProductQuantity').value,
    };

    // Crea un oggetto per contenere solo i dati modificati
    const changes = {};
    for (const key in updatedData) {
        if (updatedData[key] !== originalData[key]) {
            changes[key] = updatedData[key];
        }
    }

    // Invia solo i dati modificati
    if (Object.keys(changes).length > 0) {
        changes.id = productId; // Aggiungi l'ID del prodotto
        fetch('public/api/edit_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(changes),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 'success') {
                    const productContainer = document.querySelector(`.single-product[data-id="${productId}"]`);
                    if (productContainer) {
                        productContainer.querySelector('.card-title').textContent = updatedData.nome;

                        // Aggiorna descrizione
                        const descElement = productContainer.querySelector('.card-body .card-text:nth-of-type(1)');
                        if (descElement) {
                            descElement.textContent = updatedData.descrizione;
                        }

                        // Aggiorna prezzo
                        const priceElement = productContainer.querySelector('.card-body .card-text:nth-of-type(2)');
                        if (priceElement) {
                            priceElement.innerHTML = `<strong>Prezzo: </strong>€${parseFloat(updatedData.prezzo).toFixed(2)}`;
                        }

                        // Aggiorna sconto
                        const discountElement = productContainer.querySelector('.card-body .card-text:nth-of-type(3)');
                        if (discountElement) {
                            discountElement.innerHTML = `<strong>Sconto: </strong>${updatedData.sconto}%`;
                        }

                        // Aggiorna prezzo scontato
                        const discountedPriceElement = productContainer.querySelector('.card-body .card-text:nth-of-type(4)');
                        if (discountedPriceElement) {
                            discountedPriceElement.innerHTML = `<strong>Prezzo Scontato: </strong>€${parseFloat(updatedData.prezzo - updatedData.prezzo * updatedData.sconto / 100).toFixed(2)}`;
                        }

                        // Aggiorna quantità
                        const quantityElement = productContainer.querySelector('.card-body .card-text:nth-of-type(5)');
                        if (quantityElement) {
                            quantityElement.innerHTML = `<strong>Quantità: </strong>${updatedData.quantita}`;
                        }

                        // Aggiorna l'immagine del prodotto
                        const imgElement = productContainer.querySelector('.card-img-top');
                        if (imgElement) {
                            imgElement.src = updatedData.img1; // Aggiorna l'URL dell'immagine
                        }

                        const modal = document.querySelector('.modal#editProductModal');
                        if (modal) {
                            const bootstrapModal = bootstrap.Modal.getInstance(modal);
                            bootstrapModal.hide();
                        }

                        console.log('Prodotto modificato con successo!');
                    } else {
                        console.error('Errore:', data.message);
                    }
                } else {
                    console.error('Errore:', data.message);
                }
            })
            .catch((error) => {
                console.error('Errore nella richiesta:', error);
            });
    } else {
        console.log('Nessuna modifica rilevata.');
    }
});

function deleteProduct(productId) {
    if (confirm('Sei sicuro di voler eliminare questo prodotto?')) {
        fetch('public/api/delete_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: productId }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 'success') {
                    alert('Prodotto eliminato con successo!');
                    // Rimuovi la riga dalla tabella senza ricaricare la pagina
                    const row = document.querySelector(`tr[data-id="${productId}"]`);
                    if (row) row.remove();
                } else {
                    alert('Errore durante l\'eliminazione del prodotto: ' + data.message);
                }
            })
            .catch((error) => {
                console.error('Errore nella richiesta:', error);
                alert('Si è verificato un errore durante la richiesta.');
            });
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