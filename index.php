<?php
session_start();
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
  <title>Justin Bieber - Site Oficial</title>

  <!--todas as tuas cores e fontes -->
  <link rel="stylesheet" href="styles.css">

  
</head>
<body>

  <!-- ========== NAVEGAÇÃO NO TOPO ========== -->
  <header class="site-header">
    <div class="header-inner">

      <!-- Logo -->
      <div class="logo">
        <span class="logo-icon">🎤</span>
        <div>
          <h1 class="logo-title">Justin Bieber</h1>
          <span class="logo-subtitle">Site Oficial</span>
        </div>
      </div>

      <!-- Links de navegação -->
      <nav class="header-nav">
        
        <a href="index.php">Loja Oficial</a>
        <?php if (isset($_SESSION['username'])): ?>
            <span>Olá, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="logout.php">Sair</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Criar Conta</a>
        <?php endif; ?>
      </nav>

    </div>
  </header>

  <!-- ========== SECÇÃO PRINCIPAL (HERO) ========== -->
  <section class="hero">
    <div class="hero-content">
      <p class="hero-tag">Bem-vindo ao site oficial</p>
      <h2 class="hero-title">Justin Bieber</h2>
      <p class="hero-sub">
        Músico, compositor e ícone pop mundial.
        Explora a sua música, história e merch exclusivo.
      </p>

      <!-- Botão que leva à loja -->
      <a href="store.php" class="hero-btn">Visitar a Loja Oficial</a>
      
    </div>
  </section>

  <!-- ========== SECÇÃO SOBRE O ARTISTA ========== -->
  <section style="padding: 60px 20px; max-width: 800px; margin: 0 auto; text-align: center;">
    <h2 class="section-title">Sobre o Artista</h2>
    <p style="color: var(--cor-texto-suave); font-size: 1.05rem; line-height: 1.8;">
      Justin Drew Bieber nasceu a 1 de março de 1994 em London, Ontário, Canadá.
      Descoberto aos 13 anos pelo empresário Scooter Braun, tornou-se rapidamente
      um dos artistas mais reconhecidos do mundo. Com álbuns icónicos como
      <strong style="color: var(--cor-dourado);">Purpose</strong>,
      <strong style="color: var(--cor-dourado);">Changes</strong> e
      <strong style="color: var(--cor-dourado);">Justice</strong>,
      Justin redefiniu a música pop contemporânea e conquistou milhões de fãs em todo o planeta.
    </p>
  </section>

  <!-- ========== RODAPÉ ========== -->
  <footer class="site-footer">
    <p>© 2024 Justin Bieber Official Site. Todos os direitos reservados.</p>
  </footer>

</body>
</html>