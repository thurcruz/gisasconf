<?php
session_start();
include('conexao.php');

// Redireciona se a sacola estiver vazia
if (empty($_SESSION['sacola'])) {
    header("Location: sacola.php");
    exit();
}

// Buscar endereços do cliente

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Finalizar Pedido</title>
<link rel="stylesheet" href="finalizar_pedido.css">
</head>
<body>

<h2>Finalizar Pedido</h2>

<form method="POST" action="confirmar_pedido.php">


    <h3>2. Forma de pagamento</h3>
    <select name="pagamento" required>
        <option value="Pix">Pix</option>
        <option value="Crédito">Cartão de Crédito</option>
        <option value="Débito">Cartão de Débito</option>
        <option value="Dinheiro">Dinheiro</option>
    </select>

    <h3>Resumo do pedido</h3>
    <ul>
        <?php 
        $total = 0;
        foreach($_SESSION['sacola'] as $item) {
            echo "<li>{$item['nome']} - R$ ".number_format($item['preco'],2,',','.')."</li>";
            $total += $item['preco'];
        }
        ?>
    </ul>

    <h3>Total: R$ <?php echo number_format($total,2,',','.'); ?></h3>

    <input type="hidden" name="total" value="<?php echo $total; ?>">

    <button class="btn-confirmar">Confirmar Pedido</button>

</form>

</body>
</html>
