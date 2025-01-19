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

document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function () {
        addToCarrello(this.getAttribute('data-id'));
    });
});