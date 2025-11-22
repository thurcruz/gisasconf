<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['admin_email'])) {
    header('Location: admin.php');
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Produto não encontrado.");
}

$produto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Ver Produto</title>
<link rel="stylesheet" href="painel_admin.css">
</head>

<body>
<h2>Informações do Produto</h2>

<p><strong>ID:</strong> <?= $produto['id']; ?></p>
<p><strong>Nome:</strong> <?= $produto['nome']; ?></p>
<p><strong>Descrição:</strong> <?= $produto['descricao']; ?></p>
<p><strong>Preço:</strong> R$ <?= number_format($produto['preco'],2,',','.'); ?></p>
<p><strong>Status:</strong> <?= $produto['status']; ?></p>

<p>
    <img src="/<?= $produto['imagem']; ?>" style="max-width:300px; border-radius:8px;">
</p>

<a href="painel_admin.php" class="btn-gray">Voltar</a>
</body>
</html>
