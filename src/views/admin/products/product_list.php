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