<?php
session_start(); include('conexao.php');

if (!isset($_SESSION['admin_email'])) {
    header('Location: admin.php');
    exit();
}

// 1. Definição do diretório de upload
// Para que o upload funcione corretamente, esta variável deve ser o caminho
// no SISTEMA DE ARQUIVOS. Se o script estiver em /admin/ e a pasta uploads
// estiver no mesmo nível que /admin/, você pode usar '../uploads/'.
// Vamos assumir que o 'uploads/' está na mesma pasta do script para simplificar,
// mas o caminho CORRETO dependerá da estrutura do seu servidor.
$upload_dir = 'uploads/'; 
$upload_path = __DIR__ . '/' . $upload_dir; // Caminho absoluto no servidor

// Garante que o diretório de upload exista no sistema de arquivos
if (!is_dir($upload_path)) {
    mkdir($upload_path, 0777, true);
}


// Adicionar produto
if (isset($_POST['adicionar'])) {
    $nome = $conn->real_escape_string($_POST['nome']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $preco = $conn->real_escape_string($_POST['preco']);
    $status = 'ativo';
    
    $imagem = '';
    if (!empty($_FILES['imagem']['name'])) {
        $file_name = basename($_FILES['imagem']['name']);
        
        // 2. Caminho de destino no sistema de arquivos
        $target_file = $upload_path . $file_name;
        
        // Move o arquivo para a pasta 'uploads/'
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $target_file)) {
            // 3. Caminho salvo no banco de dados (para uso no HTML)
            // Assumimos que o diretório 'uploads' é acessível via HTTP como '/uploads/' a partir da raiz do site.
            $imagem = 'uploads/' . $file_name;
        } else {
            // Ocorreu um erro no upload (permissões ou tamanho)
            // Você pode adicionar um tratamento de erro aqui
        }
    }

    // Usando Prepared Statements para segurança (Boa Prática!)
    $sql = $conn->prepare("INSERT INTO produtos (nome, descricao, preco, imagem, status)
                             VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("sssss", $nome, $descricao, $preco, $imagem, $status);
    $sql->execute();
    $sql->close();
}

// Pausar / Excluir produto
if (isset($_GET['acao'])) {
    $id = intval($_GET['id']); // Garante que o ID seja um número inteiro
    if ($_GET['acao'] === 'pausar') {
        $conn->query("UPDATE produtos SET status = 'pausado' WHERE id = $id");
    } elseif ($_GET['acao'] === 'ativar') {
        $conn->query("UPDATE produtos SET status = 'ativo' WHERE id = $id");
    } elseif ($_GET['acao'] === 'excluir') {
        $conn->query("DELETE FROM produtos WHERE id = $id");
    }
}

$result = $conn->query("SELECT * FROM produtos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin - Gisas Confeitaria</title>
    <link rel="stylesheet" href="painel_admin.css">
    <!-- Captura da tela -->
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<!-- PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


</head>
<body>

    <header class="admin-header">
        <div class="container">
            <h2>Painel Administrativo</h2>
            <div class="admin-info">
                <span>Bem-vinda, <?php echo $_SESSION['admin_nome']; ?>!</span>
                <a href="admin_logout.php" class="logout-btn">Sair</a>
            </div>
            <button id="btnPDF" 
style="background:#c1121f;color:#fff;padding:10px 20px;border:none;cursor:pointer;border-radius:4px;">
    Baixar PDF
</button>
<a href="lista_usuarios.php" class="btn-red">Ver Usuários</a>


        </div>


    </header>

    <main class="admin-main container">

    <h3>Pedidos Recebidos</h3>

<table class="table-products">
<thead>
<tr>
    <th>ID</th>
    <th>Cliente</th>
    <th>Total</th>
    <th>Pagamento</th>
    <th>Status</th>
    <th>Ações</th>
</tr>
</thead>
<tbody>

<?php  
$ped = $conn->query("SELECT * FROM pedidos ORDER BY id DESC");
while($p = $ped->fetch_assoc()) { ?>
<tr>
    <td><?php echo $p['id']; ?></td>
    <td><?php echo $p['cliente_nome']; ?></td>
    <td>R$ <?php echo number_format($p['total'],2,',','.'); ?></td>
    <td><?php echo $p['pagamento']; ?></td>
    <td><?php echo $p['status']; ?></td>
    <td>
        <a href="ver_pedido.php?id=<?php echo $p['id']; ?>">Ver</a>
    </td>
</tr>
<?php } ?>

</tbody>
</table>


        <section class="add-product">
            <h3>Adicionar Produto</h3>
            <form method="POST" enctype="multipart/form-data" class="product-form">
                <input type="text" name="nome" placeholder="Nome do produto" required>
                <textarea name="descricao" placeholder="Descrição do produto"></textarea>
                <input type="number" step="0.01" name="preco" placeholder="Preço" required>
                <input type="file" name="imagem" accept="image/*">
                <button type="submit" name="adicionar" class="btn-red">Adicionar</button>
            </form>
        </section>

        <section class="product-list">
            <h3>Produtos Cadastrados</h3>
            <table class="table-products">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><img src="/<?php echo $row['imagem']; ?>" width="80"></td>
                        <td><?php echo $row['nome']; ?></td>
                        <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                        <td class="<?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></td>
<td>
    <div class="actions">

        <a href="ver_produto.php?id=<?php echo $row['id']; ?>" class="btn-blue">Ver</a>
        <a href="editar_produto.php?id=<?php echo $row['id']; ?>" class="btn-yellow">Editar</a>

        <?php if ($row['status'] === 'ativo') { ?>
            <a href="?acao=pausar&id=<?php echo $row['id']; ?>" class="btn-gray">Pausar</a>
        <?php } else { ?>
            <a href="?acao=ativar&id=<?php echo $row['id']; ?>" class="btn-green">Ativar</a>
        <?php } ?>

        <a href="?acao=excluir&id=<?php echo $row['id']; ?>" class="btn-red">Excluir</a>

    </div>
</td>

                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>

    </main>

    <h3>Registros de Acesso</h3>

<table class="table-products">
<thead>
<tr>
    <th>ID</th>
    <th>Usuário</th>
    <th>Ação</th>
    <th>Data/Hora</th>
    <th>IP</th>
</tr>
</thead>
<tbody>

<?php  
$logs = $conn->query("SELECT l.id_log, u.nome AS usuario, l.acao, l.timestamp_acesso, l.ip_acesso
                      FROM logs_acessos l
                      LEFT JOIN usuarios u ON u.id = l.usuario_id
                      ORDER BY l.id_log DESC 
                      LIMIT 100");

while($log = $logs->fetch_assoc()) { ?>
<tr>
    <td><?php echo $log['id_log']; ?></td>
    <td><?php echo $log['usuario'] ?: 'Desconhecido'; ?></td>
    <td><?php echo $log['acao']; ?></td>
    <td><?php echo date('d/m/Y H:i:s', strtotime($log['timestamp_acesso'])); ?></td>
    <td><?php echo $log['ip_acesso']; ?></td>
</tr>
<?php } ?>

</tbody>
</table>

<script>
document.getElementById("btnPDF").addEventListener("click", function () {
    const elemento = document.body; // captura a página inteira

    html2canvas(elemento, { scale: 2 }).then(canvas => {

        const imgData = canvas.toDataURL('image/png');

        const pdf = new jspdf.jsPDF('p', 'mm', 'a4');
        const largura = pdf.internal.pageSize.getWidth();
        const altura = (canvas.height * largura) / canvas.width;

        pdf.addImage(imgData, 'PNG', 0, 0, largura, altura);
        pdf.save("painel_admin.pdf");
    });
});
</script>

</body>
</html>