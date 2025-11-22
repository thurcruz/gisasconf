<?php
session_start();
require 'log.php';

// Conexão com o banco (mesma do login)
$conn = new mysqli("localhost", "root", "", "gisasconf");
if ($conn->connect_error) die("Falha na conexão: " . $conn->connect_error);

// Se o usuário estiver logado, registra o LOGOUT
if (isset($_SESSION['usuario_id'])) {
    log_acesso_arquivo($_SESSION['usuario_id'], "LOGOUT");
    log_acesso_db($conn, $_SESSION['usuario_id'], "LOGOUT");
}

// Destrói sessão
session_destroy();

// Redireciona
header('Location: index.php');
exit();
?>
