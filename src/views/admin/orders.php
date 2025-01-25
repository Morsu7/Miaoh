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
                        <a href="?action=adminpage&subAction=products" class="nav-link text-dark">Gestione Prodotti</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-dark active">Gestione Ordini</a>
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
                            <a class="nav-link" href="?action=adminpage&subAction=products">Gestione Prodotti</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Gestione Ordini</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Contenuto principale -->
        <main class="col-md-10 main-content">
            <!-- Filtro per stato e barra di ricerca per ID ordine -->
            <div class="row my-4">
                <div class="col-12 col-md-6">
                    <form id="orderFilterForm" method="GET" class="d-flex">
                        <input type="hidden" name="action" value="adminpage">
                        <input type="hidden" name="subAction" value="orders">
                        <!-- Barra di ricerca per ID ordine -->
                        <input type="text" class="form-control me-2" name="search_id" placeholder="Cerca per ID ordine" value="<?= isset($_GET['search_id']) ? htmlspecialchars($_GET['search_id']) : '' ?>">
                        <!-- Filtro per stato ordine -->
                        <select name="filter_status" class="form-select me-2">
                            <option value="">Filtra per stato</option>
                            <option value="da_spedire" <?= isset($_GET['filter_status']) && $_GET['filter_status'] == 'da_spedire' ? 'selected' : '' ?>>Da Spedire</option>
                            <option value="spedito" <?= isset($_GET['filter_status']) && $_GET['filter_status'] == 'spedito' ? 'selected' : '' ?>>Spedito</option>
                            <option value="consegnato" <?= isset($_GET['filter_status']) && $_GET['filter_status'] == 'consegnato' ? 'selected' : '' ?>>Consegnato</option>
                        </select>
                        <!-- Bottone di invio -->
                        <button type="submit" class="btn btn-primary">Filtra</button>
                    </form>
                </div>
            </div>
            
            <!-- Lista ordini -->
            <div class="row mt-4">
                <?php foreach ($allOrders as $order): ?>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card" data-id_acquisto="<?= htmlspecialchars($order->getIdAcquisto()) ?>">
                        <div class="card-body">
                            <h5 class="card-title">ID Acquisto: <?= htmlspecialchars($order->getIdAcquisto()) ?></h5>
                            <p class="card-text">Timestamp: <?= htmlspecialchars($order->getTimestamp()) ?></p>
                            <p class="card-text">Stato Acquisto: <strong class="stato-acquisto"><?= $order->getStatoAcquistoFormatted() ?></strong></p>
                            <p class="card-text">Spesa: € <?= htmlspecialchars(number_format($order->getSpesa(), 2)) ?></p>
                        </div>
                        <div class="card-footer">
                            <div class="text-center">
                                <?php if ($order->getStatoAcquisto() != 'consegnato'): ?>
                                <form class="d-flex flex-column flex-md-row align-items-center update-order-status-form">
                                    <input type="hidden" name="id_acquisto" value="<?php echo $order->getIdAcquisto(); ?>">
                                    <select name="stato_acquisto" class="form-select w-100 w-md-auto me-md-2 mb-2 mb-md-0">
                                        <option value="da_spedire" <?php echo $order->getStatoAcquisto() == 'da_spedire' ? 'selected' : ''; ?>>Da Spedire</option>
                                        <option value="spedito" <?php echo $order->getStatoAcquisto() == 'spedito' ? 'selected' : ''; ?>>Spedito</option>
                                        <option value="consegnato" <?php echo $order->getStatoAcquisto() == 'consegnato' ? 'selected' : ''; ?>>Consegnato</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary w-100 w-md-auto">Cambia stato</button>
                                </form>
                                <?php else: ?>
                                <button class="btn btn-secondary mt-2 w-100" disabled>Consegnato</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
                                
            <!-- Paginazione -->
            <nav aria-label="Paginazione prodotti">
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?action=adminpage&subAction=orders&page=<?= $currentPage - 1 ?>&search_id=<?= urlencode($searchId) ?>&filter_status=<?= urlencode($filterStatus) ?>" aria-label="Precedente">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="?action=adminpage&subAction=orders&page=<?= $i ?>&search_id=<?= urlencode($searchId) ?>&filter_status=<?= urlencode($filterStatus) ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?action=adminpage&subAction=orders&page=<?= $currentPage + 1 ?>&search_id=<?= urlencode($searchId) ?>&filter_status=<?= urlencode($filterStatus) ?>" aria-label="Successivo">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </main>
    </div>
</div>

<script src="public/script/admin/manage_orders.js"></script>
