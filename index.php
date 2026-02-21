<?php
if (session_status() === PHP_SESSION_NONE) {
    // Nenhuma sessão ativa, então criamos
    session_start();
};
// Carrega configuração disponível:
$config = require __DIR__ . '/config.php';


$site_url = $config['site_url'];

// ===============================
// BLOCO PHP — endpoint JSON
// ===============================
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if (isset($_GET['action']) && $_GET['action'] === 'get') {
    header('Content-Type: application/json; charset=utf-8');
    $jsonFile = __DIR__ . '/slides.json';
    if (file_exists($jsonFile)) {
        echo file_get_contents($jsonFile);
    } else {
        echo json_encode(["error" => "Arquivo slides.json não encontrado"]);
    }
    exit;
}
define('IMG_BASE_PATH', 'assets/imgs/');
define('IMAGEM_SELECIONADA', ''); // ainda não será usada

function listarArquivos($dir)
{
    $result = [];
    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file == '.' || $file == '..') continue;

        $fullPath = $dir . '/' . $file;

        if (is_dir($fullPath)) {
            $result[] = [
                'type' => 'dir',
                'name' => $file,
                'path' => $fullPath
            ];
        } else {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'])) {
                $result[] = [
                    'type' => 'img',
                    'name' => $file,
                    'path' => $fullPath
                ];
            }
        }
    }

    return $result;
}

$arquivos = listarArquivos(__DIR__ . '/' . IMG_BASE_PATH);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>HTML Slider — com título e parágrafo</title>
<link rel="stylesheet" href="assets/styles/style.css">
<link rel="stylesheet" href="muralvaga/style.css">
<style>
  :root{
    --bg:#071022;
    --card:#0f1724;
    --accent:#2dd4bf;
    --muted:#9fb0bf;
  }
  html,body{ height:100%; margin:0; font-family:Inter,system-ui,Arial,Segoe UI; background:var(--bg); color:#e6eef6; }
  .wrap{ max-width:1100px; margin:28px auto; padding:18px; }
  .player{ background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(0,0,0,0.06)); border-radius:12px; padding:18px; box-shadow:0 8px 30px rgba(2,6,23,0.6); display:grid; grid-template-columns: 1fr 320px; gap:18px; align-items:start; }
  .stage{ background:rgba(255,255,255,0.02); border-radius:10px; height:520px; display:flex; flex-direction:column; position:relative; overflow:hidden; }
  .slide-item{ position:absolute; inset:0; display:flex;  opacity:0; transform:scale(.98); transition:opacity .6s ease, transform .6s ease; justify-content: center; align-items: center;}
  .slide-item.visible{ opacity:1; z-index:2; }
  iframe{ flex:1; border:none; max-width:705px; height:1253px; border-radius:8px; background:white;}
  .caption{ padding:10px; background:rgba(0,0,0,0.4); }
  .caption h3{ margin:0; color:var(--accent); }
  .caption p{ margin:4px 0 0; color:#e6eef6; font-size:14px; }
  .controls { padding:8px; display:flex; flex-direction:column; gap:12px; }
  .controls .buttons { display:flex; gap:8px; align-items:center; }
  .btn { background:transparent; border:1px solid rgba(255,255,255,0.06); padding:8px 10px; border-radius:8px; color:inherit; cursor:pointer; }
  .btn.primary{ background:var(--accent); color:#072027; border:none; }
  .small{ font-size:13px; color:var(--muted); }
  .list { max-height:300px; overflow:auto; border-radius:8px; padding:8px; background:rgba(255,255,255,0.01); }
  .list .item { display:flex; flex-direction:column; gap:4px; padding:6px; border-radius:6px; }
  .list .item.active{ background:rgba(45,212,191,0.06); }
  input[type="text"]{ width:100%; padding:8px 10px; border-radius:8px; border:1px solid rgba(255,255,255,0.04); background:transparent; color:inherit; margin: 5px; padding: 5px; }
  footer{ margin-top:14px; text-align:center; color:var(--muted); font-size:13px; }
  /* @media (max-width:1471px){
    .player{ grid-template-columns: 1fr; }
    .stage{ height:420px; }
    .slide-item{ position:absolute; inset:0; display:flex;  opacity:0; transform:scale(.98); transition:opacity .6s ease, transform .6s ease; justify-content: center; align-items: center;}
    .slide-item.visible{ opacity:1; transform:scale(1); z-index:2; }
    iframe{ flex:1; border:none; max-width:707px; height:1450px; border-radius:8px; background:white;}
    #frame{
      width: 7      height: 1271px;
    }
    
  } */
  #galeria {
      position: fixed;           /* Fica sobre tudo */
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      display: none;             /* Oculta por padrão */
      justify-content: center;   /* Centraliza horizontalmente */
      align-items: center;       /* Centraliza verticalmente */
      background: rgba(0, 0, 0, 0.5); /* Fundo escurecido */
      z-index: 9999;             /* Fica acima de todos elementos */
    }
    #galeria .grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr); /* 4 colunas fixas */
      gap: 20px;                              /* Espaçamento entre imagens */
      max-width: 80vw;                        /* Limita a largura total */
      max-height: 80vh;
      overflow-y: auto;                       /* Rolagem se passar da tela */
      background: rgba(0, 0, 0, 0.5); /* Fundo escurecido */
      padding: 20px;
      border-radius: 12px;
    }
    #galeria-2 .grid img{
      width: 100%;
      height: auto;
      cursor: pointer;
      border-radius: 8px;
      transition: transform 0.2s;
    }
    #galeria-2 .grid img:hover{
      transform: scale(1.05);
    }
    .img-item {
      width: 360px;
      height: 640px;
      object-fit: cover;
      cursor: pointer;
      border-radius: 10px;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .img-item:hover {
      transform: scale(1.1);
      box-shadow: 0 0 8px rgba(0,0,0,0.4);
    }
    #galeria-2 {
      position: fixed;           /* Fica sobre tudo */
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      display: none;             /* Oculta por padrão */
      justify-content: center;   /* Centraliza horizontalmente */
      align-items: center;       /* Centraliza verticalmente */
      background: rgba(0, 0, 0, 0.5); /* Fundo escurecido */
      z-index: 9999;             /* Fica acima de todos elementos */
    }
    #galeria-2 .grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr); /* 4 colunas fixas */
      gap: 20px;                              /* Espaçamento entre imagens */
      max-width: 80vw;                        /* Limita a largura total */
      max-height: 80vh;
      overflow-y: auto;                       /* Rolagem se passar da tela */
      background: rgba(0, 0, 0, 0.5); /* Fundo escurecido */
      padding: 20px;
      border-radius: 12px;
    }
    #galeria-2 .grid img{
      width: 100%;
      height: auto;
      cursor: pointer;
      border-radius: 8px;
      transition: transform 0.2s;
    }
    #galeria-2 .grid img:hover{
      transform: scale(1.05);
    }
    .img-item-2 {
      width: 360px;
      height: 640px;
      object-fit: cover;
      cursor: pointer;
      border-radius: 10px;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .img-item-2:hover {
      transform: scale(1.1);
      box-shadow: 0 0 8px rgba(0,0,0,0.4);
    }
    .reqbenef{
      display: flex;
      flex-direction: row;
    }
    .fullscreen-rotate {
      transform: rotate(90deg);
      transform-origin: center center;
      width: 100vh !important;
      height: 100vw !important;
      object-fit: cover;
    }
    #frame{
      width: 705px;
      height: 1253px;
      justify-self: center;
      object-fit: contain;
    }
    .prancheta-1{
      width: 705px;
      height: 1253px;
      justify-self: center;
      object-fit: contain;
    }
    #none{
      display: none;
    }
    
</style>

</head>
<body>
  <div id="upload" class="filho">
    <div class="container">

        <h2>Enviar Arquivos</h2>

        <div class="upload-area">
            <p>Selecione fotos, GIFs ou SVGs</p>
            <label for="file" class="select-btn">Selecionar arquivos</label>
            <input type="file" id="file" multiple>
        </div>

        <button id="sendBtn" onclick="upload()">Enviar</button>

        <div id="msg"></div>

    </div>

    <script>
    function upload() {
        let files = document.getElementById('file').files;

        if (!files.length) {
            alert('Selecione os arquivos primeiro.');
            return;
        }

        let form = new FormData();
        for (let f of files) {
            form.append('files[]', f);
        }

        fetch('upload.php', {
            method: 'POST',
            body: form
        })
        .then(r => r.text())
        .then(t => {
            let msg = document.getElementById('msg');
            msg.style.display = "block";
            msg.className = t.includes("sucesso") ? "success" : "error";
            msg.innerHTML = t;
        })
        .catch(e => alert("Erro: " + e));
    }
  </script>
</div>
  <div class="wrap">
    <h2 style="margin:0 0 8px 0; color:var(--accent)">HTML Slider — troca a cada 5s</h2>
    <div class="player" role="application" aria-label="HTML Slider">
      <div class="stage" id="stage" aria-live="polite"></div>

      <div class="controls">
        <div>
          <div class="buttons">
            <button class="btn" id="prevBtn">◀</button>
            <button class="btn primary" id="playPauseBtn">Pause</button>
            <button class="btn" id="nextBtn">▶</button>
            <button class="btn" id="fsBtn">⛶</button>
            <button class="btn" id="upbtn">⭱</button>
            <button class="btn" id="crot" >▭↻</button>
            <button class="btn" id="temphtml">html</button>
            
          </div>
          <div class="small" style="margin-top:8px;">Intervalo (segundos)</div>
          <div class="rangeRow">
            <input id="interval" type="range" min="1" max="30" value="5" />
            <div class="small" id="intervalLabel">5s</div>
          </div>
        </div>
        <div>
          <div class="small" style="margin-bottom:6px;">Slides carregados</div>
          <div class="list" id="list"></div>
        </div>
        <div>
          <div class="small">Adicionar modelo a utilizar</div>
          <button class="btn" id="btnToggle">Mostrar Modelos</button>

          <div id="galeria">
            <div class="grid">
              <img atr="model1" class="img-item" src="Assets/imgs/13.jpg" data-url="poluicao/index.php" alt="Imagem 1">
              <img atr="model2" class="img-item" src="Assets/imgs/21.jpg" data-url="muralvaga/index.php" alt="Imagem 2">
              <img atr="model3" class="img-item" src="Assets/imgs/jpg.jpg" data-url="JPG" alt="Imagem 2">
            </div>
          </div>
          <div class="small">Adicionar Imagem de Fundo</div>
          <button class="btn" id="btnToggle-2">Mostrar Modelos</button>
          <div id="galeria-2">
            <div class="grid">
              <img class="img-item-2" src="poluicao/images/Plano de Fundo.jpg" data-url= "/poluicao/images/Plano de Fundo.jpg" alt="Imagem 1">
              <img class="img-item-2" src="poluicao/images/Plano de Fundo1.jpg" data-url= "/poluicao/images/Plano de Fundo1.jpg" alt="Imagem 2">
              <img class="img-item-2" src="poluicao/images/plano de fundo 2.jpg" data-url="/poluicao/images/plano de fundo 2.jpg" alt="Imagem 3">
              <img class="img-item-2" src="poluicao/images/Plano de Fundo3.jpg" data-url="/poluicao/images/Plano de Fundo3.jpg" alt="Imagem 4">
              <img class="img-item-2" src="poluicao/images/Plano de fundo4.jpg" data-url="/poluicao/images/Plano de fundo4.jpg" alt="Imagem 5">
              <img class="img-item-2" src="poluicao/images/Plano de Fundo5.jpg" data-url="/poluicao/images/Plano de Fundo5.jpg" alt="Imagem 6">
              <img class="img-item-2" src="poluicao/images/Plano de Fundo6.jpg" data-url="/poluicao/images/Plano de Fundo6.jpg" alt="Imagem 7">
              <img class="img-item-2" src="poluicao/images/img_6030.png" data-url="/poluicao/images/img_6030.png" alt="Imagem 8">
            </div>
          </div>
          <!--<input id="svgUrl" type="text" placeholder="https://site/exemplo.svg" />-->
          <div>
            <button class ="btn primary" id="btnAbrir">Selecionar imagem</button> 
            <input id="svgTitulo" type="text" placeholder="Título" />
            <input id="svgparagrafo" type="text" placeholder="Parágrafo" />
            <input id="vagainput" type="text" placeholder="Vaga" />
            <div id="reqdiv" class="reqbenef">
              <div id="requisitos-container">  
                <input class="requisito" id="requisitos" type="text" placeholder="Requisitos" />
              </div>
              <button id="btnrequisitos" class="btn" id="btnrequisitos" title="Requisitos">✚</button>
            </div>
            <input id="salario" type="text" placeholder="Salário"/>
            <div class="reqbenef">
              <div id="beneficios-container">
                <input class="beneficio" id="beneficios" type="text" placeholder="Benefícios" />
              </div>
              <button id="btnbeneficios" class="btn"  title="btnbeneficios">✚</button>
            </div>
            
            <!-- MODAL -->
            <div id="modal" class="modal">
                <div class="modal-content">
                    <span id="fechar">&times;</span>
                    <h2>Arquivos disponíveis</h2>

                    <div class="grid">
                        <?php foreach ($arquivos as $item): ?>
                            <?php if ($item['type'] === 'dir'): ?>
                                <div class="folder">
                                    📁 <?= htmlspecialchars($item['name']) ?>
                                </div>
                            <?php else: ?>
                                <div class="image-box" data-path="<?= IMG_BASE_PATH . basename($item['path']) ?>">
                                    <img src="<?= IMG_BASE_PATH . basename($item['path']) ?>" alt="">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <script src="assets/scripts/script.js"></script>
            <!--<input id="Titulojpg" type="text" placeholder="Titulo"/>-->
            <input id="jpg" type="text" placeholder="Url da Imagem"/>
            <div id="jpgdiv" class="small">Você pode usar caminhos locais (ex: <code>svgs/meu.svg</code>) se hospedar junto ao HTML.</div>
          </div>
            <div style="display:flex; gap:8px; margin-top:8px;">
            <button class="btn" id="addBtn">Adicionar</button>
            <button class="btn" id="clearBtn">Limpar tudo</button>
          </div>
        </div>
      </div>
    </div>
    <footer>HTML Slider — alterna automaticamente entre páginas HTML</footer>
  </div>

<script src="funcoes.js"></script>
<script>
// helpers (NÃO usa show)
const $ = (id) => document.getElementById(id);

const vis = (el, on = true, mode = 'flex') => {
  if (!el) return;
  el.style.display = on ? mode : 'none';
};

const oculta = (el) => vis(el, false);

const toggleVis = (el, mode = 'flex') => {
  if (!el) return;
  const isOn = el.style.display === mode;
  el.style.display = isOn ? 'none' : mode;
};

// pega tudo em um objeto
const el = {
  temphtml: $('temphtml'),
  stage: $('stage'),
  listEl: $('list'),
  prevBtn: $('prevBtn'),
  nextBtn: $('nextBtn'),
  upbtn: $('upbtn'),
  uploadimg: $('upload'),
  playPauseBtn: $('playPauseBtn'),
  intervalRange: $('interval'),
  intervalLabel: $('intervalLabel'),
  addBtn: $('addBtn'),
  clearBtn: $('clearBtn'),

  svgTitulo: $('svgTitulo'),
  svgparagrafo: $('svgparagrafo'),
  vagaconst: $('vagainput'),
  requisitosconst: $('requisitos'),
  salarioconst: $('salario'),
  beneficiosconst: $('beneficios'),

  btnToggle: $('btnToggle'),
  btnToggle2: $('btnToggle-2'),
  galeria: $('galeria'),
  galeria2: $('galeria-2'),

  btnreq: $('btnrequisitos'),
  btnbenef: $('btnbeneficios'),

  btnAbrir: $('btnAbrir'),
  reqcontainer: $('requisitos-container'),
  benefcontainer: $('beneficios-container'),

  jpgconst: $('jpg'),
  jpgdiv: $('jpgdiv'),

  fsBtn: $('fsBtn'),
  btnchange: $('crot'),
};

// PHP
const site_url = "<?php echo $site_url; ?>";

// estado
let imagemSelecionada = null;
let svgUrlInput = "";
let imgurlinput = "";
let modelinput  = "";

// grupos de campos
const fieldsModel1 = [el.svgTitulo, el.svgparagrafo];
const fieldsModel2 = [el.vagaconst, el.requisitosconst, el.salarioconst, el.beneficiosconst, el.btnreq, el.btnbenef];
const fieldsJpg    = [el.svgTitulo, el.jpgconst, el.jpgdiv, el.btnAbrir];

// esconde tudo no início
[
  el.svgTitulo, el.svgparagrafo,
  el.vagaconst, el.requisitosconst, el.salarioconst, el.beneficiosconst,
  el.btnreq, el.btnbenef,
  el.jpgconst, el.jpgdiv,
  el.uploadimg, el.btnAbrir
].forEach(oculta);

// troca UI por modelo
function setMode(mode){
  [...fieldsModel1, ...fieldsModel2, ...fieldsJpg].forEach(oculta);

  if (mode === "model1"){
    vis(el.svgTitulo, true);
    vis(el.svgparagrafo, true);
  } else if (mode === "model2"){
    fieldsModel2.forEach(x => vis(x, true));
  } else if (mode === "model3") { // JPG
    vis(el.svgTitulo, true);
    vis(el.jpgconst, true);
    vis(el.jpgdiv, true);
    vis(el.btnAbrir, true);
  }
}

// toggle upload (corrigido)
el.upbtn.addEventListener('click', () => {
  toggleVis(el.uploadimg, 'block');
});

// toggle galerias
el.btnToggle.addEventListener('click', () => {
  const visivel = el.galeria.style.display === 'flex';
  el.galeria.style.display = visivel ? 'none' : 'flex';
  el.btnToggle.textContent = visivel ? 'Mostrar Modelos' : 'Ocultar Modelos';
});

el.btnToggle2.addEventListener('click', () => {
  const visivel = el.galeria2.style.display === 'flex';
  el.galeria2.style.display = visivel ? 'none' : 'flex';
  el.btnToggle2.textContent = visivel ? 'Mostrar Modelos' : 'Ocultar Modelos';
});

// clique nos modelos
document.querySelectorAll('.img-item').forEach(img => {
  img.addEventListener('click', () => {
    imagemSelecionada = img.getAttribute('data-url');
    modelinput = img.getAttribute('atr'); // model1/model2/model3
    svgUrlInput = imagemSelecionada || "";

    el.galeria.style.display = 'none';
    el.btnToggle.textContent = 'Mostrar Modelos';

    setMode(modelinput);
  });
});

// clique nos backgrounds
document.querySelectorAll('.img-item-2').forEach(img => {
  img.addEventListener('click', () => {
    imgurlinput = img.getAttribute('data-url') || "";
    el.galeria2.style.display = 'none';
    el.btnToggle2.textContent = 'Mostrar Modelos';
  });
});

// adicionar inputs
el.btnreq.addEventListener('click', () => {
  const input = document.createElement('input');
  input.type = 'text';
  input.placeholder = 'Requisito';
  input.classList.add('requisito');
  el.reqcontainer.appendChild(input);
});

el.btnbenef.addEventListener('click', () => {
  const input = document.createElement('input');
  input.type = 'text';
  input.placeholder = 'Beneficio';
  input.classList.add('beneficio');
  el.benefcontainer.appendChild(input);
});

// coletar valores (use na hora de salvar)
function coletarRequisitos(){
  return Array.from(document.querySelectorAll('.requisito'))
    .map(i => i.value.trim())
    .filter(Boolean);
}
function coletarBeneficios(){
  return Array.from(document.querySelectorAll('.beneficio'))
    .map(i => i.value.trim())
    .filter(Boolean);
}

// slider state (mantém seu show() do slider intacto)
let slides = [];
let index = 0;
let timer = null;
let intervalSec = parseInt(el.intervalRange.value, 10) * 60 * 1000;

// eventos do slider
el.prevBtn.addEventListener('click', ()=>{ prev(); pause(); });
el.nextBtn.addEventListener('click', ()=>{ next(); pause(); });
el.playPauseBtn.addEventListener('click', togglePlay);
el.intervalRange.addEventListener('input', (e)=> changeInterval(e.target.value));

el.addBtn.addEventListener('click', ()=> {
  const v = [svgUrlInput, el.svgTitulo.value.trim(), el.svgparagrafo.value.trim()];
  if (v) add(v);

  // limpa campos e esconde UI
  svgUrlInput = "";
  el.svgTitulo.value = '';
  el.svgparagrafo.value = '';
  setMode("none");

  document.querySelectorAll('.beneficio, .requisito').forEach(x => x.style.display = 'none');
});

el.clearBtn.addEventListener('click', ()=> { if(confirm('Limpar todos os SVGs?')) clearAll(); });

el.fsBtn.addEventListener('click', ()=>{
  if (!document.fullscreenElement) el.stage.requestFullscreen();

  else document.exitFullscreen();
});

// carrega slides
fetch("slides.json?t=" + Date.now())
  .then(r => r.json())
  .then(data => {
    slides = data.slides || [];
    if(slides.length){
      buildStage();
      renderList();
      show(0); // <- sua função show do slider continua sendo usada aqui
      play();
    }
  })
  .catch(console.error);

// rotação
let rotated = false;
el.btnchange.onclick = () => {
  rotated = !rotated;
  el.stage.querySelectorAll('.slide-item').forEach(n => {
    n.style.transform = rotated ? 'rotate(0deg)' : 'rotate(-90deg)';
  });
};
temphtml.onclick = () =>{
  if (slides[index].url === "JPG") {
    alert("Esse slide é imagem (JPG). HTML é só para slides de vaga.");
    return;
  }

  window.openVagaTempPage(slides[index]);
}
</script>
</body>
</html>
