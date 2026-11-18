<?php
session_start();
require "db.php";
if(!isset($_SESSION['id'])){
    header ("location:login.php");
    exit;
}
if (!isset($_SESSION["cart"])){
    $_SESSION["cart"]=[];
}
?>


<!DOCTYPE html>
<html lang="PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
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
    <div id="cart-items" class="hero-content">
        <h2 class="hero-title">Carrinho de Compras</h2>
        <p class="hero-sub">Revê os teus produtos antes de finalizar a compra.</p>
    </div>
</section>
        <!---aqui aparece os produtos-->
        <?php
$total = 0;
$quantidades = array_count_values($_SESSION["cart"]);
$carrinho_limpo = [];

foreach ($quantidades as $id => $quantidade) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch();

    if ($produto) {
        $subtotal = $produto["price"] * $quantidade;

        echo "<h3>" . $produto["name"] . "</h3>";
        echo "<p>Quantidade: " . $quantidade . "</p>";
        echo "<img src='" . $produto["image"] . "' width='160'><br>";
        echo "<p>Preço unitário: € " . $produto["price"] . "</p>";
        echo "<p>Subtotal: € " . number_format($subtotal, 2) . "</p>";

        $total += $subtotal;
echo "<form action='update.php' method='POST' style='display:inline-block; margin-right:10px;'>";
echo "<input type='hidden' name='id' value='" . $produto["id"] . "'>";
echo "<input type='number' name='quantidade' value='" . $quantidade . "' min='1' style='width:60px;'>";
echo "<button class='hero-btn' type='submit'>Atualizar</button>";
echo "</form>";




        echo "<form action='remove_from_cart.php' method='POST'>";
        echo "<input type='hidden' name='id' value='" . $produto["id"] . "'>";
        echo "<button class='hero-btn' type='submit'>Remover</button>";
        echo "</form>";

        for ($i = 0; $i < $quantidade; $i++) {
            $carrinho_limpo[] = $id;
        }
    }
}

$_SESSION["cart"] = $carrinho_limpo;

echo "<br><h2>total: €" . number_format($total, 2) . "</h2>";
if (!empty($_SESSION["cart"])) {
    echo "<form action='checkout.php' method='get'>";
    echo "<button class='hero-btn' type='submit'>finalizar compra</button>";
    echo "</form>";
}

if (empty($_SESSION["cart"])) {
    echo "<p>o carrinho está vazio.</p>";
}
        ?>
    </div>
</body>
</html>