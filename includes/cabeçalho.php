<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="darkreader-lock">
    <title>Personalize</title>

    <link rel="stylesheet" href="assets/index.css">

    <link rel="shortcut icon" href="assets/img/favicon.jpeg">

</head>
<body>
    <div class="cabeçalho">
    <img src="assets/img/logo.jpeg" alt="Personalize">
    
    <ul class="navegar">
        <li><a href="/index.php">início</a></li>

        <li><a href="/produtos.php">produtos</a></li>
        
        <li><a href="/sobre.php">sobre</a></li>

        <li><a href="/contato.php">contato</a></li>

        <form action="/produtos.php" method="get">
           <div class="campo_busca">
               <input type="search" name="busca" placeholder="Buscar produtos..." required>
               <button type="submit" aria-label="Pesquisar">
                <svg xmlns="http://www.w3.org/2000/svg" 
                width="24" height="24" 
                viewBox="0 0 24 24" 
                fill="none" 
                stroke="currentColor" 
                stroke-width="2" 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                class="lucide lucide-search preview-icon">
                <path d="m21 21-4.34-4.34"/>
                <circle cx="11" cy="11" r="8"/></svg>
               </button>
           </div> 
        </form>
          <?php if (empty($_SESSION['usuarios_id'])): ?>
           <a href="login.php">
             <img src="/assets/img/login,%20cadastro.jpeg"
                  class="Entrar"
                  alt="Entrar ou cadastrar">
             </a>
          <?php else: ?>
                                                                        
        <a href="/dashboard.php">
        <img src="/assets/img_perfil/perfil/<?= htmlspecialchars(
                rawurlencode(basename($_SESSION['imagemPerfil'])),
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
            class="Entrar"
            alt="Meu perfil">
              </a>
          <?php endif; ?>    </ul>
</div>

<script src="assets/script.js" defer></script>