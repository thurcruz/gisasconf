<?php
session_start();
require 'log.php'; // Funções de log

$conn = new mysqli("localhost", "root", "", "gisasconf");
if ($conn->connect_error) die("Falha na conexão: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = trim($_POST['password'] ?? '');

    $stmt = $conn->prepare("SELECT id, nome, email, senha, cpf FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Garante que encontrou o usuário
    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verifica senha
        if (password_verify($senha, $usuario['senha'])) {

            // Guarda temporariamente dados do admin para 2FA
            $_SESSION['2fa_pending']      = $usuario['id'];
            $_SESSION['admin_real_email'] = $usuario['email'];
            $_SESSION['admin_real_nome']  = $usuario['nome'];

            // Gera código de validação
            $codigo = rand(100000, 999999);
            $_SESSION['2fa_code']   = $codigo;
            $_SESSION['2fa_expira'] = time() + 300; // 5 minutos

            // Aqui você pode enviar o email/sms
            // send_2fa_email($usuario['email'], $codigo);

            header("Location: verificar_2fa.php");
            exit();
        }
    }

    // Se chegou aqui, falhou
    http_response_code(401);
    echo "Usuário ou senha inválidos.";
}
?>
