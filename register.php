<?php
require 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password)
            VALUES (:username, :email, :password)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $password
    ]);

    echo "<p>Conta criada com sucesso!</p>";
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>criar conta </title>
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

        <h2 class="hero-title">Criar Conta</h2>

        <form method="POST" action="register.php">

            <label>Nome de utilizador</label>
            <input type="text" name="username" required>

            <label>E-mail</label>
            <input type="email" name="email" required>

            <label>Senha</label>
            <input type="password" name="password" required>

            <button type="submit">Criar Conta</button>

        </form>

        <p>Já tem uma conta? <a href="login.php">Entrar</a></p>

    </div>
</section>

</body>
</html>