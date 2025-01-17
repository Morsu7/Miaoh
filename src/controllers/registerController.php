<?php

include "../src/models/auth/AuthService.php";

//Recuperare l'azione da svolgere
if (isset($_GET['subAction'])){
    $subAction = $_GET['subAction'];
} else {
    $subAction = 'login';
}

$show_header = false;

switch ($subAction) {
    case 'register':
        $content = '../src/views/register/registerForm.php';
        break;
    case 'login':
    default:
        $content = '../src/views/register/loginForm.php';
        break;
    case 'auth-login':
        if (!empty($_POST['email']) && !empty($_POST['password'])){
            $result = AuthService::auth_login($_POST['email'], $_POST['password']);

            if($result == 'success'){
                header('Location: /Miaoh/#');
                exit;
            }else{
                if($result == 'invalid_email')
                    $error_message = 'L\'email inserita non risulta presente all\'interno del sito';

                if($result == 'invalid_password')
                    $error_message = 'La password inserita non è corretta';
            }
        }else{
            // form manipolato
            $error_message = 'Inserisci email e password.';
        }

        $content = '../src/views/register/loginForm.php';
        break;
    case 'auth-register':
        if (!empty($_POST['email']) && !empty($_POST['password'])){
            $result = AuthService::auth_register($_POST['email'], $_POST['password']);

            if($result == 'success'){
                header('Location: /Miaoh/#');
                exit;
            }else{
                if($result == 'email_already_exists')
                    $error_message = 'L\'email inserita risulta già presente all\'interno del sito';
            }
        }else{
            // form manipolato
            $error_message = 'Inserisci email e password.';
        }

        $content = '../src/views/register/registerForm.php';
        break;
}

?>