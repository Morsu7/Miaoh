<?php
    require_once "../src/models/images/ImageManager.php";
?>
<div class="checkout-container">
    <h1>Checkout</h1>
    <div class="product-list">
        <h2>Prodotti nel carrello</h2>
        <ul style="padding-left: 0;">
            <?php foreach ($products as $product): ?>
            <li style="display: flex; justify-content: space-between; align-items: flex-end; list-style: none;">
            <span>x<?php echo htmlspecialchars($product['quantita'])?> <?php echo htmlspecialchars($product['prodotto']->getNome()); ?></span>
            <span style="flex-grow: 1; border-bottom: 2px dotted; margin: 0 5px;"></span>
            <span>€<?php echo htmlspecialchars($product['quantita']*$product['prodotto']->getPrezzoScontato())?></span>
            </li>
            <?php endforeach; ?>
            <?php ($totalPrice > 25) ? $spedizione = 0 : $spedizione = 5 ?>
            <li style="display: flex; justify-content: space-between; align-items: flex-end; list-style: none;">
            <span>Spedizione</span>
            <span style="flex-grow: 1; border-bottom: 2px dotted; margin: 0 5px;"></span>
            <span>€<?php echo $spedizione?></span>
            </li>
        </ul>
    </div>
    <div class="total-price">
        <h3>Costo totale complessivo: €<?php echo htmlspecialchars($totalPrice+$spedizione); ?></h3>
    </div>
    <div class="personal-info card mt-4">
        <div class="card-header">
            <h2>Personal Information</h2>
        </div>
        <div class="card-body">
            <div style="display: flex; align-items: center;">
                <img class="user-img" src="<?php echo ImageManager::getUserImagePath($user->getEmail()); ?>" alt="Profile Picture" style="width: 100px; height: 100px; border-radius: 50%; margin-right: 20px;">
                <div style="flex-grow: 1;">
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Nome:</strong></div>
                        <div class="col-sm-9"><?php echo htmlspecialchars($user->getName()); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Cognome:</strong></div>
                        <div class="col-sm-9"><?php echo htmlspecialchars($user->getSurname()); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Email:</strong></div>
                        <div class="col-sm-9"><?php echo htmlspecialchars($user->getEmail()); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Username:</strong></div>
                        <div class="col-sm-9"><?php echo htmlspecialchars($user->getUsername()); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary confirm-checkout-btn mt-3">Conferma pagamento</button>

    <!-- Modal Structure -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="confirmationModalLabel">Conferma dell'acquisto</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Confermi di voler procedere con l'acquisto dei prodotti selezionati?</h5>
                    <p style="margin-bottom: 0px;">Il saldo verrà addebitato automaticamente sul tuo conto.</p>
                    <p>Sarà possibile seguire il tracking della spedizione verso: <?php echo SHIPPING_ADDRESS ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancella</button>
                    <button id="confirmAction" type="button" class="btn btn-primary">Conferma</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="public/script/checkout.js"></script>
