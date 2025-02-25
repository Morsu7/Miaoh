function registerInteraction(productId, type){
    // Configura la richiesta con fetch
    fetch('public/api/interactions.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id=' + encodeURIComponent(productId) + '&type=' + encodeURIComponent(type) // Invia solo l'ID del prodotto e il tipo di interazione
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Interazione con il prodotto ' + productId + ' registrata con successo.');
        } else {
            console.error('Errore: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Errore nella richiesta:', error);
        //alert('Si è verificato un errore durante la richiesta.');
    });
}