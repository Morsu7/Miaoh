<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miaoh</title>
    <link rel="icon" href="<?php echo IMAGE_PATH; ?>icons/favicon.ico" type="image/x-icon">

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="public/style/bootstrap.min.css">

    <link rel="stylesheet" href="public/style/template.css">
    <link rel="stylesheet" href="public/style/common.css">
</head>
<body>
    <!-- Include Bootstrap JS -->
    <script src="public/script/bootstrap.bundle.min.js"></script>
    <?php if($show_header)  include('header.php'); ?>

    <main class="container mt-4">
        <?php include($content); ?>
    </main>
    <footer class="bg-light text-center py-3 mt-4">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Your Company</p>
        </div>
    </footer>
    <script src="public/script/interazioni.js"></script>
</body>
</html>