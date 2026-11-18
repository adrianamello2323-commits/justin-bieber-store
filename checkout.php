<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if (!empty($_SESSION["cart"])) {

    // 1. Cria a encomenda (linha em "orders")
    $stmt = $pdo->prepare("INSERT INTO orders (user_id) VALUES (?)");
    $stmt->execute([$_SESSION['id']]);

    // 2. Guarda o id da encomenda que acabou de ser criada
    $order_id = $pdo->lastInsertId();

    // 3. Para cada produto no carrinho, cria uma linha em "order_items"
    $stmt_item = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");

    // conta quantas vezes cada id aparece no carrinho = quantidade
    $quantidades = array_count_values($_SESSION["cart"]);

    foreach ($quantidades as $product_id => $quantidade) {
        $stmt_item->execute([$order_id, $product_id, $quantidade]);
    }

    // 4. Esvazia o carrinho
    $_SESSION["cart"] = [];
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="site-header">
    <div class="header-inner">
        <nav class="header-nav">
            <a href="store.php">Loja</a>
            <a href="cart.php">Carrinho</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
</header>

<section class="hero">
    <div class="hero-content">
        <h2 class="hero-title">Compra realizada com sucesso!</h2>
        <p class="hero-sub">Obrigado pela sua compra. Esperamos vê-lo novamente em breve.</p>
    </div>
</section>

</body>
</html>