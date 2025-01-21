<?php
    echo '<link rel="stylesheet" href="public/style/register/loginForm.css">';
?>

<div class="login-container d-flex flex-column justify-content-center align-items-center">
    <h1>MIAOH REGISTER</h1>
    <img src="<?php echo IMAGE_PATH; ?>logo/logo.png" alt="Logo">

    <?php if (isset($error_message)): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <form action="?action=login&subAction=auth-register" method="POST" enctype="multipart/form-data" class="w-100">
        <label for="image">Personalizza la tua immagine di profilo:</label>
        <input type="file" name="image" id="image" accept="image/*">

        <input type="text" name="username" placeholder="Username" id="username-input" required>
        <small id="username-valid" class="form-text text-success"  style="display: none;"></small>
        <small id="username-invalid" class="form-text text-danger" style="display: none;"></small>
        <small id="username-check" class="form-text text-info" style="display: none;">.</small>
        
        <input type="text" name="name" placeholder="Nome" required>
        <input type="text" name="surname" placeholder="Cognome" required>
        <input type="email" name="email" placeholder="Email" required>
        <input id="password" type="password" name="password" placeholder="Password" required>
        <small class="help-block" id="password-text"></small>
        <!-- Barra di progresso per la robustezza -->
        <div class="password-strength-bar" id="strength-bar"></div>
        <!-- Messaggio che mostra la robustezza della password -->
        <p id="strength-text"></p>

        <button type="submit" id="register-button">Registrati</button>
    </form>
    <div class="mt-3">
        Ho già un profilo - <a href="?action=login&subAction=login" class="signup-link">Log in</a>
    </div>
    <a href='?action=home'><button class="btn btn-secondary mt-3">Torna alla home</button></a>

    <script src="public/script/register.js"></script>
</div>