<?php
session_start();
include('conexao.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM admin WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

    if ($senha === $admin['senha']) {
    $_SESSION['admin_email'] = $admin['email'];
    $_SESSION['admin_nome'] = $admin['nome'];
    header('Location: painel_admin.php');
    exit();
} else {
    echo "Senha incorreta!";
}

    } else {
        echo "Administrador não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Admin - Gisas Confeitaria</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <form action="" method="POST" class="admin-form">
    <h2>Login do Administrador</h2>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <input type="submit" name="submit" value="Entrar">
  </form>
</body>
</html>
