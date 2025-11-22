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

if (isset($_POST['salvar'])) {

    $nome = $conn->real_escape_string($_POST['nome']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $preco = $conn->real_escape_string($_POST['preco']);
    $status = $conn->real_escape_string($_POST['status']);

    // Atualizar imagem somente se o admin subir outra
    $imagem = $produto['imagem'];

    if (!empty($_FILES['imagem']['name'])) {
        $dir = "uploads/";
        $path = $dir . basename($_FILES["imagem"]["name"]);
        move_uploaded_file($_FILES["imagem"]["tmp_name"], $path);
        $imagem = $path;
    }

    $update = $conn->prepare("UPDATE produtos SET nome=?, descricao=?, preco=?, status=?, imagem=? WHERE id=?");
    $update->bind_param("sssssi", $nome, $descricao, $preco, $status, $imagem, $id);
    $update->execute();

    header("Location: painel_admin.php?edit_ok=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar Produto</title>
<link rel="stylesheet" href="painel_admin.css">
</head>

<body>
<h2>Editar Produto</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Nome:</label>
    <input type="text" name="nome" value="<?= $produto['nome']; ?>" required>

    <label>Descrição:</label>
    <textarea name="descricao"><?= $produto['descricao']; ?></textarea>

    <label>Preço:</label>
    <input type="number" step="0.01" name="preco" value="<?= $produto['preco']; ?>" required>

    <label>Status:</label>
    <select name="status">
        <option value="ativo" <?= $produto['status']=='ativo'?'selected':''; ?>>Ativo</option>
        <option value="pausado" <?= $produto['status']=='pausado'?'selected':''; ?>>Pausado</option>
    </select>

    <label>Imagem atual:</label><br>
    <img src="/<?= $produto['imagem']; ?>" width="200"><br><br>

    <label>Alterar imagem:</label>
    <input type="file" name="imagem" accept="image/*">

    <button type="submit" name="salvar" class="btn-green">Salvar Alterações</button>
</form>

<a href="painel_admin.php" class="btn-gray">Voltar</a>

</body>
</html>
