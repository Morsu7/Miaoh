<div class="container mt-5">
    <!-- Card del prodotto -->
    <section class="product-details">
        <div class="row">
            <!-- Colonna sinistra per immagine principale -->
            <div class="col-md-6">

                <img src="<?php echo ImageManager::getProductImagePath($product->getId()); ?>" class="img-fluid product-image" alt="<?php echo $product->getNome(); ?>">

                <?php if ($product->getImg2()): ?>
                    <img src="<?= htmlspecialchars($product->getImg2()) ?>" class="img-fluid mt-3" alt="Seconda immagine prodotto">
                <?php endif; ?>
            </div>

            <!-- Colonna destra per dettagli prodotto -->
            <div class="col-md-6">
                <h2><?= htmlspecialchars($product->getNome()) ?></h2>
                <p><strong>Descrizione:</strong> <?= nl2br(htmlspecialchars($product->getDescrizione())) ?></p>
                <p><strong>Prezzo:</strong> <?= number_format($product->getPrezzo(), 2, ',', '.') ?> EUR</p>

                <!-- Prezzo scontato se valido -->
                <?php if ($product->isScontoValido()): ?>
                    <p><strong>Sconto:</strong> <?= $product->getSconto() ?>%</p>
                    <p><strong>Prezzo Scontato:</strong> <?= number_format($product->calcolaPrezzoScontato(), 2, ',', '.') ?> EUR</p>
                    <p><small>Offerta valida fino al: <?= $product->getFineSconto() ?></small></p>
                <?php else: ?>
                    <p><strong>Sconto non valido</strong></p>
                <?php endif; ?>

                <p><strong>Quantità Disponibile:</strong> <?= $product->getQuantita() ?></p>

                <!-- Bottone di acquisto -->
                <button class="btn btn-primary mt-3">Aggiungi al carrello</button>
            </div>
        </div>

        <!-- Sezione tipo prodotto -->
        <footer class="mt-5">
            <p><strong>Tipo di Prodotto:</strong> <?= htmlspecialchars($product->getTipoProdottoId()) ?></p>
        </footer>
    </section>
</div>
