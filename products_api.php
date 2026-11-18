<?php
require 'db.php';

header('Content-Type: application/json; charset=utf-8');

// 1. Busca todos os produtos da base de dados
$stmt = $pdo->query("SELECT id, name, category, description, price, image FROM products");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2. Garante que price é número (não string), para o JS calcular bem
foreach ($produtos as &$p) {
    $p['price'] = (float) $p['price'];
    $p['id'] = (int) $p['id'];
}
unset($p);

// 3. Constrói a lista de categorias únicas, a partir dos produtos existentes
$categoriasUnicas = array_unique(array_column($produtos, 'category'));
$categorias = [];
foreach ($categoriasUnicas as $cat) {
    $categorias[] = ['id' => $cat, 'name' => $cat];
}

// 4. Devolve no mesmo formato do catalog.json
echo json_encode([
    'categories' => $categorias,
    'products' => $produtos
]);