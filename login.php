<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['password'] ?? '';

    $consulta = $pdo->prepare(
        'SELECT id, nome, senha, imagemPerfil
         FROM usuarios WHERE email = ?'
    );

    $consulta->execute([$email]);
    $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
     

    if (!$usuario || !password_verify($senha, $usuario['senha'])) {
        exit('E-mail ou senha incorretos.');
    }

    session_regenerate_id(true);

    $_SESSION['usuarios_id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['imagemPerfil'] = $usuario['imagemPerfil'];

    session_write_close();
    header('Location: /index.php');
    exit;
}

require __DIR__ . '/includes/cabeçalho.php';
?>


    <div class="login1">
        <a href="index.php"
        onmouseover="this.style.setProperty('color', 'black', 'important')" 
        class="voltar">&larr;Voltar</a>
        <h1 style="color: whitesmoke;">Bem-vindo de volta.</h1>
        <p>Faça login para acessar sua conta.</p>

        <form method="post" action="/login.php">
        
            <p>Seu E-mail:</p>
             <input 
             type="email" 
             name="email" 
             id="email" 
             class="input_form"
             required>

            <p>Sua Senha:</p>
            <input 
            type="password"
            name="password"
            id="senha"
            class="input_form">

            <button type="submit" class="entrar">Entrar</button>

        </form>

        <div class="Fazer_login">
            <p>ainda não possui uma conta? </p>
                <a href="cadastrar.php">
                Cadastre-se</a>
        </div>
    </div>

