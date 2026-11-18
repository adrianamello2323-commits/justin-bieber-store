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

// 1. Verifica se veio um id válido na URL
if (!isset($_GET['id']) && !isset($_POST['id'])) {
    header("Location: admin.php");
    exit;
}

$id = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];

// 2. Se o formulário foi enviado (POST), atualiza o produto
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
        $stmt = $pdo->prepare("UPDATE products
                                SET name = :name, category = :category, description = :description,
                                    image = :image, price = :price, stock = :stock
                                WHERE id = :id");
        $stmt->execute([
            ':name' => $name,
            ':category' => $category,
            ':description' => $description,
            ':image' => $image,
            ':price' => $price,
            ':stock' => $stock,
            ':id' => $id
        ]);

        header("Location: admin.php");
        exit;
    }
}

// 3. Busca os dados atuais do produto pra pré-preencher o formulário
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch();

if (!$produto) {
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
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
        <h2 class="hero-title">Editar Produto</h2>

        <?php if ($erro): ?>
            <p style="color:red;"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form method="POST" action="edit_product.php">

            <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

            <label>Nome</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($produto['name']); ?>" required>

            <label>Categoria</label>
            <input type="text" name="category" value="<?php echo htmlspecialchars($produto['category']); ?>">

            <label>Descrição</label>
            <textarea name="description"><?php echo htmlspecialchars($produto['description']); ?></textarea>

            <label>Imagem (caminho, ex: imagens/produto.jpg)</label>
            <input type="text" name="image" value="<?php echo htmlspecialchars($produto['image']); ?>">

            <label>Preço (€)</label>
            <input type="number" step="0.01" name="price" value="<?php echo $produto['price']; ?>" required>

            <label>Stock</label>
            <input type="number" name="stock" value="<?php echo $produto['stock']; ?>" required>

            <button type="submit">Guardar Alterações</button>

        </form>
    </div>
</section>

</body>
</html>