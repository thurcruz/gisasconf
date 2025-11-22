document.getElementById('loginForm')?.addEventListener('submit', async function(event) {
    event.preventDefault();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    if (!email || !password) { alert("Preencha todos os campos!"); return; }

    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);

    try {
        const response = await fetch('login.php', { method: 'POST', body: formData });
        if (response.redirected) window.location.href = response.url;
        else alert("Usuário ou senha inválidos!");
    } catch (error) {
        console.error(error);
        alert("Erro ao tentar fazer login.");
    }
});
