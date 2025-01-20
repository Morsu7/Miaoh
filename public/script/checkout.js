// Show the modal when the button is clicked
document.querySelector('.confirm-checkout-btn').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    modal.show();
});

// Handle confirm button inside the modal
document.getElementById('confirmAction').addEventListener('click', function () {
    alert('Action confirmed!');
    // Add your logic for the confirmed action here
    const modal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
    modal.hide();

    checkout();
});

function checkout(){
    // Configura la richiesta con fetch
    fetch('public/api/checkout_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        credentials: 'include'
    })
    .then(response => console.log(response.text()))
    .then(data => {
        if (data.success) {
        } else {
            //console.error('Errore: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Errore nella richiesta:', error);
        //alert('Si è verificato un errore durante la richiesta.');
    });

    window.location.href = '?#';
}