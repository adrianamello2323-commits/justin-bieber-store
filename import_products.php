<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'db.php';

// Lê o arquivo JSON
$json = file_get_contents('catalog.json');
$data = json_decode($json, true);

// Pega só a parte "products"
$products = $data['products'];

$sql = "INSERT INTO products (name, category, description, price, image, stock) 
        VALUES (:name, :category, :description, :price, :image, :stock)";
$stmt = $pdo->prepare($sql);

$contador = 0;

foreach ($products as $produto) {
    $stmt->execute([
        ':name' => $produto['name'],
        ':category' => $produto['category'],
        ':description' => $produto['description'],
        ':price' => $produto['price'],
        ':image' => $produto['image'],
        ':stock' => 50 // valor padrão, já que não existe no JSON
    ]);
    $contador++;
}

echo "$contador produtos importados com sucesso!";