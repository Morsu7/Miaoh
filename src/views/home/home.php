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
        <div class="carousel-item active">
            <img src="<?php echo IMAGE_PATH . 'productimages/' . $trending_products[0]->getId() . '.' . $trending_products[0]->getImg1()?>" class="d-block w-100" alt="<?php echo $trending_products[0]->getNome()?>">
            <div class="carousel-caption transparent-white d-md-block">
                <h5><?php echo $trending_products[0]->getNome()?></h5>
            </div>
        </div>
        <?php for($i=1; $i<count($trending_products); $i++){ ?>
        <div class="carousel-item">
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
            ?>
            <article class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <!-- Modulo per l'immagine -->
                    <form action="?action=product" method="POST" class="d-block" id="product-form-<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                        
                        <!-- Immagine cliccabile -->
                        <img src="public/assets/images/productimages/<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>.<?php echo htmlspecialchars($product->getImg1(), ENT_QUOTES, 'UTF-8'); ?>" 
                             class="card-img-top product-image img-fluid" 
                             alt="<?php echo htmlspecialchars($product->getNome(), ENT_QUOTES, 'UTF-8'); ?>" 
                             style="cursor: pointer;" onclick="submitForm(<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>)">
                    </form>
                    
                    <div class="card-body">
                        <!-- Modulo per il titolo -->
                        <form action="?action=product" method="POST" class="d-block">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                            
                            <!-- Bottone stile titolo -->
                            <button type="submit" class="btn p-0 border-0 bg-transparent text-decoration-none d-block">
                                <h3 class="card-title text-dark"><?php echo htmlspecialchars($product->getNome(), ENT_QUOTES, 'UTF-8'); ?></h3>
                            </button>
                        </form>
                        
                        <p class="card-text"><?php echo htmlspecialchars($product->getDescrizione(), ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="card-text">€<?php echo number_format($product->getPrezzo(), 2, ',', '.'); ?></p>
                        <a href="#" class="btn btn-primary interaction cart add-to-cart-btn" data-id="<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>">
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