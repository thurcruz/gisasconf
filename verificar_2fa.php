<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['2fa_pending'])) {
    header('Location: login.php');
    exit();
}

$user_id = intval($_SESSION['2fa_pending']);
$MAX_ATTEMPTS = 5;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = trim($_POST['codigo'] ?? '');

    if (!ctype_digit($codigo) || strlen($codigo) !== 4) {
        $erro = "Digite exatamente 4 números.";
    } else {
        $stmt = $conn->prepare("SELECT nome, cpf FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows !== 1) {
            session_destroy();
            die("Erro interno.");
        }

        $row = $res->fetch_assoc();

        // Remove pontos e traço do CPF antes de extrair
        $cpf_limpo = preg_replace('/\D/', '', $row['cpf']);

        if (strlen($cpf_limpo) < 4) {
            $erro = "CPF inválido registrado no sistema.";
        } else {
            $cpf_last4 = substr($cpf_limpo, -4);

            if ($codigo === $cpf_last4) {

                $_SESSION['usuario_id'] = $user_id;
                $_SESSION['usuario_nome'] = $row['nome'];

                unset($_SESSION['2fa_pending']);
                unset($_SESSION['2fa_attempts']);

                header('Location: index.php');
                exit();

            } else {
                $_SESSION['2fa_attempts']++;
                $restante = $MAX_ATTEMPTS - $_SESSION['2fa_attempts'];

                if ($_SESSION['2fa_attempts'] >= $MAX_ATTEMPTS) {
                    unset($_SESSION['2fa_pending']);
                    unset($_SESSION['2fa_attempts']);
                    $erro = "Tentativas excedidas. Faça login novamente.";
                } else {
                    $erro = "Código incorreto. Restam {$restante} tentativas.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Validação de CPF</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial;
    background: #f5f5f5;
    height: 100vh;
    display: flex;
    flex-direction: column;
}

.top img {
    width: 100%;
    display: block;
}

.container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.box {
    background: white;
    width: 350px;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
}

input {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    font-size: 20px;
    text-align: center;
}

button {
    width: 100%;
    margin-top: 15px;
    padding: 12px;
    background: #AB0827;
    color: white;
    border: none;
    font-size: 16px;
    cursor: pointer;
    border-radius: 24px;
}

button:hover {
    background: #900620;
}

.voltar {
    margin-top: 12px;
    text-align: center;
}

.voltar a {
    color: #AB0827;
    font-weight: bold;
    text-decoration: none;
}

.voltar a:hover {
    text-decoration: underline;
}

.error {
    color: red;
    margin-bottom: 10px;
}
</style>
</head>
<body>

<picture class="top">
    <source media="(max-width: 600px)" srcset="img/assets/top_p.png" />
    <source media="(max-width: 1200px)" srcset="img/assets/top_m.png" />
    <img src="img/assets/top_g.png" />
</picture>

<div class="container">
<div class="box">
    <h3>Verificação • Últimos 4 dígitos do CPF</h3>

    <?php if (!empty($erro)) echo "<p class='error'>$erro</p>"; ?>

    <form method="POST">
        <input type="text" name="codigo" maxlength="4" placeholder="0000" required>
        <button type="submit">Confirmar</button>
    </form>

    <div class="voltar">
        <a href="login.php">Voltar</a>
    </div>
</div>
</div>

</body>
</html>

