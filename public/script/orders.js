document.addEventListener('DOMContentLoaded', function() {
    askOrders(7); // Ask for orders older no more than 31 days

    const periodSelect = document.getElementById('period-select');
    const optionValues = Array.from(periodSelect.children).map(option => option.text);
    
    periodSelect.addEventListener('change', function() {
        switch(this.value) {
            case optionValues[0]:
                askOrders(7);
                break;
            case optionValues[1]:
                askOrders(31);
                break;
            case optionValues[2]:
                askOrders(186);
                break;
            case optionValues[3]:
                askOrders(365);
                break;
            case optionValues[4]:
            default:
                askOrders(-1);
                break;
        }
    });
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
            //console.log('HTML received:', data);
            const ordersContainer = document.getElementById('orders-container');
            ordersContainer.innerHTML = '';
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