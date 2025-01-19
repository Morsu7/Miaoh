// Funzione per incrementare la quantità
function increaseQuantity(inputId) {
    const input = document.getElementById(inputId);
    if (input) {
        input.value = parseInt(input.value) + 1;
        handleQuantityChange(inputId)
    }
}

// Funzione per decrementare la quantità
function decreaseQuantity(inputId) {
    const input = document.getElementById(inputId);
    if (input) {
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            handleQuantityChange(inputId)
        }
    }
}

// Funzione per gestire il cambio manuale della quantità
function handleQuantityChange(inputId) {
    const input = document.getElementById(inputId);
    if (input) {
        const value = parseInt(input.value);
        if (value < 1 || isNaN(value)) {
            input.value = 1; // Forza il valore minimo
        }
        //console.log(`Nuova quantità per ${inputId}: ${input.value}`);
        const totalId = document.getElementById("total-" + inputId);
        const price = document.getElementById("price-" + inputId);
        const total = document.getElementById("totalPrice");

        totalId.innerHTML = String((parseFloat(price.innerHTML) * parseFloat(input.value)).toFixed(2));

        updateTotal();
        updateDatabaseCarrello(inputId, input.value);
    }
}

function updateTotal(){
    let sum = parseFloat(0);
    document.querySelectorAll('.total-item').forEach(totalText => {
        sum += parseFloat(totalText.innerHTML);
    });
    
    let spedizione = 5;
    if(sum > 25){
        spedizione = 0;
    }

    total = (sum+spedizione).toFixed(2);
    sum = sum.toFixed(2);

    const totalHTML = document.getElementById("totalPrice");
    const shipping = document.getElementById("shippingCost");
    const totalWithShipping = document.getElementById("totalWithShipping");

    totalHTML.innerHTML = "€" + sum;
    shipping.innerHTML = "€" + spedizione;
    totalWithShipping.innerHTML = "€" + total;
}

function deleteFromCart(productId){
    console.log("Rimuovo " + productId);
    fetch('public/api/rimuovi_carrello.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id=' + encodeURIComponent(productId), // Invia solo l'ID del prodotto e il tipo di interazione
        credentials: 'include'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            //console.log('Sessione sì');
        } else {
            //console.error('Errore: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Errore nella richiesta:', error);
        //alert('Si è verificato un errore durante la richiesta.');
    });
}

function updateDatabaseCarrello(productId, quantita){
    // Configura la richiesta con fetch
    fetch('public/api/aggiungi_carrello.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id=' + encodeURIComponent(productId) + '&quantity=' + encodeURIComponent(quantita), // Invia solo l'ID del prodotto e il tipo di interazione
        credentials: 'include'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            //console.log('Sessione sì');
        } else {
            //console.error('Errore: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Errore nella richiesta:', error);
        //alert('Si è verificato un errore durante la richiesta.');
    });
}

// Aggiungere i listener per tutti gli input di tipo "quantity-input"
document.querySelectorAll('.quantity-input').forEach(inputElement => {
    // Listener per intercettare quando l'input perde il focus (blur) o cambia il valore (change)
    inputElement.addEventListener('blur', function () {
        handleQuantityChange(inputElement.id);
    });
    inputElement.addEventListener('change', function () {
        handleQuantityChange(inputElement.id);
    });
});

let itemIdToDelete = null;

// Listen for any "Delete" button click to dynamically store the item ID
document.querySelectorAll('.delete-item').forEach(button => {
    button.addEventListener('click', function () {
        // Get the item ID from the button's data attribute
        itemIdToDelete = this.getAttribute('data-item-id');
    });
});

document.querySelectorAll('.confirm-delete').forEach(button => button.addEventListener('click', function() {
    if (itemIdToDelete !== null) {
        deleteFromCart(itemIdToDelete);
        let card = document.getElementById("card-" + itemIdToDelete);
        card.remove();
        updateTotal();
        location.reload();

        // Close the modal after action
        var modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        modal.hide();
    }
}));