/**
 * scripts.js — Loja Oficial Justin Bieber
 *
 * Este arquivo controla TODAS as funcionalidades dinâmicas da loja:
 *
 *  1. Carregamento do catalog.json via AJAX (fetch API)
 *  2. Exibição dinâmica dos produtos na página
 *  3. Preenchimento do dropdown de filtro por categoria
 *  4. Filtragem de produtos ao mudar a categoria selecionada
 *  5. Lightbox com detalhes do produto
 *  6. Formulário de cálculo de valor total com validação
 */

// ============================================================
// VARIÁVEL GLOBAL — guarda todos os produtos carregados do JSON
// É usada para filtrar sem precisar de fazer outro pedido AJAX
// ============================================================
let allProducts = [];
let cart = [];  // Array para armazenar os produtos adicionados ao carrinho

// ============================================================
// PONTO DE ENTRADA — executa quando a página terminar de carregar
// ============================================================
document.addEventListener('DOMContentLoaded', function () {
  loadCatalog();           // 1. Carrega o JSON
  setupCalculateBtn();     // 2. Configura o botão de calcular
  setupLightboxClose();    // 3. Configura o fecho do lightbox
});


// ============================================================
// FUNÇÃO 1: loadCatalog()
//
// Usa a Fetch API (forma moderna de fazer AJAX) para ler o
// arquivo catalog.json. Quando a resposta chegar, chama as
// funções que preenchem a página com os dados.
// ============================================================
function loadCatalog() {
  // fetch() faz um pedido HTTP ao arquivo catalog.json
  // É assíncrono: o código continua enquanto o arquivo carrega
  fetch('products_api.php')
    .then(function (response) {
      // .then() executa quando o pedido termina
      // Verificamos se correu bem (status 200 OK)
      if (!response.ok) {
        throw new Error('Erro ao carregar catalog.json: ' + response.status);
      }
      // .json() converte o texto do arquivo para um objeto JavaScript
      return response.json();
    })
    .then(function (data) {
      // 'data' agora é o objeto com categories[] e products[]

      // Guarda todos os produtos na variável global
      allProducts = data.products;

      // Preenche o dropdown de filtro com as categorias
      populateCategories(data.categories);

      // Preenche o select do formulário com os produtos
      populateProductSelect(data.products);

      // Exibe todos os produtos na grelha
      renderProducts(data.products);

      // Configura o evento de mudança no filtro de categoria
      setupCategoryFilter();
    })
    .catch(function (error) {
      // .catch() trata erros (arquivo não encontrado, JSON inválido, etc.)
      console.error('Erro AJAX:', error);
      document.getElementById('product-list').innerHTML =
        '<p style="color:#e05555; text-align:center; padding:40px;">Erro ao carregar os produtos. Certifica-te de que o servidor está a correr e o catalog.json existe.</p>';
    });
}


// ============================================================
// FUNÇÃO 2: populateCategories(categories)
//
// Recebe o array de categorias do JSON e cria um <option>
// para cada uma no dropdown #category-filter.
//
// Antes:  <select> só tem "Todas as Categorias"
// Depois: <select> tem também "CDs", "Merchandise", etc.
// ============================================================
function populateCategories(categories) {
  var select = document.getElementById('category-filter');

  // Percorre cada categoria e cria uma opção
  categories.forEach(function (category) {
    var option = document.createElement('option');   // cria <option>
    option.value = category.id;                      // value="cds"
    option.textContent = category.name;              // texto visível: "CDs"
    select.appendChild(option);                      // adiciona ao <select>
  });
}


// ============================================================
// FUNÇÃO 3: populateProductSelect(products)
//
// Preenche o <select id="product-select"> do formulário
// com todos os produtos disponíveis.
// ============================================================
function populateProductSelect(products) {
  var select = document.getElementById('product-select');

  products.forEach(function (product) {
    var option = document.createElement('option');
    // Guardamos o preço no value para usar no cálculo depois
    option.value = product.price;
    // Identificamos o produto pelo data-id (para poder encontrá-lo)
    option.setAttribute('data-id', product.id);
    // Texto visível: "CD - Justice (2021) — €15.99"
    option.textContent = product.name + ' — €' + product.price;
    select.appendChild(option);
  });
}


// ============================================================
// FUNÇÃO 4: renderProducts(products)
//
// Recebe um array de produtos e cria os cartões HTML na grelha.
// É chamada tanto no carregamento inicial como ao filtrar.
// ============================================================
function renderProducts(products) {
  var grid = document.getElementById('product-list');
  var noMsg = document.getElementById('no-products-msg');

  // Limpa o conteúdo anterior (importante ao filtrar)
  grid.innerHTML = '';

  // Se não há produtos para mostrar, exibe a mensagem de aviso
  if (products.length === 0) {
    noMsg.style.display = 'block';
    return;
  }

  // Esconde a mensagem de "nenhum produto"
  noMsg.style.display = 'none';

  // Para cada produto, cria um cartão HTML
  products.forEach(function (product) {
    var card = document.createElement('div');
    card.className = 'product-card';

    // innerHTML define o HTML interno do cartão
    // Usamos template literals (crase) para inserir os dados do produto
    card.innerHTML = `
      <img src="${product.image}" alt="${product.name}" loading="lazy">
      <div class="product-card-body">
        <span class="product-card-category">${getCategoryName(product.category)}</span>
        <h3 class="product-card-name">${product.name}</h3>
        <p class="product-card-price">€${product.price}</p>
        <button
          class="btn-details"
          data-id="${product.id}"
          aria-label="Ver detalhes de ${product.name}"
        >

Ver Detalhes</button>
        
          
        <button class="btn-cart" data-id="${product.id}" >Comprar</button>
                            
      </div>
    `;
    console.log(card.querySelector('.btn-cart'));

    // Adiciona o evento de clique no botão "Ver Detalhes"
    // quando esse botão for clicado, abre o lightbox

    card.querySelector('.btn-details').addEventListener('click', function () {
      openLightbox(product);
    });
    card.querySelector('.btn-cart').addEventListener('click', function () {
      const id = this.dataset.id;
      console.log(id);
      fetch("add_to_cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "id=" + encodeURIComponent(id)
      })
      .then(response => response.text())
      .then(data => {
        console.log(data);
        cart.push(product);
        alert("produto adicionado ao carrinho!");
      })
      .catch(error => console.error(error));
    });
    console.log(card.querySelector('.btn-cart'));

    // Adiciona o cartão à grelha
    grid.appendChild(card);
  });
}


// ============================================================
// FUNÇÃO AUXILIAR: getCategoryName(categoryId)
//
// Converte o id da categoria (ex: "cds") para o nome legível.
// Percorre o DOM para encontrar a opção correspondente no select.
// ============================================================
function getCategoryName(categoryId) {
  var select = document.getElementById('category-filter');
  var options = select.querySelectorAll('option');
  for (var i = 0; i < options.length; i++) {
    if (options[i].value === categoryId) {
      return options[i].textContent;
    }
  }
  return categoryId; // fallback: retorna o id se não encontrar
}


// ============================================================
// FUNÇÃO 5: setupCategoryFilter()
//
// Configura o evento 'change' no dropdown de categorias.
// Quando o utilizador escolhe uma categoria, filtramos
// o array global allProducts e re-renderizamos.
// ============================================================
function setupCategoryFilter() {
  var select = document.getElementById('category-filter');

  select.addEventListener('change', function () {
    var selectedCategory = this.value; // valor selecionado ("cds", "merch", etc.)

    if (selectedCategory === '') {
      // "Todas as Categorias" selecionada → mostra tudo
      renderProducts(allProducts);
    } else {
      // Filtra apenas os produtos da categoria escolhida
      // .filter() cria um novo array com os produtos que passam na condição
      var filtered = allProducts.filter(function (product) {
        return product.category === selectedCategory;
      });
      renderProducts(filtered);
    }
  });
}


// ============================================================
// FUNÇÃO 6: openLightbox(product)
//
// Abre o lightbox e preenche-o com os dados do produto clicado.
// ============================================================
function openLightbox(product) {
  // Preenche cada campo do lightbox com os dados do produto
  document.getElementById('lightbox-image').src = product.image;
  document.getElementById('lightbox-image').alt = product.name;
  document.getElementById('lightbox-title').textContent = product.name;
  document.getElementById('lightbox-description').textContent = product.description;
  document.getElementById('lightbox-price').textContent = '€' + product.price;

  // Mostra o lightbox (remove o display:none)
  var lightbox = document.getElementById('lightbox');
  lightbox.style.display = 'flex';

  // Bloqueia o scroll da página enquanto o lightbox está aberto
  document.body.style.overflow = 'hidden';
}


// ============================================================
// FUNÇÃO 7: closeLightbox()
//
// Fecha o lightbox e restaura o scroll da página.
// ============================================================
function closeLightbox() {
  var lightbox = document.getElementById('lightbox');
  lightbox.style.display = 'none';
  document.body.style.overflow = ''; // restaura scroll
}


// ============================================================
// FUNÇÃO 8: setupLightboxClose()
//
// Configura dois modos de fechar o lightbox:
//  a) Clicar no botão X
//  b) Clicar fora do conteúdo (no fundo escuro)
// ============================================================
function setupLightboxClose() {
  // Botão X fecha o lightbox
  document.getElementById('lightbox-close').addEventListener('click', closeLightbox);

  // Clicar no overlay (fundo escuro) fecha o lightbox
  // O evento 'click' no #lightbox só fecha se o clique
  // foi diretamente no overlay, não no conteúdo interior
  document.getElementById('lightbox').addEventListener('click', function (event) {
    if (event.target === this) {
      closeLightbox();
    }
  });

  // Pressionar ESC também fecha o lightbox
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      closeLightbox();
    }
  });
}


// ============================================================
// FUNÇÃO 9: setupCalculateBtn()
//
// Configura o botão "Calcular Valor Total".
// Valida os campos e calcula preço × quantidade.
// ============================================================
function setupCalculateBtn() {
  document.getElementById('calculate-btn').addEventListener('click', function () {
    // Obtém os elementos do formulário
    var productSelect = document.getElementById('product-select');
    var quantityInput = document.getElementById('quantity');
    var errorMsg      = document.getElementById('form-error');
    var totalDiv      = document.getElementById('total-value');

    // Lê os valores introduzidos pelo utilizador
    var selectedPrice = productSelect.value;
    var quantity      = parseInt(quantityInput.value, 10);

    // --- VALIDAÇÃO ---

    // Validação 1: produto tem de ser selecionado
    if (!selectedPrice) {
      showError(errorMsg, '⚠️ Por favor, seleciona um produto antes de calcular.');
      totalDiv.style.display = 'none';
      return; // interrompe a função
    }

    // Validação 2: quantidade tem de ser um número positivo
    if (isNaN(quantity) || quantity < 1) {
      showError(errorMsg, '⚠️ A quantidade tem de ser um número inteiro positivo (mínimo 1).');
      totalDiv.style.display = 'none';
      return;
    }

    // --- CÁLCULO ---
    // Esconde qualquer erro anterior
    errorMsg.style.display = 'none';

    // Converte o preço de string para número decimal
    var price = parseFloat(selectedPrice);

    // Calcula o total: preço × quantidade
    var total = price * quantity;

    // Obtém o nome do produto selecionado (a partir do texto da opção)
    var productName = productSelect.options[productSelect.selectedIndex].textContent;
    // Remove a parte "— €X.XX" do nome para exibir limpo
    var cleanName = productName.split(' — €')[0];

    // --- EXIBIÇÃO DO RESULTADO ---
    totalDiv.innerHTML = `
      <p class="total-label">Valor Total da Encomenda</p>
      <p class="total-amount">€${total.toFixed(2)}</p>
      <p class="total-detail">${quantity}x ${cleanName} × €${price.toFixed(2)}</p>
    `;
    totalDiv.style.display = 'block';
  });
}


// ============================================================
// FUNÇÃO AUXILIAR: showError(element, message)
//
// Exibe uma mensagem de erro num elemento HTML.
// ============================================================
function showError(element, message) {
  element.textContent = message;
  element.style.display = 'block';
}