<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loja Oficial - Justin Bieber</title>
<?php
if(isset($_SESSION['username'])){
  echo "<p>olá , ".$_SESSION['username']."!</p>";
}
?>
  <!-- Folha de estilos principal -->
  <link rel="stylesheet" href="styles.css">

  
</head>
<body>

  <!-- ========== CABEÇALHO ========== -->
  <header class="site-header">
    <div class="header-inner">
      <!-- Logo / Nome da loja -->
      <div class="logo">
        <span class="logo-icon">🎤</span>
        <div>
          <h1 class="logo-title">Justin Bieber</h1>
          <span class="logo-subtitle">Loja Oficial</span>

        </div>
      </div>
      <!-- Navegação rápida -->
      <nav class="header-nav">
        <a href="#filter-section">Catálogo</a>
        
        <a href="cart.php">carrinho</a>
        <a href="index.php">Loja Oficial</a>
        <?php if (isset($_SESSION['username'])) { ?>
    <a href="logout.php">Logout</a>
<?php } else { ?>
    <a href="login.php">Login</a>
    <a href="register.php">Criar Conta</a>
<?php } ?>
      </nav>
    </div>
  </header>

  <!-- ========== BANNER HERO ========== -->
  <section class="hero">
    <div class="hero-content">
      <p class="hero-tag">Coleção Exclusiva</p>
      <h2 class="hero-title">Justice World Tour</h2>
      <p class="hero-sub">Merch oficial, CDs, vinis e muito mais. Leva um pedaço da música contigo.</p>
      <a href="#filter-section" class="hero-btn">Ver Produtos</a>
    </div>
  </section>

  <main>

    <!-- ========== SECÇÃO DE FILTROS POR CATEGORIA ========== -->
    <!--
      Esta secção tem o dropdown de categorias.
      O JavaScript vai preencher as <option> dinamicamente
      depois de ler o catalog.json via AJAX (fetch).
    -->
    <section id="filter-section" class="filter-section">
      <div class="container">
        <h2 class="section-title">Catálogo de Produtos</h2>
        <div class="filter-bar">
          <label for="category-filter" class="filter-label">Filtrar por Categoria:</label>
          <select id="category-filter" class="filter-select">
            <option value="">Todas as Categorias</option>
            <!-- As categorias do catalog.json serão inseridas aqui pelo scripts.js -->
          </select>
        </div>
      </div>
    </section>

    <!-- ========== GRELHA DE PRODUTOS ========== -->
    <!--
      A div #product-list começa vazia.
      O scripts.js vai criar um cartão (<div class="product-card">)
      para cada produto do catalog.json e inserir aqui.
    -->
    <section id="catalog" class="catalog-section">
      <div class="container">
        <div id="product-list" class="product-grid">
          <!-- Produtos carregados dinamicamente via AJAX/JSON -->
        </div>
        <!-- Mensagem exibida quando não há produtos na categoria selecionada -->
        <p id="no-products-msg" class="no-products" style="display:none;">
          Nenhum produto encontrado nesta categoria.
        </p>
      </div>
    </section>

    <!-- ========== FORMULÁRIO DE CÁLCULO DE VALOR TOTAL ========== -->
    <!--
      O utilizador escolhe um produto e uma quantidade.
      O JavaScript calcula: preço × quantidade e exibe em #total-value.
      O select #product-select também é preenchido via AJAX.
    -->
    <section id="order-form" class="order-section">
      <div class="container">
        <div class="order-card">
          <h2 class="section-title">Calcular Valor Total</h2>
          <p class="order-desc">Escolhe um produto, define a quantidade e descobre o valor da tua encomenda.</p>

          <div id="calc-form" class="calc-form">

            <!-- Campo 1: Seleção do produto -->
            <div class="form-group">
              <label for="product-select" class="form-label">Escolha um produto:</label>
              <select id="product-select" class="form-select">
                <option value="">-- Selecione um produto --</option>
                <!-- Preenchido dinamicamente pelo scripts.js -->
              </select>
            </div>

            <!-- Campo 2: Quantidade -->
            <div class="form-group">
              <label for="quantity" class="form-label">Quantidade:</label>
              <input
                type="number"
                id="quantity"
                class="form-input"
                min="1"
                value="1"
                placeholder="Ex: 2"
              >
            </div>

            <!-- Mensagem de erro de validação (oculta por padrão, aparece se houver erro) -->
            <p id="form-error" class="form-error" style="display:none;"></p>

            <!-- Botão que aciona o cálculo (type="button" para não submeter o form) -->
            <button type="button" id="calculate-btn" class="btn-calculate">
              Calcular Valor Total
            </button>

          </div>

          <!-- Área de resultado do cálculo — preenchida dinamicamente -->
          <div id="total-value" class="total-value" style="display:none;">
            <!-- Resultado será exibido aqui pelo scripts.js -->
          </div>

        </div>
      </div>
    </section>

  </main>

  <!-- ========== RODAPÉ ========== -->
  <footer class="site-footer">
    <p>© 2024 Justin Bieber Official Store. Todos os direitos reservados.</p>
  </footer>

  <!-- ========== LIGHTBOX ========== -->
  <!--
    O lightbox começa oculto (display:none).
    Quando o utilizador clica em "Ver Detalhes" num produto,
    o scripts.js preenche os campos abaixo e remove o display:none.
    Clicar no X ou fora do conteúdo fecha o lightbox.
  -->
  <div id="lightbox" class="lightbox" style="display:none;" role="dialog" aria-modal="true">
    <div class="lightbox-content">
      <!-- Botão de fechar -->
      <button class="close-btn" id="lightbox-close" aria-label="Fechar">&times;</button>
      <!-- Imagem do produto -->
      <img id="lightbox-image" src="" alt="Imagem do produto" class="lightbox-img">
      <!-- Detalhes do produto -->
      <div class="lightbox-info">
        <h2 id="lightbox-title" class="lightbox-title"></h2>
        <p id="lightbox-description" class="lightbox-description"></p>
        <p id="lightbox-price" class="lightbox-price"></p>
      </div>
    </div>
  </div>

  <!-- Scripts JavaScript (carregado no final para garantir que o HTML já existe) -->
  <script src="scripts.js"></script>

</body>
</html>