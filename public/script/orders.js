document.addEventListener('DOMContentLoaded', function() {
    askOrders(31); // Ask for orders older no more than 31 days
});

function askOrders(daysOld) {
    fetch('public/api/card_ordini.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'daysOld=' + encodeURIComponent(daysOld),
        credentials: 'include'
    })
    .then(response => response.text())
    .then(data => {
        if (data) {
            // Process the HTML response
            console.log('HTML received:', data);
            const ordersContainer = document.getElementById('orders-container');
            ordersContainer.innerHTML += data;
        } else {
            console.error('Errore: No data received');
        }
    })
    .catch(error => {
        console.error('Errore nella richiesta:', error);
        //alert('Si è verificato un errore durante la richiesta.');
    });
}