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

// Aggiungi l'evento per il campo password
document.getElementById('password').addEventListener('input', updatePasswordStrengthIndicator);