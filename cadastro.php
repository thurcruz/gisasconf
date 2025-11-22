<?php
session_start();
$conn = new mysqli("localhost", "root", "", "gisasconf");
if ($conn->connect_error) die("Erro ao conectar: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $nome_materno = trim($_POST['nomeMaterno'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $telefone = trim($_POST['telefone'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar = $_POST['confirmar-senha'] ?? '';
    $cpf = trim($_POST['cpf'] ?? '');
    $data_nasc = $_POST['data-nascimento'] ?? '';
    $genero = $_POST['gender'] ?? '';
    $cep = trim($_POST['cep'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $estado = trim($_POST['estado'] ?? '');
    $rua = trim($_POST['rua'] ?? '');

    if ($senha !== $confirmar) die("As senhas não coincidem.");

    // Verifica email/CPF duplicado
    $stmt_check = $conn->prepare("SELECT id FROM usuarios WHERE email = ? OR cpf = ?");
    $stmt_check->bind_param("ss", $email, $cpf);
    $stmt_check->execute();
    $stmt_check->store_result();
    if ($stmt_check->num_rows > 0) die("Email ou CPF já cadastrado.");
    $stmt_check->close();

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios 
        (nome, nome_materno, email, telefone, senha, cpf, data_nascimento, genero, cep, cidade, estado, rua) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $nome, $nome_materno, $email, $telefone, $senha_hash, $cpf, $data_nasc, $genero, $cep, $cidade, $estado, $rua);

    if ($stmt->execute()) {
        $_SESSION['usuario_id'] = $stmt->insert_id;
        $_SESSION['usuario_nome'] = $nome;
        header("Location: index.php");
        exit();
    } else die("Erro ao cadastrar: " . $stmt->error);

    $stmt->close();
    $conn->close();
}
?>
