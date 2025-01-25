<link rel="stylesheet" href="public/style/detail.css">
<link rel="stylesheet" href="public/style/offerte.css">

<div class="container mt-5">
    <!-- Sezione carosello con le card -->
    <section class="mt-5">
        <h3 class="text-center">Le nostre offerte</h3>
        <article class="mb-4 bg-light p-3 rounded">
            <h4 class="text-center">Ancora per poco tempo!</h4>
            <!-- Contenitore per il carosello -->
            <div class="d-flex justify-content-center align-items-center position-relative">
                <!-- Carosello di prodotti -->
                <div class="product-carousel d-flex flex-nowrap overflow-auto">
                    <?php foreach ($ending_sales as $ending_sale):
                        $product = $ending_sale['prodotto']; 
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
                            <span class="badge bg-primary position-absolute top-0 start-0 m-2">
                                -<?php echo $product->getSconto()?>%
                            </span>
                            <span class="badge bg-danger position-absolute" 
                                style="top: 2.5rem; left: 0.5rem;">
                                <?php echo $ending_sale['giorni_rimasti']?> gg
                            </span>
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
                                    €<span><?php echo $price?></span>
                                </p>
                                <a href="#" class="btn btn-primary add-to-cart-btn" data-id="<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                                    Aggiungi al carrello
                                </a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </article>
        <?php 
        $sales_counter = 0;
        foreach($sales as $sale): 
            if(count($offers[$sale])>3 || $sales_counter == 0):?>
        <article class="mb-4 bg-light p-3 rounded">
            <h4 class="text-center"><?php echo ($sales_counter == 0) ? "Le migliori offerte" : 'Sconti del ' . intval($sale) . '%'?>!</h4>
            <!-- Contenitore per il carosello -->
            <div class="d-flex justify-content-center align-items-center position-relative">

                <!-- Carosello di prodotti -->
                <div class="product-carousel d-flex flex-nowrap overflow-auto">
                    <?php foreach ($offers[$sale] as $product):
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
                            <span class="badge bg-primary position-absolute top-0 start-0 m-2">
                                -<?php echo $product->getSconto()?>%
                            </span>
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
                                    €<span><?php echo $price?></span>
                                </p>
                                <a href="#" class="btn btn-primary add-to-cart-btn" data-id="<?php echo htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                                    Aggiungi al carrello
                                </a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </article>
        <?php endif; $sales_counter++; endforeach; ?>
    </section>
</div>