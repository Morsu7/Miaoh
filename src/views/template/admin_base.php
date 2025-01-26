<?php
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== "e[9B0a,z6Qq+i7?4RECT*Kz]wz17#0") {
    header('Location: ?#');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miaoh</title>
    <link rel="icon" href="<?php echo IMAGE_PATH; ?>icons/favicon.ico" type="image/x-icon">

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="public/style/bootstrap.min.css">

    <!-- <link rel="stylesheet" href="public/style/template.css"> -->
    <link rel="stylesheet" href="public/style/common.css">
</head>
<body>
    <!-- Include Bootstrap JS -->
    <script src="public/script/bootstrap.bundle.min.js"></script>
    <?php if($show_header)  include('header.php'); ?>

    <!-- Modal delle Notifiche -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">Notifica</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Messaggio dinamico -->
                    <span id="modalMessage">Messaggio di errore o successo</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <?php include($content); ?>
    <!-- <footer class="bg-light text-center py-3">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Your Company</p>
        </div>
    </footer> -->
    <script src="public/script/interazioni.js"></script>
</body>
</html>