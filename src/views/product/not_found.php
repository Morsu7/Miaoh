<link rel="stylesheet" href="public/style/detail.css">

<section class="product-details">
    <h1>Il prodotto richiesto non è stato trovato!</h1>
    <h5>Visualizza nostri altri prodotti che potrebbero interessarti.</h5>
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
                    <!-- Card del prodotto -->
                    <div class="card h-100 ask-detail-btn" data-id="<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>" style="width: 18rem; margin-right: 20px;">
                        <img src="public/assets/images/productimages/<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>.<?php echo htmlspecialchars($product->getImg1(), ENT_QUOTES, 'UTF-8'); ?>" 
                                class="card-img-top product-image img-fluid" 
                                alt="<?php echo htmlspecialchars($product->getNome(), ENT_QUOTES, 'UTF-8'); ?>" 
                                style="cursor: pointer;">                        
                        <div class="card-body">
                            <h3 class="card-title text-dark"><?php echo htmlspecialchars($product->getNome(), ENT_QUOTES, 'UTF-8'); ?></h3>
                            
                            <p class="card-text"><?php echo htmlspecialchars($product->getDescrizione(), ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="card-text">€<?php echo number_format($product->getPrezzo(), 2, ',', '.'); ?></p>
                            <a class="btn btn-primary add-to-cart-btn" data-id="<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                                Aggiungi al carrello
                            </a>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

            <!-- Freccia successiva -->
            <button class="btn carousel-control-next position-absolute" id="nextBtn" style="right: -25px;">→</button>
        </div>
    </section>