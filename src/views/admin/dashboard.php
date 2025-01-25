<link rel="stylesheet" href="public/style/admin/admin.css">

<!-- TODO: Decidere quali dati mostrare -->
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
                    <div class="col-md-4 mb-4">
                        <div class="card p-3">
                            <h6>Esami passati</h6>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar" style="width: 75%;"></div>
                            </div>
                            <small class="text-muted">75%</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card p-3">
                            <h6>Events</h6>
                            <img src="https://via.placeholder.com/100x50" alt="Graph" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card p-3">
                            <h6>Device Stats</h6>
                            <div class="progress mb-2" style="height: 10px;">
                                <div class="progress-bar" style="width: 60%;"></div>
                            </div>
                            <small class="text-muted">Memory Space: 60%</small>
                        </div>
                    </div>
                </div>
                <!-- Grafici -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card p-3">
                            <h6>Analytics</h6>
                            <ul class="list-unstyled">
                                <li>Prodotti in magazzino: 22,370</li>
                                <li>Utenti registrati: 2,456</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>