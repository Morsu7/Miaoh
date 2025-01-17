<?php
    echo '<link rel="stylesheet" href="public/style/register/loginForm.css">';
?>

<div class="login-container">
    <h1>MIAOH LOGIN</h1>
    <img src="<?php echo IMAGE_PATH; ?>logo/logo.png" alt="Logo">

    <?php if (isset($error_message)): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <form action="?action=login&subAction=auth-login" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <a href="#" class="forgot-password">Forgot Password?</a>
        <button type="submit">Login</button>
    </form>
    Create an account - <a href="?action=login&subAction=register" class="signup-link">Sign up</a>
</div>