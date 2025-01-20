<link rel="stylesheet" href="public/style/admin/admin.css">

<div class="container-fluid">
    <div class="row">
        <!-- Barra laterale -->
        <aside class="col-md-2 sidebar collapse d-md-block" id="sidebarMenu">
            <nav>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="?action=adminpage&subAction=dashboard" class="nav-link text-dark">Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-dark active">Gestione Prodotti</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Contenuto principale -->
        <main class="col-md-10 ms-sm-auto col-lg-10 main-content">
            <!-- <header class="d-flex justify-content-between align-items-center p-3 mb-4 border-bottom">
                <button class="btn btn-outline-primary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span> Menu
                </button>
            </header> -->

            

            <section class="container py-4">
                <!-- Barra di ricerca -->
                <div class="mb-4 search-bar">
                    <input type="text" class="form-control search-input" placeholder="Cerca prodotto..." />
                </div>    
            
                <div class="row product-list">
                    <!-- Card per ogni prodotto -->
                    <?php foreach ($allProducts as $product): ?>
                    <div class="single-product-container col-md-4 mb-4">
                        <div class="card shadow-sm single-product" data-id="<?= $product->getId() ?>">
                            <img src="<?= $product->getImg1() ?>" class="card-img-top" alt="Immagine prodotto">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product->getNome()) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($product->getDescrizione()) ?></p>
                                <p class="card-text">
                                    <strong>Prezzo: </strong>€<?= number_format($product->getPrezzo(), 2) ?>
                                </p>
                                <p class="card-text">
                                    <strong>Sconto: </strong><?= $product->getSconto() ?>%
                                </p>
                                <p class="card-text">
                                    <strong>Prezzo Scontato: </strong>€<?= number_format($product->calcolaPrezzoScontato(), 2) ?>
                                </p>
                                <p class="card-text">
                                    <strong>Quantità: </strong><?= $product->getQuantita() ?>
                                </p>
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editProductModal" 
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
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Modal per aggiungere un prodotto -->
            <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModalLabel">Aggiungi Prodotto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="?action=addProduct">
                                <div class="mb-3">
                                    <label for="productName" class="form-label">Nome Prodotto</label>
                                    <input type="text" class="form-control" id="productName" name="nome" required>
                                </div>
                                <div class="mb-3">
                                    <label for="productDescription" class="form-label">Descrizione</label>
                                    <textarea class="form-control" id="productDescription" name="descrizione" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="productPrice" class="form-label">Prezzo</label>
                                    <input type="number" step="0.01" class="form-control" id="productPrice" name="prezzo" required>
                                </div>
                                <div class="mb-3">
                                    <label for="productDiscount" class="form-label">Sconto (%)</label>
                                    <input type="number" step="0.01" class="form-control" id="productDiscount" name="sconto" required>
                                </div>
                                <div class="mb-3">
                                    <label for="productQuantity" class="form-label">Quantità</label>
                                    <input type="number" class="form-control" id="productQuantity" name="quantita" required>
                                </div>
                                <div class="mb-3">
                                    <label for="productImage" class="form-label">Immagine 1</label>
                                    <input type="text" class="form-control" id="productImage" name="img1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="productImage2" class="form-label">Immagine 2 (opzionale)</label>
                                    <input type="text" class="form-control" id="productImage2" name="img2">
                                </div>
                                <div class="mb-3">
                                    <label for="productType" class="form-label">Tipo Prodotto</label>
                                    <input type="number" class="form-control" id="productType" name="tipoProdottoId" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                    <button type="submit" class="btn btn-primary">Salva</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal per modificare un prodotto -->
            <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel">Modifica Prodotto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="test" method="POST">
                                <input type="hidden" id="editProductId" name="id">
                                <div class="mb-3">
                                    <label for="editProductName" class="form-label">Nome Prodotto</label>
                                    <input type="text" class="form-control" id="editProductName" name="nome" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editProductDescription" class="form-label">Descrizione</label>
                                    <textarea class="form-control" id="editProductDescription" name="descrizione" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="editProductPrice" class="form-label">Prezzo</label>
                                    <input type="number" step="0.01" class="form-control" id="editProductPrice" name="prezzo" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editProductDiscount" class="form-label">Sconto (%)</label>
                                    <input type="number" step="0.01" class="form-control" id="editProductDiscount" name="sconto" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editProductQuantity" class="form-label">Quantità</label>
                                    <input type="number" class="form-control" id="editProductQuantity" name="quantita" required>
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