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
                            <img src="' . htmlspecialchars($product->getImg1()) . '" class="card-img-top" alt="' . htmlspecialchars($product->getNome()) . '">
                            <div class="card-body">
                                <h3 class="card-title">' . htmlspecialchars($product->getNome()) . '</h3>
                                <p class="card-text">' . htmlspecialchars($product->getDescrizione()) . '</p>
                                <p class="card-text">€' . number_format($product->getPrezzo(), 2, ',', '.') . '</p>
                                <a href="#" class="btn btn-primary interaction cart" data-id="' . htmlspecialchars($product->getId()) . '">Aggiungi al carrello</a>
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
                            <img src="' . htmlspecialchars($product->getImg1()) . '" class="card-img-top" alt="' . htmlspecialchars($product->getNome()) . '">
                            <div class="card-body">
                                <h3 class="card-title">' . htmlspecialchars($product->getNome()) . '</h3>
                                <p class="card-text">' . htmlspecialchars($product->getDescrizione()) . '</p>
                                <p class="card-text">€' . number_format($product->getPrezzo(), 2, ',', '.') . '</p>
                                <a href="#" class="btn btn-primary interaction cart" data-id="' . htmlspecialchars($product->getId()) . '">Aggiungi al carrello</a>
                            </div>
                        </div>
                    </article>';
            }
            ?>
        </div>
    </div>
</section>
