// Funzione per calcolare la robustezza della password
function checkPasswordStrength(password) {
    let strength = 0;

    // Aumenta la forza in base alla lunghezza della password
    if (password.length >= 6) strength += 1;
    if (password.length >= 8) strength += 1;
    if (password.length >= 12) strength += 1;

    // Aumenta la forza se contiene numeri, lettere maiuscole e simboli
    if (/[A-Z]/.test(password)) strength += 1;
    if (/\d/.test(password)) strength += 1;
    if (/[^A-Za-z0-9]/.test(password)) strength += 1;

    return strength;
}

// Funzione per aggiornare la barra di progresso e il testo della robustezza
function updatePasswordStrengthIndicator() {
    const password = document.getElementById('password').value;
    const strengthBar = document.getElementById('password-text');
    var barVal;
    const strength = checkPasswordStrength(password);

    // Aggiorna la barra di forza e il messaggio in base alla robustezza
    if (password == "") {
        barVal = "<small class='help-block' id='password-text'></small>";
    } else if (strength < 3) {
        barVal = "<small class='progress-bar bg-danger' style='width: 40%'>Weak</small>";
    } else if (strength < 5) {
        barVal = "<small class='progress-bar bg-warning' style='width: 60%'>Medium</small>";
    } else {
        barVal = "<small class='progress-bar bg-success' style='width: 100%'>Strong</small>";
    }

    strengthBar.innerHTML = barVal;
}

let checkText;
let dots = 0;
let lastTime = 0;
let canSubmit = false;
document.addEventListener('DOMContentLoaded', function() {
    checkText = document.getElementById('username-check');

    const registerButton = document.getElementById('register-button');
    registerButton.addEventListener('click', function(event) {
        // Check if all required inputs are filled
        const isFormValid = Array.from(this.form.elements).every((field) => {
            if (field.tagName === "INPUT" && field.type !== "submit" && field.required) {
            return field.value.trim() !== ""; // Ensure no empty fields
            }
            return true; // Ignore non-required fields
        });

        if(isFormValid){
            if(!canSubmit){
                event.preventDefault();
                alert('Inserisci un username che sia disponibile');
            }
        }
    });
});

function animate(time) {
    if (checkText.style.display === 'none') {
        return;
    }
    
    if (time - lastTime >= 500) {
        dots = (dots + 1) % 4;
        checkText.textContent = 'Controllo username' + '.'.repeat(dots);
        lastTime = time;
    }
    requestAnimationFrame(animate);
}

function showChecking() {
    const checkText = document.getElementById('username-check');
    checkText.style.display = 'inline';
    requestAnimationFrame(animate);
    const successText = document.getElementById('username-valid');
    successText.style.display = 'none';
    const invalidText = document.getElementById('username-invalid');
    invalidText.style.display = 'none';
}

function hideChecking() {
    const checkText = document.getElementById('username-check');
    checkText.style.display = 'none';
}

function showValid(username) {
    const checkText = document.getElementById('username-check');
    checkText.style.display = 'none';
    const successText = document.getElementById('username-valid');
    successText.style.display = 'inline';
    successText.innerHTML = 'Username ' + username + ' disponibile';
    const invalidText = document.getElementById('username-invalid');
    invalidText.style.display = 'none';

    canSubmit = true;
}

function showInvalid(username) {
    const checkText = document.getElementById('username-check');
    checkText.style.display = 'none';
    const successText = document.getElementById('username-valid');
    successText.style.display = 'none';
    const invalidText = document.getElementById('username-invalid');
    invalidText.style.display = 'inline';
    invalidText.innerHTML = 'Username ' + username + ' non disponibile';
}

function checkUsername(username) {
    // Configura la richiesta con fetch
    fetch('public/api/check_username.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'username=' + encodeURIComponent(username)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showValid(username);
        } else {
            showInvalid(username);
            console.log(data.error)
        }
    })
    .catch(error => {
        console.error('Errore nella richiesta:', error);
        //alert('Si è verificato un errore durante la richiesta.');
    });
}

let usernameTimeout;
document.querySelector('input[name="username"]').addEventListener('input', function() {
    canSubmit = false;
    showChecking();
    clearTimeout(usernameTimeout);
    const username = this.value;
    usernameTimeout = setTimeout(function() {
        if(username.length > 0){
            checkUsername(username);
        }else{
            showChecking();
            hideChecking();
        }
    }, 1000);
});

// Aggiungi l'evento per il campo password
document.getElementById('password').addEventListener('input', updatePasswordStrengthIndicator);