<div class="modal fade add-product-modal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aggiungi Prodotto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" class="add-product-form">
                    <div class="mb-3">
                        <label class="form-label">Nome Prodotto</label>
                        <input type="text" class="form-control product-name" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrizione</label>
                        <textarea class="form-control product-description" name="descrizione" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantità</label>
                        <input type="number" class="form-control product-quantity" name="quantita" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prezzo</label>
                        <input type="number" step="0.01" class="form-control product-price" name="prezzo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sconto (%)</label>
                        <input type="number" step="0.01" class="form-control product-discount" name="sconto" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Fine Sconto</label>
                        <input type="date" class="form-control product-enddiscount" name="fineSconto" required>
                        <small id="errorMessage" style="color: red; display: none;">La data deve essere nel futuro!</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Immagine 1</label>
                        <input type="file" class="form-control product-image" name="img1" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Anteprima Immagine</label>
                        <img class="img-fluid product-image-preview d-block" style="max-height: 200px;" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="tipoProdottoId">Tipo Prodotto</label>
                        <select class="form-control product-type" name="tipoProdottoId" id="tipoProdottoId" required>
                            <option value="" disabled selected>Seleziona un tipo di prodotto</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($category->getDescription(), ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-primary">Salva</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="public/script/admin/new_product.js"></script>