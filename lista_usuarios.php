<?php
session_start();
include('conexao.php');

// Bloqueia acesso sem login admin
if (!isset($_SESSION['admin_email'])) {
    header('Location: admin.php');
    exit();
}

// Consulta usuários
$sql = "SELECT id, nome, email, cpf FROM usuarios ORDER BY id DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Lista de Usuários</title>
<link rel="stylesheet" href="painel_admin.css">
</head>
<body>

<header class="admin-header">
    <div class="container">
        <h2>Usuários Cadastrados</h2>
        <div class="admin-info">
            <span>Bem-vinda, <?php echo $_SESSION['admin_nome']; ?>!</span>
            <a href="admin_logout.php" class="logout-btn">Sair</a>
        </div>
    </div>
</header>

<main class="admin-main container">

<section class="product-list">
    <h3>Lista de Usuários</h3>

    <table class="table-products">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>CPF</th>
                <th>Criado em</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['cpf']; ?></td>
            </tr>
            <?php } ?>
        </tbody>

    </table>

</section>

</main>

</body>
</html>
