<link rel="stylesheet" href="public/style/detail.css">

<div class="container mt-5">
    <!-- Card del prodotto -->
    <section class="product-details">
        <input type="hidden" name="idMainProduct" value="<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>">
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
                    <p><strong>Prezzo Scontato:</strong> <span class="sconto"><?= number_format($product->getPrezzoScontato(), 2, ',', '.') ?> EUR</span></p>
                    <p><small>Offerta valida fino al: <?= $product->getFineSconto() ?></small></p>
                <?php else: ?>
                    <p><strong>Sconto non valido</strong></p>
                <?php endif; ?>

                <p><strong>Quantità Disponibile:</strong> <?= $product->getQuantita() ?></p>

                <!-- Bottone di acquisto -->
                <button class="btn btn-primary mt-3 add-to-cart-btn" data-id="<?= $product->getId() ?>">Aggiungi al carrello</button>
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
                <?php foreach ($products as $product): 
                    if(new DateTime($product->getFineSconto()) > new DateTime('today')){
                        $sconto = true;
                        $price = $product->getPrezzo()*(100-$product->getSconto())/100;
                    }else{  
                        $sconto = false;
                        $price = $product->getPrezzo();
                    }
                    $price = round($price,2);
                    ?>
                    <!-- Card del prodotto -->
                    <div class="card h-100 ask-detail-btn" data-id="<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>" style="width: 18rem; margin-right: 20px;">
                        <img src="public/assets/images/productimages/<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>.<?php echo htmlspecialchars($product->getImg1(), ENT_QUOTES, 'UTF-8'); ?>" 
                                class="card-img-top product-image img-fluid" 
                                alt="<?php echo htmlspecialchars($product->getNome(), ENT_QUOTES, 'UTF-8'); ?>" 
                                style="cursor: pointer;">                        
                        <div class="card-body">
                            <h3 class="card-title text-dark"><?php echo htmlspecialchars($product->getNome(), ENT_QUOTES, 'UTF-8'); ?></h3>
                            
                            <p class="card-text"><?php echo htmlspecialchars($product->getDescrizione(), ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="card-text">Prezzo: 
                            <?php if($sconto): ?>
                                €<span class="text-decoration-line-through text-muted"><?php echo $product->getPrezzo()?></span>
                            <?php endif; ?>
                                €<span id="price-<?php echo $product->getId();?>"><?php echo $price?></span>
                            </p>
                            <a href="#" class="btn btn-primary add-to-cart-btn" data-id="<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>">
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

    <section class="mt-5">
        <div class="reviews-section">
            <!-- Colonna sinistra: Contenitore delle recensioni -->
            <div class="left-column" id="reviews-container">
                <h4>Recensioni</h4>
                <!-- Le recensioni saranno caricate dinamicamente qui -->
            </div>

            <!-- Colonna destra: Modulo per aggiungere una nuova recensione -->
            <div class="right-column">
                <h5>Aggiungi una Recensione</h5>
                <form class="add-review-form">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Valutazione (1-5)</label>
                        <select id="rating" name="rating" class="form-select">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="review-description" class="form-label">Recensione</label>
                        <textarea id="review-description" name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="button" class="btn btn-primary send-review">Invia Recensione</button>
                </form>
            </div>
        </div>
    </section>

</div>

<script src="public/script/detail.js"></script>
