<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Modal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        /* Overlay dello sfondo */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        /* Finestra del pop-up */
        .modal-content {
            position: relative;
            background: #ffffff;
            width: 90%;
            max-width: 400px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* Croce per chiudere */
        .close-modal {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #555;
            background: none;
            border: none;
            cursor: pointer;
        }

        .close-modal:hover {
            color: #000;
        }

        /* Stili del form */
        .modal-content input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .modal-content input:focus {
            border-color: #7e57c2;
            outline: none;
        }

        .modal-content .forgot-password {
            font-size: 14px;
            color: #7e57c2;
            text-decoration: none;
        }

        .modal-content .forgot-password:hover {
            text-decoration: underline;
        }

        .modal-content button {
            width: 100%;
            padding: 10px;
            background-color: #7e57c2;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #5e3a9e;
        }

        .modal-content .signup-link {
            font-size: 14px;
            color: #7e57c2;
            text-decoration: none;
        }

        .modal-content .signup-link:hover {
            text-decoration: underline;
        }

        /* Mostrare il pop-up */
        .modal-overlay.show {
            display: flex;
        }
    </style>
</head>
<body>
    <button onclick="openModal()">Apri Login</button>

    <!-- Overlay e pop-up -->
    <div class="modal-overlay" id="loginModal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeModal()">&times;</button>
            <h1>MIAOH</h1>
            <img src="cat-logo.png" alt="Logo">
            <form>
                <input type="text" placeholder="Username or Email" required>
                <input type="password" placeholder="Password" required>
                <a href="#" class="forgot-password">Forgot Password?</a>
                <button type="submit">Login</button>
            </form>
            <a href="#" class="signup-link">Sign Up</a>
        </div>
    </div>

    <script>
        // Funzione per aprire il pop-up
        function openModal() {
            document.getElementById('loginModal').classList.add('show');
        }

        // Funzione per chiudere il pop-up
        function closeModal() {
            document.getElementById('loginModal').classList.remove('show');
        }
    </script>
</body>
</html>
