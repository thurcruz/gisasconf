<?php
session_start();
include('conexao.php');

// Buscar pedidos (todos, já que não tem usuario_id)
$result = $conn->query("SELECT * FROM pedidos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Meus Pedidos</title>
<link rel="stylesheet" href="meus_pedidos.css">
</head>
<body>

<h2>Meus Pedidos</h2>

<?php 
if ($result->num_rows === 0) {
    echo "<p>Você ainda não fez nenhum pedido.</p>";
}

while($p = $result->fetch_assoc()) { ?>
<div class="pedido">
    <strong>Pedido #<?php echo $p['id']; ?></strong><br>
    Total: R$ <?php echo number_format($p['total'],2,',','.'); ?><br>
    Pagamento: <?php echo $p['pagamento']; ?><br>
    Status: <span class="status"><?php echo $p['status']; ?></span>
</div>
<?php } ?>

</body>
</html>
