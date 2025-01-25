function addToCarrello(productId){
    // Configura la richiesta con fetch
    fetch('public/api/incrementa_carrello.php', {
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
            if(data.error == 'No sessione'){
                window.location.href = '?action=login';
            }
            //console.error('Errore: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Errore nella richiesta:', error);
        //alert('Si è verificato un errore durante la richiesta.');
    });
}

async function isLogged() {
    try {
        const response = await fetch('public/api/check_sessione.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            credentials: 'include'
        });
        const data = await response.json();
        return data.success;
    } catch (error) {
        console.error('Errore nella richiesta:', error);
        return false;
    }
}

function addCartButtonFunc(button) {
    registerInteraction(button.getAttribute('data-id'), "carrello");
    addToCarrello(button.getAttribute('data-id'));

    isLogged().then(loggedIn => {
        if (loggedIn) {
           // Create a modal structure dynamically
            const modalHTML = `
            <div class="modal fade" id="cartConfirmationModal" tabindex="-1" aria-labelledby="cartConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cartConfirmationModalLabel">Aggiunto al carrello</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Il prodotto è stato aggiunto con successo al tuo carrello
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continua ad acquistare</button>
                            <a href="?action=shopping"><button type="button" class="btn btn-go-to-cart" data-bs-dismiss="modal">Vai al carrello</button></a>
                        </div>
                    </div>
                </div>
            </div>
            `;

            // Insert the modal HTML into the body of the page
            document.body.insertAdjacentHTML('beforeend', modalHTML);

            // Trigger the Bootstrap modal to confirm the item was added to the cart
            const modal = new bootstrap.Modal(document.getElementById('cartConfirmationModal'));
            modal.show(); // Show the modal
        }
    }); 
}

function askDetailButtonFunc(button) {
    registerInteraction(button.getAttribute('data-id'), "visita");
    let id = button.getAttribute("data-id");
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "?action=product";

    const input = document.createElement("input");
    input.type = "hidden";
    input.name = "product_id"; // Nome del parametro POST
    input.value = id; // Valore del data-id

    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}

document.addEventListener('click', (event) => {
    const targetCart = event.target.closest('.add-to-cart-btn');
    if(targetCart){
        event.stopPropagation();
        addCartButtonFunc(targetCart);
    }else{
        const targetDetail = event.target.closest('.ask-detail-btn');
        if(targetDetail){
            askDetailButtonFunc(targetDetail);
        }
    }
});

document.querySelectorAll('.user-img').forEach(button => {
    button.style.cursor = 'pointer';
    button.addEventListener('click', function() {
        window.location.href = '?action=profile';
    });
});
