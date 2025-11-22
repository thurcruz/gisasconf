<?php
include('cadastro.php');
$result = $conn->query("SELECT * FROM produtos WHERE status = 'ativo'");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cardápio - Gisas Confeitaria</title>
  <link rel="stylesheet" href="cardapio.css">
</head>
<body>

   <picture class="top">
      <source media="(max-width: 600px)" srcset="img/assets/top_p.png" />
      <source media="(max-width: 1200px)" srcset="img/assets/top_m.png" />
      <img src="img/assets/top_g.png" />
    </picture>

  <h2>Cardápio</h2>
<div class="cardapio_list">
    <?php while($row = $result->fetch_assoc()) { ?>
      <a href="pedido.php?id=<?php echo $row['id']; ?>" class="produto-link">
        <div class="produto">
          <img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['nome']; ?>">
          <h3><?php echo $row['nome']; ?></h3>
          <p><?php echo $row['descricao']; ?></p>
          <strong>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></strong>
        </div>
      </a>
    <?php } ?>
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
