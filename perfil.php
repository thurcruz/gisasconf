<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="script.js" defer></script>
    <title>Gisas</title>
</head>

<body>
    <header>
        <picture class="top">
            <source media="(max-width: 600px)" srcset="img/assets/top_p.png">
            <source media="(max-width: 1200px)" srcset="img/assets/top_m.png">
            <img src="img/assets/top_g.png" alt="Banner superior">
        </picture>
    </header>

    <main>
        <!-- Perfil -->
        <section class="perfil">
            <p>Olá Giser! Bem-vindo(a) à sua conta.</p>
            <div class="perfil-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                </svg>
            </div>
        </section>

        <!-- Menu de opções -->
        <section class="menu-opcoes">
            <!-- Minha Conta -->
            <div class="menu-item">
                <i class="bi bi-person-circle"></i>
                <div>
                    <h3>Minha Conta</h3>
                    <a href="#">Minhas informações da conta</a>
                </div>
            </div>

            <!-- Notificações -->
            <div class="menu-item">
                <i class="bi bi-bell"></i>
                <div>
                    <h3>Notificações</h3>
                    <a href="notificação.html">Minha central de notificações</a>
                </div>
            </div>

            <!-- Pagamentos -->
            <div class="menu-item">
                <i class="bi bi-credit-card"></i>
                <div>
                    <h3>Pagamentos</h3>
                    <a href="pagamentos.html">Cartões e seus saldos</a>
                </div>
            </div>

            <!-- Endereços -->
            <div class="menu-item">
                <i class="bi bi-geo-alt"></i>
                <div>
                    <h3>Endereços</h3>
                    <a href="enederecos.html">Seus endereços salvos</a>
                </div>
            </div>

            <!-- Configurações -->
            <div class="menu-item">
                <i class="bi bi-gear"></i>
                <div>
                    <h3>Configurações</h3>
                    <a href="configuracoes.html">Ajustes do sistema</a>
                </div>
            </div>
        </section>

       <!-- Botão de sair -->
<section class="sair">
    <a href="logout.php" id="botao-sair">Sair</a>
</section>

    </main>
</body>

</html>
