<?php

class CartManager {

    public static function TotalPriceProducts($products){
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product['quantita'] * $product['prodotto']->getPrezzoScontato();
        }

        return $totalPrice;
    }
}