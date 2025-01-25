<link rel="stylesheet" href="public/style/admin/admin.css">

<!-- TODO: Mettere ricerca e sistemare modifica -->

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
                        <input type="text" class="form-control search-input" placeholder="Cerca prodotto..." />
                    </div>
                </div>   
            
                <div class="row product-list">
                    <!-- Card per ogni prodotto -->
                    <?php foreach ($allProducts as $product): ?>
                    <div class="col-12 mb-4">
                        <div class="card shadow-sm single-product d-flex flex-row w-100" data-id="<?= $product->getId() ?>">
                            <img src="public/assets/images/productimages/<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>.<?php echo htmlspecialchars($product->getImg1(), ENT_QUOTES, 'UTF-8'); ?>" class="card-img-left img-fluid" alt="Immagine prodotto" style="max-width: 150px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($product->getNome()) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($product->getDescrizione()) ?></p>
                                <p class="card-text">
                                    <strong>Prezzo: </strong>€<?= number_format($product->getPrezzo(), 2) ?>
                                </p>
                                <p class="card-text">
                                    <strong>Sconto: </strong><?= $product->getSconto() ?>%
                                </p>
                                <p class="card-text">
                                    <strong>Prezzo Scontato: </strong>€<?= number_format($product->getPrezzoScontato(), 2) ?>
                                </p>
                                <p class="card-text">
                                    <strong>Quantità: </strong><?= $product->getQuantita() ?>
                                </p>
                                <div class="mt-auto">
                                    <button class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editProductModal" 
                                            data-id="<?= $product->getId() ?>"
                                            data-nome="<?= htmlspecialchars($product->getNome()) ?>"
                                            data-descrizione="<?= htmlspecialchars($product->getDescrizione()) ?>"
                                            data-prezzo="<?= $product->getPrezzo() ?>"
                                            data-sconto="<?= $product->getSconto() ?>"
                                            data-quantita="<?= $product->getQuantita() ?>">
                                        Modifica
                                    </button>
                                    <button class="btn btn-danger" onclick="deleteProduct(<?= $product->getId() ?>)">Elimina</button>
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
            <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel">Modifica Prodotto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data" class="edit-product-form">
                                <input type="hidden" id="editProductId" name="id">
                                <div class="mb-3">
                                    <label class="form-label">Nome Prodotto</label>
                                    <input type="text" class="form-control product-name" id="editProductName" name="nome" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Descrizione</label>
                                    <textarea class="form-control product-description" id="editProductDescription" name="descrizione" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Quantità</label>
                                    <input type="number" class="form-control product-quantity" id="editProductQuantity" name="quantita" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Prezzo</label>
                                    <input type="number" step="0.01" class="form-control product-price" id="editProductPrice" name="prezzo" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sconto (%)</label>
                                    <input type="number" step="0.01" class="form-control product-discount" id="editProductDiscount" name="sconto" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Fine Sconto</label>
                                    <input type="date" class="form-control product-enddiscount" id="editProductEndDiscount" name="fineSconto" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Immagine 1</label>
                                    <input type="file" class="form-control product-image" id="editProductImage" name="img1" accept="image/*" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Anteprima Immagine</label>
                                    <img class="img-fluid product-image-preview d-block" id="editProductImagePreview" style="max-height: 200px;" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tipo Prodotto</label>
                                    <input type="number" class="form-control product-type" id="editProductType" name="tipoProdottoId" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                    <button type="submit" class="btn btn-primary">Salva modifiche</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="public/script/admin/manage_products.js"></script>