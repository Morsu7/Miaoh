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
                <h2><?= htmlspecialchars($product->getNome()) ?></h5>
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

    <!-- Sezione carosello con le card -->
    <section class="mt-5">
        <h4>Altri Prodotti</h4>

        <!-- Contenitore per il carosello -->
        <div class="d-flex justify-content-center align-items-center position-relative">
            <!-- Freccia precedente -->
            <button class="btn carousel-control-prev position-absolute" id="prevBtn" style="left: -25px;">←</button>

            <!-- Carosello di prodotti -->
            <div class="product-carousel d-flex flex-nowrap overflow-auto">
                <?php foreach ($products as $product): ?>
                    <div class="card" style="width: 18rem; margin-right: 20px;">
                        <img src="<?= ImageManager::getProductImagePath($product->getId()); ?>" class="card-img-top" alt="<?= htmlspecialchars($product->getNome()) ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product->getNome()) ?></h5>
                            <p class="card-text"><?= number_format($product->getPrezzo(), 2, ',', '.') ?> EUR</p>
                            <a href="#" class="btn btn-primary btn-sm">Dettagli</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Freccia successiva -->
            <button class="btn carousel-control-next position-absolute" id="nextBtn" style="right: -25px;">→</button>
        </div>
    </section>
</div>

<!-- Aggiungi il CSS per la personalizzazione -->
<style>
    .product-carousel {
        display: flex;
        gap: 15px;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }

    .product-carousel .card {
        flex-shrink: 0;
        scroll-snap-align: start;
        width: 18rem;
    }

    /* Frecce minimali, senza aloni */
    .carousel-control-prev, .carousel-control-next {
        background-color: transparent;
        color: black;
        border: none;
        font-size: 2rem;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
    }

    /* Posizionamento delle frecce vicino al carosello */
    .carousel-control-prev {
        left: -30px;
    }

    .carousel-control-next {
        right: -30px;
    }

    /* Modifica le card per tablet e mobile */
    @media (max-width: 1024px) {
        .product-carousel .card {
            width: 45%;
        }
    }

    @media (max-width: 576px) {
        .product-carousel .card {
            width: 90%;
        }
    }
</style>

<!-- Aggiungi il JavaScript per la funzionalità dello scorrimento -->
<script>
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const productCarousel = document.querySelector(".product-carousel");

    prevBtn.addEventListener("click", () => {
        productCarousel.scrollBy({ left: -300, behavior: 'smooth' });
    });

    nextBtn.addEventListener("click", () => {
        productCarousel.scrollBy({ left: 300, behavior: 'smooth' });
    });

    productCarousel.addEventListener('touchstart', handleTouchStart, false);
    productCarousel.addEventListener('touchend', handleTouchEnd, false);
    let x1 = null;
    
    function handleTouchStart(e) {
        const firstTouch = e.touches[0];
        x1 = firstTouch.clientX;
    }

    function handleTouchEnd(e) {
        if (!x1) return;
        let x2 = e.changedTouches[0].clientX;
        let xDiff = x2 - x1;
        if (xDiff > 0) {
            prevBtn.click();
        } else {
            nextBtn.click();
        }
        x1 = null;
    }
</script>
