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

if (!isset($_GET['id']) && !isset($_POST['id'])) {
    header("Location: admin.php");
    exit;
}

$id = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $role     = $_POST['role'];

    if ($username === '' || $email === '') {
        $erro = "Preenche nome de utilizador e email.";
    } else {
        $stmt = $pdo->prepare("UPDATE users
                                SET username = :username, email = :email, role = :role
                                WHERE id = :id");
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':role' => $role,
            ':id' => $id
        ]);

        header("Location: admin.php");
        exit;
    }
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Utilizador</title>
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
        <h2 class="hero-title">Editar Utilizador</h2>

        <?php if ($erro): ?>
            <p style="color:red;"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form method="POST" action="edit_user.php">

            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

            <label>Nome de utilizador</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label>Role</label>
            <select name="role">
                <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>user</option>
                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>admin</option>
            </select>

            <button type="submit">Guardar Alterações</button>

        </form>
    </div>
</section>

</body>
</html>