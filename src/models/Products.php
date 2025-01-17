<?php

class Products
{
    private array $products = [];

    public function __construct()
    {
        $this->loadProductsFromDatabase();
    }

    private function loadProductsFromDatabase(): void
    {
    // Prepara la query
    $query = "SELECT * FROM prodotto";
    $stmt = Connection::$db->prepare($query);

    try {
        // Esegui la query
        $stmt->execute();

        // Recupera i risultati
        $stmt->store_result(); // Memorizza i risultati per l'uso successivo

        // Verifica se ci sono risultati
        if ($stmt->num_rows > 0) {
            // Associa le variabili per il recupero dei dati
            $stmt->bind_result($id, $nome, $descrizione, $quantita, $prezzo, $sconto, $fine_sconto, $img1, $img2, $tipoProdotto_id);

            // Itera attraverso i risultati
            while ($stmt->fetch()) {
                $this->products[] = new Product(
                    (int)$id,
                    $nome,
                    $descrizione,
                    (int)$quantita,
                    (float)$prezzo,
                    (float)$sconto,
                    $fine_sconto,
                    $img1,
                    $img2 ?? null,
                    (int)$tipoProdotto_id
                );
            }
        } else {
            echo "Nessun prodotto trovato.\n"; // Debug: Nessun prodotto
        }
    } catch (Exception $e) {
        echo "Errore nel caricamento dei prodotti: " . $e->getMessage() . "\n"; // Debug: Errore
    }
    }





    public function getAllProducts(): array
    {
        return $this->products;
    }

    public function getProductById(int $id): ?Product
    {
        foreach ($this->products as $product) {
            if ($product->getId() === $id) {
                return $product;
            }
        }
        return null;
    }
}