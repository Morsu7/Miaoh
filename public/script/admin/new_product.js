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

// TODO: Validare dati
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
                alert("Prodotto aggiunto con successo!");
                // Puoi chiudere il modal o aggiornare la lista dei prodotti
                document.querySelector(".add-product-modal").classList.remove("show");
                document.querySelector(".modal-backdrop").remove();
                form.reset();
                // TODO: Aggiungere il prodotto alla lista
            } else {
                alert("Errore: " + result.message);
            }
        } else {
            alert("Errore nella comunicazione con il server.");
        }
    } catch (error) {
        console.error("Errore durante l'invio del form:", error);
        alert("Errore: Impossibile completare l'operazione.");
    }
}