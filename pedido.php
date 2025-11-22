<?php
include('cadastro.php');

if (!isset($_GET['id'])) {
    die("Produto não encontrado.");
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM produtos WHERE id = $id AND status = 'ativo'");
$produto = $result->fetch_assoc();

if (!$produto) {
    die("Produto não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $produto['nome']; ?></title>
    <link rel="stylesheet" href="pedido.css">
</head>
<body>

<picture class="top">
    <source media="(max-width: 600px)" srcset="img/assets/top_p.png" />
    <source media="(max-width: 1200px)" srcset="img/assets/top_m.png" />
    <img src="img/assets/top_g.png" />
</picture>

<div class="container">
    <!-- FOTO -->
    <div class="photo">
        <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>" />
    </div>

    <!-- INFO -->
    <div class="info">
        <h2><?php echo $produto['nome']; ?></h2>
        <p><?php echo $produto['descricao']; ?></p>
        <h6>Serve até 1 pessoa</h6>

        <div class="observacao">
            <p>Alguma observação?</p>
            <input type="text" class="box" id="obs">
        </div>

        <div class="botoes">
            <a href="sacola.php" class="btn-small">Visualizar Sacola</a>

            <form action="sacola.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
                <input type="hidden" name="obs" id="obsInput">
                <button type="submit" name="add" class="btn-large">Adicionar na Sacola</button>
            </form>
        </div>
    </div>
</div>

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

<script>
// Envia a observação junto no POST
document.querySelector("form").addEventListener("submit", function () {
    document.getElementById("obsInput").value =
        document.getElementById("obs").value;
});
</script>

</body>
</html>
