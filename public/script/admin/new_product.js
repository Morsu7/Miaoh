const form = document.querySelector(".add-product-form");
form.addEventListener("submit", handleSubmit);

document.querySelector('.add-product-form .product-image').addEventListener('change', handleImageChange);
document.querySelector('.add-product-form .product-enddiscount').addEventListener('change', checkDate);

// Functions

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
            const previewElement = document.querySelector('.add-product-form .product-image-preview');
            if (previewElement) {
                previewElement.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
}

async function handleSubmit(e) {
    e.preventDefault(); // Previeni il comportamento predefinito del form

    // Crea un oggetto FormData per raccogliere i dati del form
    const formData = new FormData(form);

    try {
        // Invia la richiesta POST al server
        const response = await fetch("public/api/admin/new_product.php", {
            method: "POST",
            body: formData,
        });

        // Controlla la risposta
        if (response.ok) {
            const result = await response.json();
            if (result.success) {
                // Reset del form e chiusura del modal
                // Reset del form
                form.reset();

                // Ottieni il modal con Bootstrap
                const modalElement = document.querySelector(".add-product-modal");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);

                // Se il modal è aperto, chiudilo
                if (modalInstance) {
                    modalInstance.hide();
                }

                // Aggiorna dinamicamente la lista dei prodotti
                refreshProductList();
                showModal("Prodotto aggiunto con successo!");
            } else {
                showModal("Errore: " + result.message);
            }
        } else {
            showModal("Errore nella comunicazione con il server.");
        }
    } catch (error) {
        console.error("Errore durante l'invio del form:", error);
        showModal("Errore: Impossibile completare l'operazione.");
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

function showModal(message) {
    const modalMessage = document.getElementById('modalMessage');
    modalMessage.textContent = message;

    const modal = new bootstrap.Modal(document.getElementById('alertModal'));
    modal.show();
}