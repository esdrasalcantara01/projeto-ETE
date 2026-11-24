<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['usuarios_id'])) {
    header('Location: /login.php');
    exit;
}

require __DIR__ . '/config/conexao.php';

$consulta = $pdo->prepare(
    'SELECT nome, email, imagemPerfil FROM usuarios WHERE id = ?'
);

$consulta->execute([$_SESSION['usuarios_id']]);
$usuario = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    exit('Usuário não encontrado.');
}

require __DIR__ . '/includes/cabeçalho.php';
?>


    <div class="perfil_user">
        <h2>Meu Perfil:</h3>
        <div class="perfil"><img
    src="/assets/img_perfil/perfil/<?= htmlspecialchars(
        rawurlencode(basename($usuario['imagemPerfil'] ?? '')),
        ENT_QUOTES,
        'UTF-8'
    ) ?>"
    width="50%"
    alt="Foto de perfil"
>
            <div class="perfil_descrição">

              <div class="acoes_perfil">
                <button id="editar_perfil" type="button">✎</button>
                <button id="salvar_perfil" type="button" hidden>✓</button>
                <button id="cancelar_perfil" type="button" hidden>✕</button>
              </div>
              
              <h1>
                <?= htmlspecialchars($usuario['nome'], ENT_QUOTES, 'UTF-8') ?>
              </h1>
              
              <p>
                Nome:
               <span id="nome_texto">
                <?= htmlspecialchars($usuario['nome'], ENT_QUOTES, 'UTF-8') ?>
               </span>

               <input
                type="text"
                id="nome_input"
                value="{{ current_user.nome }}"
                hidden>
              </p>

              <p>
               E-mail:
               <span id="email_texto">
                <?= htmlspecialchars($usuario['nome'], ENT_QUOTES, 'UTF-8') ?>
               </span>

               <input
               type="email"
               id="email_input"
               value="{{ current_user.email }}"
               hidden>
              </p>

            </div>
        </div>
    </div>

    <div class="pedidos_user">
        <h2>Meus Pedidos:</h2>
        <div class="pedidos">

            <h3>Placa de Vídeo</h3>
            <img src="https://patoloco.com.br/resize/imagecache/651555f6f1aacbed847b7847b01e0600.jpeg">

        </div>
    </div>

