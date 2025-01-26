<link rel="stylesheet" href="public/style/admin/admin.css">

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
                        <a href="?action=adminpage&subAction=dashboard" class="nav-link text-dark">Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-dark active">Gestione Prodotti</a>
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
                            <a class="nav-link" href="?action=adminpage&subAction=dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Gestione Prodotti</a>
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
            <section class="container py-4">
                <!-- Barra di ricerca con pulsante Aggiungi Prodotto -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <!-- Pulsante Aggiungi Prodotto -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".add-product-modal">
                        + Aggiungi Prodotto
                    </button>

                    <!-- Barra di ricerca -->
                    <div class="search-bar flex-grow-1 ms-3">
                        <input type="text" class="form-control search-input" placeholder="Cerca prodotto..." id="liveSearchInput">
                    </div>
                </div>   
            
                <div id="loadingSpinner" style="display: none; text-align: center;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Caricamento...</span>
                    </div>
                </div>

                <?php include('products/product_list.php'); ?>

                <!-- Paginazione -->
                <nav aria-label="Paginazione prodotti">
                    <ul class="pagination justify-content-center">
                        <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?action=adminpage&subAction=products&page=<?= $currentPage - 1 ?>" aria-label="Precedente">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="?action=adminpage&subAction=products&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?action=adminpage&subAction=products&page=<?= $currentPage + 1 ?>" aria-label="Successivo">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </section>

            <!-- Modal per aggiungere un prodotto -->
            <?php include('products/addproduct.php'); ?>

            <!-- Modal per modificare un prodotto -->
            <?php include('products/edit_product.php'); ?>
        </main>
    </div>
</div>

<script src="public/script/admin/manage_products.js"></script>