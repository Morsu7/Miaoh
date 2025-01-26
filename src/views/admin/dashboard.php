<link rel="stylesheet" href="public/style/admin/admin.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar per Desktop -->
        <aside class="col-md-2 sidebar collapse d-md-block" id="sidebarMenu">
            <nav>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="index.php" class="btn btn-outline-primary text-dark">
                            Torna alla Homepage
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-dark active">Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="?action=adminpage&subAction=products" class="nav-link text-dark">Gestione Prodotti</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="?action=adminpage&subAction=orders" class="nav-link text-dark">Gestione Ordini</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Navbar Hamburger per Dispositivi Mobili -->
        <nav class="navbar navbar-expand-md navbar-light bg-light d-md-none">
            <div class="container-fluid">
                <!-- Bottone Hamburger -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavbar" aria-controls="mobileNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Contenuto Collassabile -->
                <div class="collapse navbar-collapse" id="mobileNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Torna alla Homepage</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=adminpage&subAction=products">Gestione Prodotti</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=adminpage&subAction=orders">Gestione Ordini</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Contenuto principale -->
        <main class="col-md-10 ms-sm-auto col-lg-10 main-content">
            <div class="container py-4">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card p-3 shadow-sm">
                            <h6 class="text-center" style="border-bottom: 1px solid #ddd; padding-bottom: 10px;">Totale Ordini: <?php echo $orders_total; ?></h6>

                            <div class="row mt-3 text-center"> <!-- Aggiunto text-center qui -->
                                <!-- Ordini da Consegnare -->
                                <div class="col-md-4">
                                    <h6>Ordini da Spedire</h6>
                                    <ul class="list-unstyled mt-3">
                                        <li><strong>In attesa:</strong> <?php echo $orders_pending; ?></li>
                                    </ul>
                                </div>

                                <!-- Ordini Spediti -->
                                <div class="col-md-4">
                                    <h6>Ordini Spediti</h6>
                                    <ul class="list-unstyled mt-3">
                                        <li><strong>Spediti:</strong> <?php echo $orders_shipped; ?></li>
                                    </ul>
                                </div>

                                <!-- Ordini Consegnati -->
                                <div class="col-md-4">
                                    <h6>Ordini Consegnati</h6>
                                    <ul class="list-unstyled mt-3">
                                        <li><strong>Consegnati:</strong> <?php echo $orders_delivered; ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Card Utenti Registrati -->
                    <div class="col-md-12 mb-4">
                        <div class="card p-3 shadow-sm">
                            <h6 class="text-center">Utenti Registrati:</h6>
                            <span class="text-center"><?php echo $users_registered; ?></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Card Grafico Acquisti -->
                    <div class="col-md-12 mb-4">
                        <div class="card p-3 shadow-sm">
                            <h5 class="text-center">Grafico degli Acquisti</h5>
                            <div class="card-body">
                                <canvas id="acquistiChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    var ctx = document.getElementById('acquistiChart').getContext('2d');
    
    var labels = <?php echo json_encode($labels); ?>; // Le date
    var data = <?php echo json_encode($data); ?>; // Il numero di acquisti
    
    var acquistiChart = new Chart(ctx, {
        type: 'line', // Tipo di grafico: lineare
        data: {
            labels: labels, // Le date
            datasets: [{
                label: 'Numero di Acquisti',
                data: data, // Dati degli acquisti (valori per le rispettive date)
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,  // Impostiamo la distanza tra i valori
                        callback: function(value) {
                            return value.toFixed(0); // Arrotonda a 0 decimali
                        }
                    }
                }
            }
        }
    });
</script>