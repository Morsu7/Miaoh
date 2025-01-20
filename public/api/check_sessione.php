<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_SESSION['email'])){
        echo json_encode([
            'success' => true
        ]);
    }else{
        echo json_encode([
            'success' => false,
            'error' => 'No sessione'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Richiesta non valida.'
    ]);
}
