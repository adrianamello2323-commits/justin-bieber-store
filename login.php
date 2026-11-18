<?php
session_start();
require 'db.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
         $_SESSION['role'] = $user['role'];
        header("Location: profile.php");
        exit;

    } else {
        $erro = "E-mail ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>


<body>

<header class="site-header">
    <div class="header-inner">
        <nav class="header-nav">
            <a href="index.php">Loja Oficial</a>
        </nav>
    </div>
</header>

<section class="hero">
    <div class="hero-content">
        <h2 class="hero-title">Entrar</h2>

<?php if($erro): ?>
<p style="color:red;">
    <?php echo $erro; ?>
</p>
<?php endif; ?>

<form method="POST">

    <label>E-mail</label><br>
    <input type="email" name="email" required><br><br>

    <label>Senha</label><br>
    <input type="password" name="password" required><br><br>

    
    <button type="submit">Entrar</button>

<p>
    Não tem uma conta?
    <a href="register.php">Criar Conta</a>
</p>

</form>
    </div>
</section>
</body>
</html>