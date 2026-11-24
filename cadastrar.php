<?php 

require __DIR__ . '/config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($nome === '' || $email === '' || $senha === '') {
    exit('Preencha nome, e-mail e senha.');
}

$foto = $_FILES['imagemPerfil'] ?? null;

if ($foto === null || $foto['error'] === UPLOAD_ERR_NO_FILE) {
    exit('Nenhuma foto foi enviada.');
}

if ($foto['error'] !== UPLOAD_ERR_OK) {
    exit('Ocorreu um erro no envio da foto.');
}


$verificador = new finfo(FILEINFO_MIME_TYPE);
$tipoFoto = $verificador->file($foto['tmp_name']);

if ($tipoFoto === 'image/png') {
    $extensao = '.png';
} elseif ($tipoFoto === 'image/jpeg') {
    $extensao = '.jpg';
} else {
    exit('A foto precisa ser PNG ou JPEG.');
}


$nomeFoto = bin2hex(random_bytes(6)) . $extensao;
$pastaFotos = __DIR__ . '/assets/img_perfil/perfil/';

// Guarda a foto na pasta
$salvou = move_uploaded_file(
    $foto['tmp_name'],
    $pastaFotos . $nomeFoto
);

if (!$salvou) {
    exit('Não foi possível salvar a foto.');
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$consulta = $pdo->prepare(
    'INSERT INTO usuarios (nome, senha, email, imagemPerfil) VALUES (?, ?, ?, ?)'
);

$consulta->execute([$nome, $senhaHash, $email, $nomeFoto]);
}


require __DIR__ . '/includes/cabeçalho.php'; ?>

    <div class="login2">
      <div class="login3">
          
          <a href="index.php"
          onmouseover="this.style.setProperty('color', 'black', 'important')"
          class="voltar">&larr;Voltar</a>
          <h1 style="color: whitesmoke;">Crie sua conta</h1>
          <p>É rápido e você já pode começar a comprar.</p>

          <form id="form_cadastro" 
            action="/cadastrar.php"
            method="post" 
            enctype="multipart/form-data" 
            autocomplete="off">

              <p>Nome: </p>
              <input 
               type="text" 
               name="nome" 
               id="nome" 
               class="input_form"
               required>

              <p>E-mail: </p>
              <input 
              type="email"
              name="email"
              id="email"
              class="input_form"
              required>

              <p>Senha: </p>
              <input 
              type="password"
              name="senha"
              id="senha"
              class="input_form"
              required>

              <button type="submit" class="entrar">Entrar</button>

          </form>
          <div class="Fazer_login">
              <p>já possui uma conta? </p> <a href="login.php"> Fazer Login</a>
          </div>
      </div>


      <div class="foto_perfil">

       <div class="foto_preview">
            <h3>Foto de perfil:</h3>
            <div class="imagem_container">
              
                <img src="assets/img/login, cadastro.jpeg"
                id="preview">
              <button type="button" id="cancelar1" aria-label="Remover foto">
                 X
              </button>
              
                        <video 
                        id="camera" 
                        autoplay
                        playsinline
                        muted
                        ></video>
            </div>

       </div>
                <div class="botoes">
                    <button type="button" id="capturar" onclick="tirarFoto()">
                        <img src="assets/img_perfil/Tirar_foto2.png">
                    </button>
                                 
                    <button type="button" id="cancelar2" onclick="cancelarFoto()">
                       X
                    </button>
                </div>


          <div class="opções_foto">    
              <button onclick="abrirCamera()">
                <img src="assets/img_perfil/Tirar_foto.jpeg">
              </button>
              
              <input
              type="file"
              name="imagemPerfil"
              id="imagem"
              class="input_foto"
              form="form_cadastro"
              accept="image/*" >

              <label for="imagem" class="botao_galeria">
                                                              
               <img src="assets/img_perfil/Escolher.jpeg">
              
              </label>
          </div>

      </div>
    </div> 
