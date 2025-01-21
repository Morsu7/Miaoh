// Show the modal when the button is clicked
document.querySelector('.confirm-checkout-btn').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    modal.show();
});

// Handle confirm button inside the modal
document.getElementById('confirmAction').addEventListener('click', function () {
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
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '?#';
        } else {
            console.log(data);
            if(data.error === 'quantity'){
                window.location.href = '?action=shopping&product_id=' + data.product_id;
            }
        }
    })
    .catch(error => {
        console.error('Errore nella richiesta:', error);
        //alert('Si è verificato un errore durante la richiesta.');
    });
}