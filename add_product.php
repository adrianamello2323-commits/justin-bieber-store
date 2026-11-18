<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    echo "Acesso negado. Esta página é apenas para administradores.";
    exit;
}

require 'db.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name        = trim($_POST['name']);
    $category    = trim($_POST['category']);
    $description = trim($_POST['description']);
    $image       = trim($_POST['image']);
    $price       = $_POST['price'];
    $stock       = $_POST['stock'];

    if ($name === '' || $price === '' || $stock === '') {
        $erro = "Preenche pelo menos nome, preço e stock.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (name, category, description, image, price, stock)
                                VALUES (:name, :category, :description, :image, :price, :stock)");
        $stmt->execute([
            ':name' => $name,
            ':category' => $category,
            ':description' => $description,
            ':image' => $image,
            ':price' => $price,
            ':stock' => $stock
        ]);

        header("Location: admin.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Produto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="site-header">
    <div class="header-inner">
        <nav class="header-nav">
            <a href="store.php">Loja</a>
            <a href="admin.php">Administração</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
</header>

<section class="hero">
    <div class="hero-content">
        <h2 class="hero-title">Adicionar Novo Produto</h2>

        <?php if ($erro): ?>
            <p style="color:red;"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form method="POST" action="add_product.php">

            <label>Nome</label>
            <input type="text" name="name" required>

            <label>Categoria</label>
            <input type="text" name="category">

            <label>Descrição</label>
            <textarea name="description"></textarea>

            <label>Imagem (caminho, ex: imagens/produto.jpg)</label>
            <input type="text" name="image">

            <label>Preço (€)</label>
            <input type="number" step="0.01" name="price" required>

            <label>Stock</label>
            <input type="number" name="stock" required>

            <button type="submit">Adicionar Produto</button>

        </form>
    </div>
</section>

</body>
</html>