<?php
session_start();

// Se o usuário não estiver logado, redireciona
if (!isset($_SESSION['usuario_id'])) {
  header("Location: login.html");
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gisas</title>
 <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">

  </head>

  <body>
    <!-- TOPO -->
    <picture class="top">
      <source media="(max-width: 600px)" srcset="img/assets/top_p.png" />
      <source media="(max-width: 1200px)" srcset="img/assets/top_m.png" />
      <img src="img/assets/top_g.png" />
    </picture>

    <!-- ACESSIBILIDADE -->
<div class="acessibilidade">
  <button onclick="aumentarFonte()">A+</button>
  <button onclick="diminuirFonte()">A-</button>
  <button onclick="toggleContraste()">Contraste</button>
</div>


    <div class="container">
      <!-- SEÇÃO DE BOAS-VINDAS -->
      <div class="welcome">
        <div class="welcome-container">
          <a href="perfil.php" class="profile-picture"></a>
          <div class="welcome-text">
            <span>
              Olá,
              <?php echo isset($_SESSION['usuario_nome']) ? htmlspecialchars($_SESSION['usuario_nome']) : 'Seu nome'; ?>!
            </span>
            <span class="points">Você possui 0 pontos!</span>
          </div>
        </div>

        <div class="not">
          <a href="notificacao.php">
            <img src="img/assets/not_icon.svg" alt="Notificações" />
          </a>
        </div>
      </div>

      <!-- BARRA DE PESQUISA -->
      <div class="search-bar">
        <input type="text" placeholder="Buscar..." />
        <button>
          <img src="img/assets/busca_icon.svg" alt="Buscar" />
        </button>
      </div>

      <!-- CARROSSEL -->
      <div class="carrossel">
        <img src="img/banners/CARD 1.png" class="visivel" alt="Banner 1" />
        <img src="img/banners/CARD 2.png" alt="Banner 2" />
        <img src="img/banners/CARD 3.png" alt="Banner 3" />
      </div>

      <script>
        // Seleciona todas as imagens no carrossel
        const imagens = document.querySelectorAll(".carrossel img");
        let indiceAtual = 0;

        function trocarImagem() {
          imagens[indiceAtual].classList.remove("visivel");
          indiceAtual = (indiceAtual + 1) % imagens.length;
          imagens[indiceAtual].classList.add("visivel");
        }

        // Troca automática a cada 5 segundos
        setInterval(trocarImagem, 5000);
      </script>

      <!-- MAIS PEDIDOS -->
      <h2>Mais pedidos</h2>
      <div class="product-list">
        <div class="product">
          <img src="img/produtos/BRIGADEIRO.png" alt="Brigadeiro" />
          <h4>R$ 00,00</h4>
          <h3>Brigadeiro</h3>
        </div>
        <div class="product">
          <img src="img/produtos/BRONIEW.png" alt="Broniew" />
          <h4>R$ 00,00</h4>
          <h3>Broniew</h3>
        </div>
        <div class="product">
          <img src="img/produtos/TORTA.png" alt="Torta" />
          <h4>R$ 00,00</h4>
          <h3>Torta</h3>
        </div>
      </div>

      <!-- PROMOÇÕES DO DIA -->
      <h2>Promoções do dia</h2>
      <div class="promo-list">
        <div class="promo-item">
          <img src="img/produtos/OFF.png" alt="Promoção 1" />
          <div class="promo-details">
            <h3>Nome da Sobremesa</h3>
            <p>Descrição do produto</p>
            <h4>R$ 00,00</h4>
          </div>
        </div>

        <div class="promo-item">
          <img src="img/produtos/OFF.png" alt="Promoção 2" />
          <div class="promo-details">
            <h3>Nome da Sobremesa</h3>
            <p>Descrição do produto</p>
            <h4>R$ 00,00</h4>
          </div>
        </div>

        <div class="promo-item">
          <img src="img/produtos/OFF.png" alt="Promoção 3" />
          <div class="promo-details">
            <h3>Nome da Sobremesa</h3>
            <p>Descrição do produto</p>
            <h4>R$ 00,00</h4>
          </div>
        </div>
      </div>

      <!-- RODAPÉ -->
      <nav>
        <ul class="menu">
          <li>
            <a href="#"><img src="img/assets/home_icon.svg" alt="Início" />Início</a>
          </li>
          <li>
            <a href="cardapio.php"><img src="img/assets/menu_icon.svg" alt="Cardápio" />Cardápio</a>
          </li>
          <li>
            <a href="#"><img src="img/assets/gisers_icon.svg" alt="Gisers" />Gisers</a>
          </li>
          <li>
            <a href="sacola.php"><img src="img/assets/bag_icon.svg" alt="Sacola" />Sacola</a></li>
        </ul>
      </nav>
    </div>

    <script>
  let tamanhoAtual = 100;

  function aumentarFonte() {
    tamanhoAtual += 10;
    document.body.style.fontSize = tamanhoAtual + "%";
  }

  function diminuirFonte() {
    if (tamanhoAtual > 60) {
      tamanhoAtual -= 10;
      document.body.style.fontSize = tamanhoAtual + "%";
    }
  }

  function toggleContraste() {
    document.body.classList.toggle("contraste");
  }
</script>

  </body>
</html>
