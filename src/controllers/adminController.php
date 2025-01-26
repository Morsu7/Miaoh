<?php

include('../src/models/products/Product.php');
include('../src/models/products/Products.php');
include('../src/models/products/Category.php');
include('../src/models/orders/Order.php');
require_once('../src/models/products/ProductsManager.php');
require_once('../src/models/orders/OrdersManager.php');
require_once('../src/models/analytics/AnalyticsManager.php');

if(!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== "e[9B0a,z6Qq+i7?4RECT*Kz]wz17#0"){
    header('Location: ?action=login');
    exit;
}

//Recuperare l'azione da svolgere
$subAction = isset($_GET['subAction']) ? $_GET['subAction'] : 'dashboard';
$show_header = false;
$elementsPerPage = 20;

switch ($subAction) {
    case 'dashboard':
    default:
        $orders_total = AnalyticsManager::getOrdersTotal();
        $orders_pending = AnalyticsManager::getOrdersPending();
        $orders_shipped = AnalyticsManager::getOrdersShipped();
        $orders_delivered = AnalyticsManager::getOrdersDelivered();
        $users_registered = AnalyticsManager::getUsersRegistered();

        // Recupera i dati dinamici per il grafico
        $purchaseData = AnalyticsManager::getPurchasesByDate();
            
        // Prepara i dati per il grafico
        $labels = [];
        $data = [];
            
        foreach ($purchaseData as $entry) {
            $labels[] = $entry['date']; // Aggiungi la data
            $data[] = $entry['total_purchases']; // Aggiungi il numero di acquisti
        }

        $content = '../src/views/admin/dashboard.php';
        break;
    case 'products':
        $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

        if (!empty($searchTerm)) {
            $allProducts = ProductsManager::fetchProductsByName($searchTerm, $currentPage, $elementsPerPage);
            $totalPages = ceil(ProductsManager::getSearchProductsNumber($searchTerm) / $elementsPerPage);
        } else {
            $allProducts = ProductsManager::fetchProductsByPage($currentPage, $elementsPerPage);
            $totalPages = ceil(ProductsManager::getProductsNumber() / $elementsPerPage);
        }

        if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
            // Genera il nuovo HTML per la lista dei prodotti
            ob_start();
            foreach ($allProducts as $product): ?>
                <div class="col-12 mb-4">
                    <div class="card shadow-sm single-product d-flex flex-row w-100" data-id="<?= $product->getId() ?>">
                        <img src="public/assets/images/productimages/<?= htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8'); ?>.<?= htmlspecialchars($product->getImg1(), ENT_QUOTES, 'UTF-8'); ?>" class="card-img-left img-fluid" alt="Immagine prodotto" style="max-width: 150px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($product->getNome()) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($product->getDescrizione()) ?></p>
                            <p class="card-text">
                                <strong>Prezzo: </strong>€<?= number_format($product->getPrezzo(), 2) ?>
                            </p>
                            <p class="card-text">
                                <strong>Sconto: </strong><?= $product->getSconto() ?>%
                            </p>
                            <p class="card-text">
                                <strong>Prezzo Scontato: </strong>€<?= number_format($product->getPrezzoScontato(), 2) ?>
                            </p>
                            <p class="card-text">
                                <strong>Quantità: </strong><?= $product->getQuantita() ?>
                            </p>
                            <div class="mt-auto">
                                <button 
                                    type="button" 
                                    class="btn btn-primary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target=".edit-product-modal" 
                                    data-id="<?php echo $product->getId(); ?>" 
                                    data-nome="<?php echo htmlspecialchars($product->getNome(), ENT_QUOTES, 'UTF-8'); ?>" 
                                    data-descrizione="<?php echo htmlspecialchars($product->getDescrizione(), ENT_QUOTES, 'UTF-8'); ?>" 
                                    data-prezzo="<?php echo $product->getPrezzo(); ?>" 
                                    data-sconto="<?php echo $product->getSconto(); ?>" 
                                    data-quantita="<?php echo $product->getQuantita(); ?>" 
                                    data-finesconto="<?php echo $product->getFineSconto(); ?>" 
                                    data-tipoprodottoid="<?php echo $product->getTipoProdottoId(); ?>" 
                                    data-img1="<?php echo "public/assets/images/productimages/" . htmlspecialchars($product->getId(), ENT_QUOTES, 'UTF-8') . "." . htmlspecialchars($product->getImg1(), ENT_QUOTES, 'UTF-8') ?>"
                                >
                                    Modifica
                                </button>
                                <button class="btn btn-danger" onclick="deleteProduct(<?= $product->getId() ?>)">Elimina</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;
            $htmlContent = ob_get_clean();

            // Genera il nuovo HTML per la paginazione
            ob_start();
            ?>
            <nav aria-label="Paginazione prodotti">
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?action=adminpage&subAction=products&page=<?= $currentPage - 1 ?>&search=<?= urlencode($searchTerm) ?>" aria-label="Precedente">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="?action=adminpage&subAction=products&page=<?= $i ?>&search=<?= urlencode($searchTerm) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?action=adminpage&subAction=products&page=<?= $currentPage + 1 ?>&search=<?= urlencode($searchTerm) ?>" aria-label="Successivo">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php
            $paginationHtml = ob_get_clean();

            // Restituisce l'HTML della lista dei prodotti e della paginazione
            echo json_encode([
                'productList' => $htmlContent,
                'pagination' => $paginationHtml
            ]);
            exit;
        }
    
        $categories = ProductsManager::getCategories();
        $content = '../src/views/admin/products.php';
        break;
    case 'orders':
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $searchId = isset($_GET['search_id']) ? trim($_GET['search_id']) : '';
        $filterStatus = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';
        
        // Modifica la query per prendere in considerazione i filtri
        $allOrders = OrdersManager::fetchOrdersByPageAndFilters($currentPage, $elementsPerPage, $filterStatus, $searchId);
        $totalPages = ceil(OrdersManager::getOrdersNumberWithFilters($searchId, $filterStatus) / $elementsPerPage);

        if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
            ob_start();
            foreach ($allOrders as $order): ?>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card" data-id_acquisto="<?= htmlspecialchars($order->getIdAcquisto()) ?>">
                        <div class="card-body">
                            <h5 class="card-title">ID Acquisto: <?= htmlspecialchars($order->getIdAcquisto()) ?></h5>
                            <p class="card-text">Timestamp: <?= htmlspecialchars($order->getTimestamp()) ?></p>
                            <p class="card-text">Stato Acquisto: <strong class="stato-acquisto"><?= $order->getStatoAcquistoFormatted() ?></strong></p>
                            <p class="card-text">Spesa: € <?= htmlspecialchars(number_format($order->getSpesa(), 2)) ?></p>
                        </div>
                        <div class="card-footer">
                            <div class="text-center">
                                <?php if ($order->getStatoAcquisto() != 'consegnato'): ?>
                                <form class="d-flex flex-column flex-md-row align-items-center update-order-status-form">
                                    <input type="hidden" name="id_acquisto" value="<?php echo $order->getIdAcquisto(); ?>">
                                    <select name="stato_acquisto" class="form-select w-100 w-md-auto me-md-2 mb-2 mb-md-0">
                                        <option value="da_spedire" <?php echo $order->getStatoAcquisto() == 'da_spedire' ? 'selected' : ''; ?>>Da Spedire</option>
                                        <option value="spedito" <?php echo $order->getStatoAcquisto() == 'spedito' ? 'selected' : ''; ?>>Spedito</option>
                                        <option value="consegnato" <?php echo $order->getStatoAcquisto() == 'consegnato' ? 'selected' : ''; ?>>Consegnato</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary w-100 w-md-auto">Cambia stato</button>
                                </form>
                                <?php else: ?>
                                <button class="btn btn-secondary mt-2 w-100" disabled>Consegnato</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;
            $htmlContent = ob_get_clean();

            // Genera il nuovo HTML per la paginazione
            ob_start();
            ?>
            <nav aria-label="Paginazione ordini">
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?action=adminpage&subAction=orders&page=<?= $currentPage - 1 ?>&search_id=<?= urlencode($searchId) ?>&filter_status=<?= urlencode($filterStatus) ?>" aria-label="Precedente">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="?action=adminpage&subAction=orders&page=<?= $i ?>&search_id=<?= urlencode($searchId) ?>&filter_status=<?= urlencode($filterStatus) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?action=adminpage&subAction=orders&page=<?= $currentPage + 1 ?>&search_id=<?= urlencode($searchId) ?>&filter_status=<?= urlencode($filterStatus) ?>" aria-label="Successivo">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php
            $paginationHtml = ob_get_clean();

            // Restituisce l'HTML della lista degli ordini e della paginazione
            echo json_encode([
                'productList' => $htmlContent,
                'pagination' => $paginationHtml
            ]);
            exit;
        }

        $content = '../src/views/admin/orders.php';
        break;
    case 'homepage':
        header('Location: ?#');
        exit;
}

?>