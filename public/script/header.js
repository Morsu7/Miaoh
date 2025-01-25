document.querySelector('.logo-header').addEventListener('click', () => {
    location.href = location.pathname;
});

function checkNotifiche(){
    fetch('public/api/check_new_notifications.php', {
        method: 'POST',
        credentials: 'include'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if(data.new){
                showNotificationDot();
            }else{
                hideNotificationDot();
            }
        }else{
            console.error('Errore: ' + data.error);
        }
    });
}

function showNotificationDot(){
    let dot = document.getElementById('notification-dot');
    dot.style.display = 'block';
}

function hideNotificationDot(){
    let dot = document.getElementById('notification-dot');
    dot.style.display = 'none';
}

document.addEventListener('DOMContentLoaded', () => {
    checkNotifiche();
    let dot = document.getElementById('notification-dot');
});

setInterval(checkNotifiche, 5000);