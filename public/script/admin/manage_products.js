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

// Edit product form
const editForm = document.querySelector('.edit-product-form');
editForm.addEventListener('submit', editProduct);

async function editProduct(e) {
    e.preventDefault();

    const productId = document.getElementById('editProductId').value;
    const originalData = {
        nome: document.getElementById('editProductName').dataset.originalValue,
        descrizione: document.getElementById('editProductDescription').dataset.originalValue,
        prezzo: document.getElementById('editProductPrice').dataset.originalValue,
        sconto: document.getElementById('editProductDiscount').dataset.originalValue,
        quantita: document.getElementById('editProductQuantity').dataset.originalValue,
        fineSconto: document.getElementById('editProductEndDiscount').dataset.originalValue,
    };

    const updatedData = {
        nome: document.getElementById('editProductName').value,
        descrizione: document.getElementById('editProductDescription').value,
        prezzo: document.getElementById('editProductPrice').value,
        sconto: document.getElementById('editProductDiscount').value,
        quantita: document.getElementById('editProductQuantity').value,
        fineSconto: document.getElementById('editProductEndDiscount').value,
    };

    const imageFile = document.getElementById('editProductImage').files[0];

    const formData = new FormData();
    formData.append('id', productId);

    for (const key in updatedData) {
        if (updatedData[key] !== originalData[key]) {
            formData.append(key, updatedData[key]);
        }
    }

    if (imageFile) {
        formData.append('img1', imageFile);
    }

    try {
        const response = await fetch('public/api/admin/edit_product.php', {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();

        if (data.success === true) {
            const productContainer = document.querySelector(`.single-product[data-id="${productId}"]`);
            if (productContainer) {
                productContainer.querySelector('.card-title').textContent = updatedData.nome;

                const descElement = productContainer.querySelector('.card-body .card-text:nth-of-type(1)');
                if (descElement) {
                    descElement.textContent = updatedData.descrizione;
                }

                const priceElement = productContainer.querySelector('.card-body .card-text:nth-of-type(2)');
                if (priceElement) {
                    priceElement.innerHTML = `<strong>Prezzo: </strong>€${parseFloat(updatedData.prezzo).toFixed(2)}`;
                }

                const discountElement = productContainer.querySelector('.card-body .card-text:nth-of-type(3)');
                if (discountElement) {
                    discountElement.innerHTML = `<strong>Sconto: </strong>${updatedData.sconto}%`;
                }

                const discountedPriceElement = productContainer.querySelector('.card-body .card-text:nth-of-type(4)');
                if (discountedPriceElement) {
                    discountedPriceElement.innerHTML = `<strong>Prezzo Scontato: </strong>€${parseFloat(updatedData.prezzo - updatedData.prezzo * updatedData.sconto / 100).toFixed(2)}`;
                }

                const quantityElement = productContainer.querySelector('.card-body .card-text:nth-of-type(5)');
                if (quantityElement) {
                    quantityElement.innerHTML = `<strong>Quantità: </strong>${updatedData.quantita}`;
                }

                const imgElement = productContainer.querySelector('.card-img-top');
                if (imgElement && imageFile) {
                    imgElement.src = URL.createObjectURL(imageFile);
                }

                const modal = document.querySelector('.modal#editProductModal');
                if (modal) {
                    const bootstrapModal = bootstrap.Modal.getInstance(modal);
                    bootstrapModal.hide();
                }

                console.log('Prodotto modificato con successo!');
            } else {
                console.error('Errore: Impossibile aggiornare i dettagli nella UI.');
            }
        } else {
            console.error('Errore:', data.message);
        }
    } catch (error) {
        console.error('Errore nella richiesta:', error);
    }
}

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
                    alert('Errore durante il recupero del prodotto da eliminare: ' + result.message);
                }
            } else {
                alert('Errore durante il recupero del prodotto da eliminare.');
            }
        } catch (error) {
            console.error('Errore durante la richiesta:', error);
            alert("Errore: Impossibile completare l'operazione.");
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