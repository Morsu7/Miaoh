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
                if ($index % 2 == 0 && $index > 0) {
                    echo '</div><div class="row">'; // Chiudi la riga precedente e ne apri una nuova
                }

                // Stampa il prodotto
                echo '
                <article class="col-md-6 mb-4">
                    <div class="card">
                        <img src="public/assets/images/productimages/' . htmlspecialchars($product->getId()) . '.' . htmlspecialchars($product->getImg1()) . '" 
                            class="card-img-top product-image" 
                            alt="' . htmlspecialchars($product->getNome()) . '">
                        <div class="card-body">
                            <h3 class="card-title">' . htmlspecialchars($product->getNome()) . '</h3>
                            <p class="card-text">' . htmlspecialchars($product->getDescrizione()) . '</p>
                            <p class="card-text">€' . number_format($product->getPrezzo(), 2, ',', '.') . '</p>
                            <a href="#" class="btn btn-primary interaction cart add-to-cart-btn" data-id="' . htmlspecialchars($product->getId()) . '">
                                Aggiungi al carrello
                            </a>
                        </div>
                    </div>
                </article>';
            }
            ?>
        </div>
    </div>
</section>

<script src="public/script/home.js"></script>