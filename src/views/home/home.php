<link rel="stylesheet" href="public/style/home.css">

<section class="hero text-center py-5 bg-light">
    <div class="container">
        <h2>Scopri le nostre offerte speciali!</h2>
        <p>Acquista i migliori prodotti ai prezzi più convenienti.</p>
        <a href="#" class="btn btn-primary">Scopri di più</a>
    </div>
</section>

<section class="products py-5">
    <div class="container">
        <?php if(count($trending_products) > 0){ ?>
        <h2 class="text-center mb-4">Prodotti in evidenza</h2>
        <!-- Container for the image gallery -->
        <div class="container">

            <!-- Full-width images with number text -->
            <?php foreach($trending_products as $product){ ?>
                <div class="trending-slide">
                    <img src="<?php echo IMAGE_PATH . 'productimages/' . $product->getId() . '.' . $product->getImg1(); ?>" style="width:100%">
                </div>
            <?php } ?>

            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

            <!-- Image text -->
            <div class="caption-container">
                <p id="caption"></p>
            </div>

            <!-- Thumbnail images -->
            <div class="row">
                <?php $count = 1; foreach($trending_products as $product){ ?>
                    <div class="column">
                        <img  class="demo cursor"  src="<?php echo IMAGE_PATH . 'productimages/' . $product->getId() . '.' . $product->getImg1(); ?>" style="width:100%" onclick="currentSlide(<?php echo $count++; ?>)" alt="product-<?php echo $product->getId()?>"/>
                    </div>
                <?php } ?>
            </div>
        </div>
        
        <div class="row">
            <?php

            // Ciclo attraverso i prodotti
            foreach ($trending_products as $index => $product) {
                // Se sono 2 prodotti nella stessa riga
                if ($index % 2 == 0 && $index > 0) {
                    echo '</div><div class="row">'; // Chiudi la riga precedente e ne apri una nuova
                }

                // Stampa il prodotto
                echo '
                <article class="col-md-6 mb-4">
                    <div class="card">
                        <img src="public/assets/images/productImage/' . htmlspecialchars($product->getId()) . '.' . htmlspecialchars($product->getImg1()) . '" 
                            class="card-img-top product-image" 
                            alt="' . htmlspecialchars($product->getNome()) . '">
                        <div class="card-body">
                            <h3 class="card-title">' . htmlspecialchars($product->getNome()) . '</h3>
                            <p class="card-text">' . htmlspecialchars($product->getDescrizione()) . '</p>
                            <p class="card-text">€' . number_format($product->getPrezzo(), 2, ',', '.') . '</p>
                            <a href="#" class="btn btn-primary interaction cart" data-id="' . htmlspecialchars($product->getId()) . '">
                                Aggiungi al carrello
                            </a>
                        </div>
                    </div>
                </article>';
            }
            ?>
        </div>
        <?php } ?>

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
                        <img src="public/assets/images/productImage/' . htmlspecialchars($product->getId()) . '.' . htmlspecialchars($product->getImg1()) . '" 
                            class="card-img-top product-image" 
                            alt="' . htmlspecialchars($product->getNome()) . '">
                        <div class="card-body">
                            <h3 class="card-title">' . htmlspecialchars($product->getNome()) . '</h3>
                            <p class="card-text">' . htmlspecialchars($product->getDescrizione()) . '</p>
                            <p class="card-text">€' . number_format($product->getPrezzo(), 2, ',', '.') . '</p>
                            <a href="#" class="btn btn-primary interaction cart" data-id="' . htmlspecialchars($product->getId()) . '">
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