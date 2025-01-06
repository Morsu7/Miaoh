<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIAOH</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="public/style/bootstrap.min.css">

    <link rel="stylesheet" href="public/style/template.css">
</head>
<body>
    <header class="bg-primary text-white p-3">
        <div class="container">
            <h1 class="display-4">MIAOH</h1>
            <nav class="navbar navbar-expand-lg navbar-dark">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/contact">Contact</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main class="container mt-4">
        <?php include($content); ?>
    </main>
    <footer class="bg-light text-center py-3 mt-4">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Your Company</p>
        </div>
    </footer>

    <!-- Include Bootstrap JS -->
    <script src="public/script/bootstrap.bundle.min.js"></script>
</body>
</html>