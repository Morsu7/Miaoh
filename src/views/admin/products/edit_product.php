<div class="modal fade edit-product-modal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Modifica Prodotto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" class="edit-product-form">
                    <input type="hidden" id="editProductId" name="id">
                    <div class="mb-3">
                        <label class="form-label">Nome Prodotto</label>
                        <input type="text" class="form-control product-name" name="nome" id="editProductName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrizione</label>
                        <textarea class="form-control product-description" name="descrizione" id="editProductDescription" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantità</label>
                        <input type="number" class="form-control product-quantity" id="editProductQuantity" name="quantita" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prezzo</label>
                        <input type="number" step="0.01" class="form-control product-price" id="editProductPrice" name="prezzo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sconto (%)</label>
                        <input type="number" step="0.01" class="form-control product-discount" id="editProductDiscount" name="sconto" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fine Sconto</label>
                        <input type="date" class="form-control product-enddiscount" id="editProductEndDiscount" name="fineSconto" required>
                        <small id="errorMessage" style="color: red; display: none;">La data deve essere nel futuro!</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Immagine 1</label>
                        <input type="file" class="form-control product-image" id="editProductImage" name="img1" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Anteprima Immagine</label>
                        <img class="img-fluid product-image-preview d-block" id="editProductImagePreview" style="max-height: 200px;" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="editTipoProdottoId">Tipo Prodotto</label>
                        <select class="form-control product-type" id="editProductType" name="tipoProdottoId" id="editTipoProdottoId" required>
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
                        <button type="submit" class="btn btn-primary">Salva modifiche</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="public/script/admin/edit_product.js"></script>
