// Aggiungi un event listener a tutti i form nella tabella
document.querySelectorAll('.update-order-status-form').forEach(form => {
    form.addEventListener('submit', updateOrderStatus);
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
                // Trova la riga dell'ordine che è stato aggiornato
                const orderRow = document.querySelector(`tr[data-id_acquisto="${data.id_acquisto}"]`);

                // Aggiorna lo stato dell'ordine nella tabella
                const stateColumn = orderRow.querySelector('.stato-acquisto');
                stateColumn.innerHTML = getStatoFormatted(data.stato_acquisto); // Formatta il nuovo stato

                // Aggiorna il bottone
                const actionColumn = orderRow.querySelector('td:last-child'); // Trova la cella delle azioni
                if (data.stato_acquisto === 'consegnato') {
                    actionColumn.innerHTML = `<button class="btn btn-secondary mt-2" disabled>Consegnato</button>`;
                } else {
                    actionColumn.innerHTML = `
                        <form method="POST" class="d-flex align-items-center update-order-status-form">
                            <input type="hidden" name="id_acquisto" value="${data.id_acquisto}">
                        
                            <select name="stato_acquisto" class="form-select w-auto me-2">
                                <option value="da_spedire" ${data.stato_acquisto === 'da_spedire' ? 'selected' : ''}>Da Spedire</option>
                                <option value="spedito" ${data.stato_acquisto === 'spedito' ? 'selected' : ''}>Spedito</option>
                                <option value="consegnato" ${data.stato_acquisto === 'consegnato' ? 'selected' : ''}>Consegnato</option>
                            </select>
                        
                            <button type="submit" class="btn btn-primary mt-2">Cambia stato</button>
                        </form>
                        `;

                    // Ricollega l'evento submit al nuovo form
                    actionColumn.querySelector('form').addEventListener('submit', updateOrderStatus);
                }

                alert('Stato dell\'ordine aggiornato con successo.');
            } else {
                alert('Errore nell\'aggiornamento dello stato: ' + data.message);
            }
        } else {
            console.error('Errore durante la richiesta:', resp);
            alert('Si è verificato un errore.');
        }
    } catch (error) {
        console.error('Errore durante la richiesta:', error);
        alert('Si è verificato un errore.');
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