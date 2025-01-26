const editProductModal = document.querySelector('.edit-product-modal');
editProductModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const nome = button.getAttribute('data-nome');
    const descrizione = button.getAttribute('data-descrizione');
    const prezzo = button.getAttribute('data-prezzo');
    const sconto = button.getAttribute('data-sconto');
    const quantita = button.getAttribute('data-quantita');
    const fineSconto = button.getAttribute('data-finesconto');  // Data fine sconto
    const tipoProdottoId = button.getAttribute('data-tipoprodottoid');  // Tipo di prodotto
    const img1 = button.getAttribute('data-img1');  // URL dell'immagine (se disponibile)

    const modalId = document.getElementById('editProductId');
    const modalNome = document.getElementById('editProductName');
    const modalDescrizione = document.getElementById('editProductDescription');
    const modalPrezzo = document.getElementById('editProductPrice');
    const modalSconto = document.getElementById('editProductDiscount');
    const modalQuantita = document.getElementById('editProductQuantity');
    const modalFineSconto = document.getElementById('editProductEndDiscount');
    const modalTipoProdotto = document.getElementById('editProductType');
    const modalImgPreview = document.getElementById('editProductImagePreview');

    // Imposta i valori nei campi
    modalId.value = id;
    modalNome.value = nome;
    modalDescrizione.value = descrizione;
    modalPrezzo.value = prezzo;
    modalSconto.value = sconto;
    modalQuantita.value = quantita;
    modalFineSconto.value = fineSconto; // Imposta la data di fine sconto
    modalTipoProdotto.value = tipoProdottoId; // Imposta il tipo di prodotto

    // Carica l'immagine di anteprima (se disponibile)
    if (img1) {
        modalImgPreview.src = img1;  // Carica l'immagine da una URL
        modalImgPreview.style.display = 'block';  // Mostra l'anteprima
    } else {
        modalImgPreview.style.display = 'none';  // Nascondi l'anteprima se non c'è immagine
    }
});

document.querySelector('.edit-product-form .product-image').addEventListener('change', handleImageChange);
document.querySelector('.edit-product-form .product-enddiscount').addEventListener('change', checkDate);

function checkDate() {
    const inputDate = new Date(this.value); // Data selezionata dall'utente
    const today = new Date(); // Data odierna

    // Imposta l'ora di today a mezzanotte per confronti solo con la data
    today.setHours(0, 0, 0, 0);

    const errorMessage = document.getElementById('errorMessage');

    if (inputDate <= today) {
        // La data non è nel futuro
        errorMessage.style.display = 'block';
        this.setCustomValidity('La data deve essere nel futuro.');
    } else {
        // La data è valida
        errorMessage.style.display = 'none';
        this.setCustomValidity('');
    }
}

function handleImageChange(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const previewElement = document.querySelector('.edit-product-form .product-image-preview');
            if (previewElement) {
                previewElement.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
}

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
        fine_sconto: document.getElementById('editProductEndDiscount').dataset.originalValue,
        tipoProdotto_id: document.getElementById('editProductType').dataset.originalValue
    };

    const updatedData = {
        nome: document.getElementById('editProductName').value,
        descrizione: document.getElementById('editProductDescription').value,
        prezzo: document.getElementById('editProductPrice').value,
        sconto: document.getElementById('editProductDiscount').value,
        quantita: document.getElementById('editProductQuantity').value,
        fine_sconto: document.getElementById('editProductEndDiscount').value,
        tipoProdotto_id: document.getElementById('editProductType').value
    };

    // Validazione della data di fine sconto
    const fineSconto = new Date(updatedData.fineSconto);
    const currentDate = new Date();
    const errorMessageElement = document.getElementById('errorMessage');

    if (fineSconto <= currentDate) {
        errorMessageElement.style.display = 'block';
        return;
    } else {
        errorMessageElement.style.display = 'none';
    }

    const imageFile = document.getElementById('editProductImage').files[0];

    const formData = new FormData();
    formData.append('id', productId);

    for (const key in updatedData) {
        if (updatedData[key] !== originalData[key]) {
            formData.append(key, updatedData[key]);
        }
    }
    // TODO: Fixare immagine
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

                const modal = document.querySelector('.modal.edit-product-modal');
                if (modal) {
                    const bootstrapModal = bootstrap.Modal.getInstance(modal);
                    bootstrapModal.hide();
                }

                refreshProductList();
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

async function refreshProductList() {
    try {
        const currentPageElement = document.querySelector(".page-item.active a"); // Personalizza il selettore in base alla tua struttura HTML
        const currentPage = currentPageElement ? currentPageElement.textContent.trim() : "1"; // Default: pagina 1

        const response = await fetch(`?action=adminpage&subAction=products&ajax=1&page=${currentPage}`);
        if (response.ok) {
            const result = await response.json();
            // Aggiorna l'HTML della lista prodotti e della paginazione
            document.querySelector(".product-list").innerHTML = result.productList;
            document.querySelector(".pagination").innerHTML = result.pagination;
        } else {
            console.error("Errore nella comunicazione con il server per aggiornare la lista prodotti.");
        }
    } catch (error) {
        console.error("Errore durante il refresh della lista prodotti:", error);
    }
}