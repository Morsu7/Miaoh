<link rel="stylesheet" href="public/style/admin/admin.css">

<div class="container-fluid">
    <div class="row">
        <!-- Barra laterale (non modificata) -->
        <aside class="col-md-2 sidebar collapse d-md-block" id="sidebarMenu">
            <nav>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="index.php" class="btn btn-outline-primary text-dark">
                            Torna alla Homepage
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="?action=adminpage&subAction=dashboard" class="nav-link text-dark">Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="?action=adminpage&subAction=products" class="nav-link text-dark">Gestione Prodotti</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link text-dark active">Gestione Ordini</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Contenuto principale -->
        <main class="col-md-10">
            <h1 class="mt-4">Gestione Ordini</h1>
            <!-- Tabella responsiva -->
            <div class="table-responsive mt-4">
                <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th class="d-none d-md-table-cell">ID Utente</th> <!-- Nasconde su dispositivi piccoli -->
                            <th>ID Acquisto</th>
                            <th>Timestamp</th>
                            <th>Stato Acquisto</th>
                            <th class="text-center">Spesa (€)</th>
                            <th class="text-center">Azione</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allOrders as $order): ?>
                        <tr data-id_acquisto="<?= $order->getIdAcquisto() ?>">
                            <td class="d-none d-md-table-cell"><?= htmlspecialchars($order->getIdUtente()) ?></td> <!-- Nasconde su dispositivi piccoli -->
                            <td><?= htmlspecialchars($order->getIdAcquisto()) ?></td>
                            <td><?= htmlspecialchars($order->getTimestamp()) ?></td>
                            <td class="stato-acquisto"><?= $order->getStatoAcquistoFormatted() ?></td>
                            <td class="text-center"><?= htmlspecialchars(number_format($order->getSpesa(), 2)) ?></td>
                            <td class="text-center">
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
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Paginazione -->
                <nav aria-label="Paginazione prodotti">
                    <ul class="pagination justify-content-center">
                        <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?action=adminpage&subAction=orders&page=<?= $currentPage - 1 ?>" aria-label="Precedente">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="?action=adminpage&subAction=orders&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?action=adminpage&subAction=orders&page=<?= $currentPage + 1 ?>" aria-label="Successivo">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </main>
    </div>
</div>

<script src="public/script/admin/manage_orders.js"></script>
