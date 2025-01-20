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
    button.addEventListener('click', function (event) {
        event.stopPropagation();
        addToCarrello(this.getAttribute('data-id'));
    });
});

document.querySelectorAll('.ask-detail-btn').forEach(button => {
    button.addEventListener('click', function() {
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
    });
});

document.querySelectorAll('.user-img').forEach(button => {
    button.style.cursor = 'pointer';
    button.addEventListener('click', function() {
        window.location.href = '?action=profile';
    });
});