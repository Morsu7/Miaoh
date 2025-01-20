<link rel="stylesheet" href="public/style/home.css">


<section class="hero text-center py-5 bg-light">
    <div class="container">
        <h2>Scopri le nostre offerte speciali!</h2>
        <p>Acquista i migliori prodotti ai prezzi più convenienti.</p>
        <a href="#" class="btn btn-primary">Scopri di più</a>
    </div>
</section>

<?php if(count($trending_products) > 0){ ?>
<h2 class="text-center mb-4">Prodotti in evidenza</h2>
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-theme="dark" >
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <?php for($i=1; $i<count($trending_products); $i++){ ?>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $i ?>" aria-label="Slide <?php echo $i+1 ?>"></button>
        <?php } ?>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active ask-detail-btn"  data-id="<?php echo $trending_products[0]->getId()?>">
            <img src="<?php echo IMAGE_PATH . 'productimages/' . $trending_products[0]->getId() . '.' . $trending_products[0]->getImg1()?>" class="d-block w-100" alt="<?php echo $trending_products[0]->getNome()?>">
            <div class="carousel-caption transparent-white d-md-block">
                <h5><?php echo $trending_products[0]->getNome()?></h5>
            </div>
        </div>
        <?php for($i=1; $i<count($trending_products); $i++){ ?>
        <div class="carousel-item ask-detail-btn"  data-id="<?php echo $trending_products[$i]->getId()?>">
            <img src="<?php echo IMAGE_PATH . 'productimages/' . $trending_products[$i]->getId() . '.' . $trending_products[$i]->getImg1()?>" class="d-block w-100" alt="<?php echo $trending_products[$i]->getNome()?>">
            <div class="carousel-caption transparent-white d-md-block">
                <h5><?php echo $trending_products[$i]->getNome()?></h5>
            </div>
        </div>
        <?php } ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<?php } ?>

<section class="search-bar py-4">
    <div class="container">
        <input 
            type="text" 
            id="search-input" 
            class="form-control" 
            placeholder="Cerca prodotti..." 
            autocomplete="off">
        <ul id="search-suggestions" class="list-group mt-2" style="display: none;"></ul>
    </div>
</section>


<section class="products py-5">
    <div class="container">
        <h2 class="text-center mb-4">I nostri prodotti</h2>

        <div class="row">
            <?php
            // Ciclo attraverso i prodotti
            foreach ($products as $index => $product) {
                // Se sono 2 prodotti nella stessa riga
                if ($index % 3 == 0 && $index > 0) {
                    echo '</div><div class="row">'; // Chiudi la riga precedente e ne apri una nuova
                }
                if(new DateTime($product->getFineSconto()) > new DateTime('today')){
                    $sconto = true;
                    $price = $product->getPrezzo()*(100-$product->getSconto())/100;
                }else{  
                    $sconto = false;
                    $price = $product->getPrezzo();
                }
                $price = round($price,2);
            ?>
            <article class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <div class="card h-100 ask-detail-btn" data-id="<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8')?>">
                    <!-- Immagine cliccabile -->
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
                        <a class="btn btn-primary interaction cart add-to-cart-btn" data-id="<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                            Aggiungi al carrello
                        </a>
                    </div>
                </div>
            </article>
            <?php
            }
            ?>
        </div>
    </div>
</section>



<script src="public/script/home.js"></script>