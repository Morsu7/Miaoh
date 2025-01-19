<?php
    require_once "../src/models/users/User.php";
    require_once "../src/models/users/Users.php";
    require_once "../src/models/products/Product.php";
    require_once "../src/models/products/ProductsManager.php";

    $user = Users::fromEmail($_SESSION['email']);
    $items = ProductsManager::ListFromUserCart($user->getId());
?>

<?php   $total = 0; ?>
<section class="container mt-5">
    <?php if(count($items) > 0):  ?>
    <!-- Sezione dei prodotti nel carrello -->
    <div class="row">
        <?php foreach($items as $product): 
        if(new DateTime($product['prodotto']->getFineSconto()) > new DateTime('today')){
            $sconto = true;
            $price = $product['prodotto']->getPrezzo()*(100-$product['prodotto']->getSconto())/100;
        }else{  
            $sconto = false;
            $price = $product['prodotto']->getPrezzo();
        }

        $price = round($price,2);
        $total += $price*$product['quantita'];
        ?>

        <div class="col-md-4 mb-4" id="card-<?php echo $product['prodotto']->getId();?>">
            <div class="card">
                <img src="<?php echo ImageManager::getProductImagePath($product['prodotto']->getId()); ?>" class="card-img-top product-image" alt="<?php echo $product['prodotto']->getId();?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $product['prodotto']->getNome();?></h5>
                    <p class="card-text">Prezzo unitario: 
                    <?php if($sconto): ?>
                        <span class="text-decoration-line-through text-muted"><?php echo $product['prodotto']->getPrezzo()?></span>
                    <?php endif; ?>
                        €<span id="price-<?php echo $product['prodotto']->getId();?>"><?php echo $price?></span>
                    </p>
                    
                    <div class="mb-3">
                        <label for="<?php echo $product['prodotto']->getId();?>" class="form-label">Quantità</label>
                        <div class="input-group">
                            <!-- Pulsante per decrementare -->
                            <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity('<?php echo $product['prodotto']->getId();?>')">-</button>

                            <!-- Campo input per la quantità -->
                            <input type="number" id="<?php echo $product['prodotto']->getId();?>" class="form-control text-center quantity-input"value="<?php echo $product['quantita'];?>">

                            <!-- Pulsante per incrementare -->
                            <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity('<?php echo $product['prodotto']->getId();?>')">+</button>
                        </div>
                    </div>
                    <p class="card-text">Totale: €<span class="total-item" id="total-<?php echo$product['prodotto']->getId(); ?>"><?php echo $price*$product['quantita'];?></span></p>
                    <button class="btn btn-danger btn-sm delete-item" data-bs-toggle="modal" data-bs-target="#confirmModal" data-item-id="<?php echo $product['prodotto']->getId();?>">Rimuovi</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <!-- Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Rimuovere l'elemento dal carrello?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="button" class="btn btn-danger confirm-delete">Rimuovi</button>
                </div>
                </div>
            </div>
        </div>
    </div>

    <?php $shippingCost = ($total < 25) ? 5 : 0;?>
    <!-- Totale del carrello -->
    <section class="d-flex justify-content-between align-items-center">
        <h4>Totale</h4>
        <h4 id="totalPrice"><?php echo "€" . $total;?></h4>
    </section>

    <!-- Voce per le spese di spedizione -->
    <section class="d-flex justify-content-between align-items-center">
        <h4>Spedizione</h4>
        <h4 id="shippingCost"><?php echo "€" . $shippingCost; ?></h4>
    </section>

    <!-- Totale con spedizione -->
    <section class="d-flex justify-content-between align-items-center">
        <h4>Totale con Spedizione</h4>
        <h4 id="totalWithShipping"><?php echo "€" . $total+$shippingCost;?></h4>
    </section>

    <?php else: ?>
        <p>Il tuo carrello è vuoto.</p>
    <?php endif; ?>

    <!-- Azioni -->
    <footer class="mt-4 d-flex justify-content-between">
        <a href="index.html" class="btn btn-secondary">Continua lo shopping</a>
        <a href="checkout.html" class="btn btn-primary">Procedi al checkout</a>
    </footer>
</section>

<script src="public/script/carrello.js"></script>