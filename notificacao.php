<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notificações</title>
    <link rel="stylesheet" href="notificacao.css" />
</head>
<body>
    <picture class="top">
        <source media="(max-width: 600px)" srcset="img/assets/top_p.png" />
        <source media="(max-width: 1200px)" srcset="img/assets/top_m.png" />
        <img src="img/assets/top_g.png" />
    </picture>

    <div class="container">
        <!-- Seção de notificações -->
        <h2>Notificações</h2>
        <div class="notifications-list">
            <div class="notification-item">
                <img src="img/nots/CARTAP.FIDELIDADE.webp" alt="CartaoFidelidade" class="notification-icon" />
                <div class="notification-content">
                    <h3>Carol, você só está mais um passo de ser uma Gisers😱</h3>
                    <p>Faça mais uma compra e tenha seu cartão fidelidade.</p>
                    <span class="notification-date">10/11/2024</span>
                </div>
            </div>

            <div class="notification-item">
                <img src="img/nots/cupom_de_desconto.png"CupomDesconto" class="notification-icon" />
                <div class="notification-content">
                    <h3>INACREDITÁVEL!😱</h3>
                    <p>Precinhos surreais com um brinde na entrega. Corre pra aproveitar!.</p>
                    <span class="notification-date">08/11/2024</span>
                </div>
            </div>

            <div class="notification-item">
                <img src="img/nots/frete.gratis.webp" alt="FreteGratis" class="notification-icon" />
                <div class="notification-content">
                    <h3>FRETE GRÁTIS🛵</h3>
                    <p>Frete grátis na sua primeira compra para se deliciar no conforto da sua casa.</p>
                    <span class="notification-date">05/11/2024</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé com navegação -->
   <nav>
        <ul class="menu">
          <li>
            <a href="index.php"><img src="img/assets/home_icon.svg" alt="Início" />Início</a>
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
</body>
</html>