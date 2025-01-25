document.addEventListener('DOMContentLoaded', function() {
    askNotifications(7);

    const periodSelect = document.getElementById('period-select-n');
    const optionValues = Array.from(periodSelect.children).map(option => option.text);
    
    periodSelect.addEventListener('change', function() {
        switch(this.value) {
            case optionValues[0]:
                askNotifications(7);
                break;
            case optionValues[1]:
                askNotifications(31);
                break;
            case optionValues[2]:
                askNotifications(186);
                break;
            case optionValues[3]:
                askNotifications(365);
                break;
            case optionValues[4]:
            default:
                askNotifications(-1);
                break;
        }
    });
});

function askNotifications(daysOld) {
    fetch('public/api/ask_notifiche.php', {
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
            const notificationsContainer = document.getElementById('notifications-container');
            notificationsContainer.innerHTML = '';
            notificationsContainer.innerHTML += data;
        } else {
            console.error('Errore: No data received');
        }
    })
    .catch(error => {
        console.error('Errore nella richiesta:', error);
        //alert('Si è verificato un errore durante la richiesta.');
    });
}

function toggleMessage(element) {
    var messageDiv = element.nextElementSibling;
    if (messageDiv.style.display === "none") {
        messageDiv.style.display = "block";
        if(isNew(element)){
            read(element);
        }
    } else {
        messageDiv.style.display = "none";
    }
}

function isNew(element){
    let object = element.firstElementChild;

    return object.querySelector('strong') !== null;
}

function read(element){
    let object = element.firstElementChild;
    let strongElements = object.querySelectorAll('strong');
    strongElements.forEach(strong => {
        let span = document.createElement('span');
        span.innerHTML = strong.innerHTML;
        strong.replaceWith(span);
    });

    let idNotification = element.getAttribute('data-id');

    fetch('public/api/read_notifica.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id_notifica=' + encodeURIComponent(idNotification),
        credentials: 'include'
    })
    .then(response => response.json())
    .then(data => {
        if (data) {
            if(data.success){
                console.log('Notifica letta');
            }else{
                console.error('Errore: ' + data.error);
            }
        } else {
            console.error('Errore: No data received');
        }
    })
}