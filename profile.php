<?php
session_start();

// Só utilizadores autenticados podem ver esta página
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O meu perfil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="site-header">
    <div class="header-inner">
        <nav class="header-nav">
            <a href="store.php">Loja</a>
            <a href="cart.php">Carrinho</a>
            <a href="profile.php">Perfil</a>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="admin.php">Administração</a>
            <?php endif; ?>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
</header>

<section class="hero">
    <div class="hero-content">
        <h2 class="hero-title">O meu perfil</h2>

        <p><strong>Nome de utilizador:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <p><strong>Tipo de conta:</strong> <?php echo htmlspecialchars($_SESSION['role']); ?></p>

    </div>
</section>

</body>
</html>