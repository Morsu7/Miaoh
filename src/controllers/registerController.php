<?php

require_once "../src/models/auth/AuthService.php";
require_once "../src/models/users/User.php";
require_once "../src/models/users/Users.php";
require_once "../src/models/images/ImageManager.php";


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
                $_SESSION['email'] = $_POST['email'];

                if (Users::isAdmin($_POST['email'])) {
                    $_SESSION['isAdmin'] = "e[9B0a,z6Qq+i7?4RECT*Kz]wz17#0";
                }
                header('Location: ?#');
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
        if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['username']) && !empty($_POST['name']) && !empty($_POST['surname'])){
            $email = $_POST['email'];
            $result = AuthService::auth_register($email, $_POST['password'], $_POST['username']);

            if($result == 'success'){
                $_SESSION['email'] = $email;
                
                // Registrazione avvenuta con successo
                if(isset($_FILES['image'])){
                    // Viene anche aggiunta la foto profilo, se valida
                    if(ImageManager::saveProfileImage($email, $_FILES['image']))
                        Users::updateImage($email, $_FILES['image']);   // Aggiorna l'estensione nel db se il salvataggio è andato a buon fine
                }

                Users::updateName($email, $_POST['name']);
                Users::updateSurname($email, $_POST['surname']);

                header('Location: ?#');
                exit;
            }else{
                if($result == 'email_already_exists')
                    $error_message = 'L\'email inserita risulta già presente all\'interno del sito';
                if($result == 'username_already_exists')
                    $error_message = 'L\'username inserito risulta già occupato da un altro utente';
            }
        }else{
            // form manipolato
            $error_message = 'Inserisci tutti i dati richiesti.';
        }

        $content = '../src/views/register/registerForm.php';
        break;
}

?>