document.addEventListener('submit', (event) => {
    if (event.target.matches('.update-order-status-form')) {
        event.preventDefault();
        updateOrderStatus.call(event.target, event);
    }
});

async function updateOrderStatus(event) {
    event.preventDefault(); // Evita il submit normale del form

    const formData = new FormData(this); // Ottieni i dati del form inviato

    try {
        // Usa fetch per inviare i dati tramite POST
        const resp = await fetch('public/api/admin/update_order_status.php', {
            method: 'POST',
            body: formData
        });

        if (resp.ok) {
            const data = await resp.json();
            if (data.success) {
                // Trova la card dell'ordine che è stato aggiornato
                const orderCard = document.querySelector(`.card[data-id_acquisto="${data.id_acquisto}"]`);

                // Aggiorna lo stato dell'ordine nella card
                const stateElement = orderCard.querySelector('.stato-acquisto');
                stateElement.innerHTML = getStatoFormatted(data.stato_acquisto); // Formatta il nuovo stato

                // Aggiorna il bottone e il form
                const actionColumn = orderCard.querySelector('.card-footer'); // Trova la parte inferiore della card (dove ci sono le azioni)
                if (data.stato_acquisto === 'consegnato') {
                    actionColumn.innerHTML = `<button class="btn btn-secondary mt-2 w-100" disabled>Consegnato</button>`;
                } else {
                    actionColumn.innerHTML = `
                        <form method="POST" class="d-flex align-items-center update-order-status-form">
                            <input type="hidden" name="id_acquisto" value="${data.id_acquisto}">
                        
                            <select name="stato_acquisto" class="form-select w-auto me-2">
                                <option value="da_spedire" ${data.stato_acquisto === 'da_spedire' ? 'selected' : ''}>Da Spedire</option>
                                <option value="spedito" ${data.stato_acquisto === 'spedito' ? 'selected' : ''}>Spedito</option>
                                <option value="consegnato" ${data.stato_acquisto === 'consegnato' ? 'selected' : ''}>Consegnato</option>
                            </select>
                        
                            <button type="submit" class="btn btn-primary mt-2 w-100">Cambia stato</button>
                        </form>
                    `;
                }

                showModal('Stato dell\'ordine aggiornato con successo.', 'success');
            } else {
                showModal('Errore nell\'aggiornamento dello stato: ' + data.message, 'error');
            }
        } else {
            console.error('Errore durante la richiesta:', resp);
            showModal('Si è verificato un errore.', 'error');
        }
    } catch (error) {
        console.error('Errore durante la richiesta:', error);
        showModal('Si è verificato un errore.', 'error');
    }
}

function getStatoFormatted(stato) {
    switch (stato) {
        case 'da_spedire':
            return '<span class="badge bg-warning text-dark">Da Spedire</span>';
        case 'spedito':
            return '<span class="badge bg-info text-white">Spedito</span>';
        case 'consegnato':
            return '<span class="badge bg-success text-white">Consegnato</span>';
        default:
            return '<span class="badge bg-secondary text-white">Stato sconosciuto</span>';
    }
}

// Filtri

document.getElementById('orderFilterForm').addEventListener('submit', function (event) {
    event.preventDefault();  // Evita il comportamento predefinito di submit del form

    const formData = new FormData(this);  // Raccogli i dati del form

    // Converti i dati del form in una query string
    const queryParams = new URLSearchParams();
    formData.forEach((value, key) => {
        queryParams.append(key, value);
    });

    // Aggiungi il parametro ajax=1
    queryParams.append('ajax', '1');

    // Costruisci l'URL finale con i parametri
    const url = `${window.location.pathname}?${queryParams.toString()}`;
    console.log(url);
    // Esegui la fetch con il metodo GET
    fetch(url, {
        method: 'GET',  // Usa il metodo GET
    })
        .then(response => response.json())
        .then(data => {
            // Sostituisci la lista degli ordini con quella aggiornata
            document.querySelector('.row.mt-4').innerHTML = data.productList;
            // Sostituisci la paginazione con quella aggiornata
            document.querySelector('.pagination').innerHTML = data.pagination;
        })
        .catch(error => {
            console.error('Errore durante il filtro degli ordini:', error);
            showModal('Si è verificato un errore.', 'error');
        });
});

function showModal(message) {
    const modalMessage = document.getElementById('modalMessage');
    modalMessage.textContent = message;

    const modal = new bootstrap.Modal(document.getElementById('alertModal'));
    modal.show();
}