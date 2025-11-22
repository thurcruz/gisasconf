<?php
session_start();
include('conexao.php');

// Criar sacola se não existir
if (!isset($_SESSION['sacola'])) {
    $_SESSION['sacola'] = [];
}

// Remover item
if (isset($_POST['remove'])) {
    $index = $_POST['index'];
    if (isset($_SESSION['sacola'][$index])) {
        unset($_SESSION['sacola'][$index]);
        $_SESSION['sacola'] = array_values($_SESSION['sacola']); // reorganiza índices
    }
}

// Adicionar item na sacola
if (isset($_POST['add'])) {
    $id = intval($_POST['id']);
    $obs = $_POST['obs'];

    $result = $conn->query("SELECT * FROM produtos WHERE id = $id LIMIT 1");
    $produto = $result->fetch_assoc();

    if ($produto) {
        $_SESSION['sacola'][] = [
            'id' => $produto['id'],
            'nome' => $produto['nome'],
            'preco' => $produto['preco'],
            'imagem' => $produto['imagem'],
            'obs' => $obs
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sacola</title>
    <link rel="stylesheet" href="sacola.css">
</head>
<body>

<h2>Sacola</h2>

<?php if (empty($_SESSION['sacola'])) { ?>
    <p>Sua sacola está vazia.</p>

<?php } else { ?>

    <?php foreach ($_SESSION['sacola'] as $index => $item) { ?>
        <div class="item">
            <img src="<?php echo $item['imagem']; ?>" width="80">

            <div class="info">
                <strong><?php echo $item['nome']; ?></strong><br>
                R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?><br>
                <?php if ($item['obs']) { ?>
                    <em>Obs: <?php echo $item['obs']; ?></em><br>
                <?php } ?>
            </div>

            <form method="POST">
                <input type="hidden" name="index" value="<?php echo $index; ?>">
                <button type="submit" name="remove" class="btn-remove">Remover</button>
            </form>
        </div>
    <?php } ?>

    <a href="finalizar_pedido.php" class="btn-finalizar">Finalizar Pedido</a>

<?php } ?>

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
      </nav>

</body>
</html>
