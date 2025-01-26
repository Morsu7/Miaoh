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
                    <button 
                        type="button" 
                        class="btn btn-primary" 
                        data-bs-toggle="modal" 
                        data-bs-target=".edit-product-modal" 
                        data-id="<?php echo $product->getId(); ?>" 
                        data-nome="<?php echo htmlspecialchars($product->getNome(), ENT_QUOTES, 'UTF-8'); ?>" 
                        data-descrizione="<?php echo htmlspecialchars($product->getDescrizione(), ENT_QUOTES, 'UTF-8'); ?>" 
                        data-prezzo="<?php echo $product->getPrezzo(); ?>" 
                        data-sconto="<?php echo $product->getSconto(); ?>" 
                        data-quantita="<?php echo $product->getQuantita(); ?>" 
                        data-finesconto="<?php echo $product->getFineSconto(); ?>" 
                        data-tipoprodottoid="<?php echo $product->getTipoProdottoId(); ?>" 
                        data-img1="<?php echo "public/assets/images/productimages/" . htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8') . "." . htmlspecialchars($product->getImg1(), ENT_QUOTES, 'UTF-8') ?>"
                    >
                        Modifica
                    </button>
                    <button class="btn btn-danger" onclick="deleteProduct(<?= $product->getId() ?>)">Elimina</button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>