<?php
    echo '<link rel="stylesheet" href="public/style/register/loginForm.css">';
?>

<div class="login-container">
    <h1>MIAOH REGISTER</h1>
    <img src="<?php echo IMAGE_PATH; ?>logo/logo.png" alt="Logo">

    <?php if (isset($error_message)): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <form action="?action=login&subAction=auth-register" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input id="password" type="password" name="password" placeholder="Password" required>
        <small class="help-block" id="password-text"></small>
        <!-- Barra di progresso per la robustezza -->
        <div class="password-strength-bar" id="strength-bar"></div>
        <!-- Messaggio che mostra la robustezza della password -->
        <p id="strength-text"></p>

        <button type="submit">Login</button>
    </form>
    I already have an account - <a href="?action=login&subAction=login" class="signup-link">Sign in</a>

    <script src="public/script/register.js"></script>
</div>