

const inputImagem = document.getElementById("imagem");
const preview = document.getElementById("preview");
const cancelarbutton1 = document.getElementById("cancelar1");
const cancelarbutton2 = document.getElementById("cancelar2");


if (inputImagem && preview && cancelarbutton1) {

    // Guarda a imagem original
    const imagemPadrao = preview.src;

    let urlTemporaria = null;

    inputImagem.addEventListener("change", function () {
        const arquivo = this.files[0];

        if (!arquivo) return;

        cancelarbutton1.style.display = "block";

        // Libera a URL temporária anterior
        if (urlTemporaria) {
            URL.revokeObjectURL(urlTemporaria);
        }

        urlTemporaria = URL.createObjectURL(arquivo);

        preview.src = urlTemporaria;
        preview.style.display = "block";
        
    });

    
    cancelarbutton1.addEventListener("click", function () {

        // Limpa o arquivo selecionado
        inputImagem.value = "";

        // Restaura a imagem padrão
        preview.src = imagemPadrao;
        preview.style.display = "block";

        // Esconde o botão X
        cancelarbutton1.style.display = "none";

        // Libera a URL temporária
        if (urlTemporaria) {
            URL.revokeObjectURL(urlTemporaria);
            urlTemporaria = null;
        }
    });
}


const camera = document.getElementById("camera");
const botaoCapturar = document.getElementById("capturar");
const cancelar2 = document.getElementById("cancelar2");
const cancelar1 = document.getElementById("cancelar1")

let streamCamera = null;

// Abrir câmera
async function abrirCamera() {

cancelar1.style.display = "none"
cancelar2.style.display = "block"

    try {
        streamCamera = await navigator.mediaDevices.getUserMedia({
            video: true,
            audio: false
        });

        camera.srcObject = streamCamera;

        await camera.play();

        preview.style.display = "none";
        camera.style.display = "block";

        // Mostra os dois botões
        botaoCapturar.style.display = "block";

        // Esconde o X de remover foto durante a câmera
        cancelarbutton1.style.display = "block";

    } catch (erro) {
        console.error("Erro ao abrir câmera:", erro);
    }
}

// Cancelar câmera
function cancelarFoto() {

cancelar2.style.display = "none"
botaoCapturar.style.display = "none"


    if (streamCamera) {
        streamCamera.getTracks().forEach(function(track) {
            track.stop();
        });

        streamCamera = null;
    }

    camera.pause();
    camera.srcObject = null;

    // Esconde vídeo e botões
    camera.style.display = "none";

    // Restaura a imagem anterior
    preview.style.display = "block";

    // Mostra o X somente se houver foto selecionada
    cancelarbutton1.style.display =
        inputImagem.files.length > 0 ? "block" : "none";
}


function tirarFoto() {

    // Verifica se a câmera está funcionando
    if (!streamCamera || !camera.videoWidth) {
        return;
    }

    // Cria um canvas temporário
    const canvas = document.createElement("canvas");

    canvas.width = camera.videoWidth;
    canvas.height = camera.videoHeight;

    // Captura o quadro atual da câmera
    const contexto = canvas.getContext("2d");
    contexto.translate(canvas.width, 0);
    contexto.scale(-1, 1);
    contexto.drawImage(camera, 0, 0);

    // Converte a imagem capturada em arquivo
    canvas.toBlob(function(blob) {

        if (!blob) return;

        const arquivo = new File(
            [blob],
            "foto_perfil.png",
            { type: "image/png" }
        );

        // Coloca a foto no input do formulário
        const transferencia = new DataTransfer();
        transferencia.items.add(arquivo);

        inputImagem.files = transferencia.files;

        // Atualiza o preview
        preview.src = URL.createObjectURL(arquivo);
        preview.style.display = "block";

        // Mostra o X para remover a foto
        cancelarbutton1.style.display = "block";

        // Desliga a câmera
        cancelarFoto();

    }, "image/png");
}


const editar = document.getElementById("editar_perfil");
const salvar = document.getElementById("salvar_perfil");
const cancelar = document.getElementById("cancelar_perfil");

const nomeTexto = document.getElementById("nome_texto");
const emailTexto = document.getElementById("email_texto");

const nomeInput = document.getElementById("nome_input");
const emailInput = document.getElementById("email_input");


if (
    editar && salvar && cancelar &&
    nomeTexto && emailTexto &&
    nomeInput && emailInput
) {
    editar.addEventListener("click", () => {
        nomeInput.value = nomeTexto.textContent;
        emailInput.value = emailTexto.textContent;

        nomeTexto.hidden = true;
        emailTexto.hidden = true;

        nomeInput.hidden = false;
        emailInput.hidden = false;

        editar.hidden = true;
        salvar.hidden = false;
        cancelar.hidden = false;
    });

    cancelar.addEventListener("click", () => {
        nomeTexto.hidden = false;
        emailTexto.hidden = false;

        nomeInput.hidden = true;
        emailInput.hidden = true;

        editar.hidden = false;
        salvar.hidden = true;
        cancelar.hidden = true;
    });

    salvar.addEventListener("click", () => {
        if (!nomeInput.value.trim() || !emailInput.value.trim() ||
            !emailInput.validity.valid) {
            alert("Preencha os campos corretamente!");
            return;
        }

        nomeTexto.textContent = nomeInput.value.trim();
        emailTexto.textContent = emailInput.value.trim();

        nomeTexto.hidden = false;
        emailTexto.hidden = false;

        nomeInput.hidden = true;
        emailInput.hidden = true;

        editar.hidden = false;
        salvar.hidden = true;
        cancelar.hidden = true;
    });
}