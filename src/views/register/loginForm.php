<?php
    echo '<link rel="stylesheet" href="public/style/register/loginForm.css">';
?>

<div class="login-container d-flex flex-column justify-content-center align-items-center">
    <h1>MIAOH LOGIN</h1>
    <img src="<?php echo IMAGE_PATH; ?>logo/logo.png" alt="Logo">

    <?php if (isset($error_message)): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <form action="?action=login&subAction=auth-login" method="POST" class="w-100">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <div class="mt-3">
        Non hai un profilo? <a href="?action=login&subAction=register" class="signup-link">Registrati</a>
    </div>
    <a href='?action=home' class="btn btn-secondary mt-3">Torna alla home</a>
</div>
