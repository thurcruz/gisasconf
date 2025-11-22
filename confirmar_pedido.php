<?php
session_start();
include('conexao.php');

// Impedir acesso direto
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: finalizar_pedido.php");
    exit();
}

if (!isset($_SESSION['sacola']) || empty($_SESSION['sacola'])) {
    echo "Erro: sacola vazia.";
    exit();
}

$pagamento = $_POST['pagamento'];
$total = floatval($_POST['total']); // garantia de número

// Criar pedido
$stmt = $conn->prepare("
    INSERT INTO pedidos (pagamento, total) 
    VALUES (?, ?)
");
$stmt->bind_param("sd", $pagamento, $total);
$stmt->execute();

$pedido_id = $stmt->insert_id;
$stmt->close();

// Inserção dos itens da sacola
foreach ($_SESSION['sacola'] as $item) {

    $sql = $conn->prepare("
        INSERT INTO pedidos_itens 
        (pedido_id, produto_id, nome, preco, obs, imagem)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $sql->bind_param(
        "iisdss",      // tipos
        $pedido_id,    // i
        $item['id'],   // i
        $item['nome'], // s
        $item['preco'],// d
        $item['obs'],  // s
        $item['imagem']// s
    );

    $sql->execute();
    $sql->close();
}

// Limpar sacola
unset($_SESSION['sacola']);

header("Location: meus_pedidos.php");
exit();
