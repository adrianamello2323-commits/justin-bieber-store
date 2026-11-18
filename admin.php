<?php
session_start();

// 1. O utilizador está autenticado?
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// 2. O utilizador é admin?
if ($_SESSION['role'] !== 'admin') {
    echo "Acesso negado. Esta página é apenas para administradores.";
    exit;
}

require 'db.php';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Administração</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section class="hero">
    <div class="hero-content">
        <h2 class="hero-title">Painel de Administração</h2>
        <p class="hero-sub">Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        
    </div>
</section>
    <header class="site-header">
    <div class="header-inner">
        <nav class="header-nav">
            <a href="store.php">Loja</a>
            <a href="admin.php">Administração</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
</header>
    <?php
$stmt_o = $pdo->query("
    SELECT orders.id, users.username, orders.order_date, orders.status
    FROM orders
    JOIN users ON orders.user_id = users.id
    ORDER BY orders.order_date DESC
");
$encomendas = $stmt_o->fetchAll();
?>

<section style="padding: 40px 20px; max-width: 900px; margin: 0 auto;">
    <h2 class="section-title">Encomendas</h2>
    <table border="1" cellpadding="8" style="width:100%; border-collapse: collapse;">
        <tr>
            <th>ID</th>
            <th>Utilizador</th>
            <th>Data</th>
            <th>Estado</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($encomendas as $o): ?>
        <tr>
            <td><?php echo $o['id']; ?></td>
            <td><?php echo htmlspecialchars($o['username']); ?></td>
            <td><?php echo $o['order_date']; ?></td>
            <td><?php echo $o['status']; ?></td>
            <td>
                <?php if ($o['status'] !== 'completed'): ?>
                <form action="mark_order.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $o['id']; ?>">
                    <button type="submit">Marcar como processada</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>





<?php
$stmt = $pdo->query("SELECT id, username, email, role FROM users");
$utilizadores = $stmt->fetchAll();
?>

<section style="padding: 40px 20px; max-width: 900px; margin: 0 auto;">
    <h2 class="section-title">Utilizadores</h2>
    <table border="1" cellpadding="8" style="width:100%; border-collapse: collapse;">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
        <?php foreach ($utilizadores as $u): ?>
        <tr>
            <td><?php echo $u['id']; ?></td>
            <td><?php echo htmlspecialchars($u['username']); ?></td>
            <td><?php echo htmlspecialchars($u['email']); ?></td>
            <td><?php echo $u['role']; ?></td>
            <td>

    <a href="edit_user.php?id=<?php echo $u['id']; ?>">Editar</a>
    <form action="delete_user.php" method="POST" style="display:inline;">
        <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
        <button type="submit">Remover</button>
    </form>
</td>
        </tr>
        <?php endforeach; ?>
    </table>

</section>
<?php
$stmt_p = $pdo->query("SELECT * FROM products");
$produtos = $stmt_p->fetchAll();
?>

<section style="padding: 40px 20px; max-width: 900px; margin: 0 auto;">
    <h2 class="section-title">Produtos</h2>
    <table border="1" cellpadding="8" style="width:100%; border-collapse: collapse;">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Stock</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($produtos as $p): ?>
        <tr>
            <td><?php echo $p['id']; ?></td>
            <td><?php echo htmlspecialchars($p['name']); ?></td>
            <td>€ <?php echo number_format($p['price'], 2); ?></td>
            <td><?php echo $p['stock']; ?></td>
            <td>
                <a href="edit_product.php?id=<?php echo $p['id']; ?>">Editar</a>
                <form action="delete_product.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                    <button type="submit">Remover</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>

</body>
</html>