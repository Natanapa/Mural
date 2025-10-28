<?php
if (session_status() === PHP_SESSION_NONE) {
    // Nenhuma sessão ativa, então criamos
    session_start();
};
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
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>HTML Slider — com título e parágrafo</title>
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
  .slide-item{ position:absolute; inset:0; display:flex; flex-direction:column; opacity:0; transform:scale(.98); transition:opacity .6s ease, transform .6s ease; }
  .slide-item.visible{ opacity:1; transform:scale(1); z-index:2; }
  iframe{ flex:1; border:none; width:100%; height:100%; border-radius:8px; background:white; }
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
  @media (max-width:980px){
    .player{ grid-template-columns: 1fr; }
    .stage{ height:420px; }
  }
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
</style>
</head>
<body>
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
              <img atr="model1" class="img-item" src="Assets/imgs/13.jpg" data-url="http://192.168.3.16/mural/poluicao/index.php" alt="Imagem 1">
              <img atr="model2" class="img-item" src="Assets/imgs/21.jpg" data-url="http://192.168.3.16/mural/muralvaga/index.php" alt="Imagem 2">
              <img atr="model3" class="img-item" src="Assets/imgs/jpg.jpg" data-url="JPG" alt="Imagem 2">
            </div>
          </div>
          <div class="small">Adicionar Imagem de Fundo</div>
          <button class="btn" id="btnToggle-2">Mostrar Modelos</button>
          <div id="galeria-2">
            <div class="grid">
              <img class="img-item-2" src="poluicao/images/Plano de Fundo.jpg" data-url="http://192.168.3.16/mural/poluicao/images/Plano de Fundo.jpg" alt="Imagem 1">
              <img class="img-item-2" src="poluicao/images/Plano de Fundo1.jpg" data-url="http://192.168.3.16/mural/poluicao/images/Plano de Fundo1.jpg" alt="Imagem 2">
              <img class="img-item-2" src="poluicao/images/plano de fundo 2.jpg" data-url="http://192.168.3.16/mural/poluicao/images/plano de fundo 2.jpg" alt="Imagem 3">
              <img class="img-item-2" src="poluicao/images/Plano de Fundo3.jpg" data-url="http://192.168.3.16/mural/poluicao/images/Plano de Fundo3.jpg" alt="Imagem 4">
              <img class="img-item-2" src="poluicao/images/Plano de fundo4.jpg" data-url="http://192.168.3.16/mural/poluicao/images/Plano de fundo4.jpg" alt="Imagem 5">
              <img class="img-item-2" src="poluicao/images/Plano de Fundo5.jpg" data-url="http://192.168.3.16/mural/poluicao/images/Plano de Fundo5.jpg" alt="Imagem 6">
              <img class="img-item-2" src="poluicao/images/Plano de Fundo6.jpg" data-url="http://192.168.3.16/mural/poluicao/images/Plano de Fundo6.jpg" alt="Imagem 7">
              <img class="img-item-2" src="poluicao/images/img_6030.png" data-url="http://192.168.3.16/mural/poluicao/images/img_6030.png" alt="Imagem 8">
            </div>
          </div>
          <!--<input id="svgUrl" type="text" placeholder="https://site/exemplo.svg" />-->
          <div>  
            <input id="svgTitulo" type="text" placeholder="Título" />
            <input id="svgparagrafo" type="text" placeholder="Parágrafo" />
            <input id="vaga" type="text" placeholder="Vaga" />
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

<script>
const stage = document.getElementById('stage');
const listEl = document.getElementById('list');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const playPauseBtn = document.getElementById('playPauseBtn');
const intervalRange = document.getElementById('interval');
const intervalLabel = document.getElementById('intervalLabel');
const addBtn = document.getElementById('addBtn');
const clearBtn = document.getElementById('clearBtn');
//const svgUrlInput = document.getElementById('svgUrl');
const svgTitulo = document.getElementById('svgTitulo');
const svgparagrafo = document.getElementById('svgparagrafo');
const vagaconst = document.getElementById('vaga');
const requisitosconst = document.getElementById('requisitos');
const salarioconst = document.getElementById('salario');
const beneficiosconst = document.getElementById('beneficios');
const btnToggle = document.getElementById('btnToggle');
const btnToggle2 = document.getElementById('btnToggle-2');
const galeria = document.getElementById('galeria');
const galeria2 = document.getElementById('galeria-2');
const btnreq = document.getElementById('btnrequisitos');
const btnbenef = document.getElementById('btnbeneficios');
const reqdiv = document.getElementById('reqdiv');
const reqcontainer = document.getElementById('requisitos-container');
const benefcontainer = document.getElementById('beneficios-container');
const jpgconst = document.getElementById('jpg');
const jpgdiv = document.getElementById('jpgdiv');
//const Titulojpg  = document.getElementById('Titulojpg');
    let imagemSelecionada = null; // variável global pra guardar a URL
    let svgUrlInput = ""
    let imgurlinput = ""
    let modelinput  = ""
    svgTitulo.style.display = 'none';
    svgparagrafo.style.display = 'none';
    vagaconst.style.display = 'none';
    requisitosconst.style.display = 'none';
    salarioconst.style.display = 'none';
    beneficiosconst.style.display = 'none';
    btnreq.style.display = 'none';
    btnbenef.style.display = 'none';
    jpgconst.style.display = 'none';
    jpgdiv.style.display = 'none';
    //Titulojpg.style.display = 'none';


    

    // Mostra/esconde a galeria
    btnToggle.addEventListener('click', () => {
      const visivel = galeria.style.display === 'flex';
      galeria.style.display = visivel ? 'none' : 'flex';
      btnToggle.textContent = visivel ? 'Mostrar Modelos' : 'Ocultar Modelos';
      
    });
    // Mostra/esconde a galeria
    btnToggle2.addEventListener('click', () => {
      const visivel = galeria2.style.display === 'flex';
      galeria2.style.display = visivel ? 'none' : 'flex';
      btnToggle2.textContent = visivel ? 'Mostrar Modelos' : 'Ocultar Modelos';
      
    });
    
    // Quando clicar em uma imagem
    document.querySelectorAll('.img-item').forEach(img => {
      img.addEventListener('click', () => {
        imagemSelecionada = img.getAttribute('data-url');
        modelselecionado = img.getAttribute('atr');
        modelinput = modelselecionado

        

        console.log("atr: "+modelinput)
        svgUrlInput = imagemSelecionada;
        const visivel = galeria.style.display === 'flex';
        galeria.style.display = visivel ? 'none' : 'flex';
        if(svgUrlInput !=="" && modelinput == "model1"){
          console.log("Passou!")
          svgTitulo.style.display = 'flex';
          svgparagrafo.style.display = 'flex';
          vagaconst.style.display = 'none';
          requisitosconst.style.display = 'none';
          salarioconst.style.display = 'none';
          beneficiosconst.style.display = 'none';
          btnreq.style.display = 'none';
          btnbenef.style.display = 'none';

          jpgconst.style.display = 'none';
          jpgdiv.style.display = 'none';
          //Titulojpg.style.display = 'none';

        }else if(svgUrlInput !=="" && modelinput == "model2"){
          vagaconst.style.display = 'flex';
          requisitosconst.style.display = 'flex';
          salarioconst.style.display = 'flex';
          beneficiosconst.style.display = 'flex';
          btnreq.style.display = 'flex';
          btnbenef.style.display = 'flex';

          svgTitulo.style.display = 'none';
          svgparagrafo.style.display = 'none';

          jpgconst.style.display = 'none';
          jpgdiv.style.display = 'none';
          //Titulojpg.style.display = 'none';
        }else{
          vagaconst.style.display = 'none';
          requisitosconst.style.display = 'none';
          salarioconst.style.display = 'none';
          beneficiosconst.style.display = 'none';
          btnreq.style.display = 'none';
          btnbenef.style.display = 'none';

          svgTitulo.style.display = 'flex';
          svgparagrafo.style.display = 'none';
          
          jpgconst.style.display = 'flex';
          jpgdiv.style.display = 'flex';
          //Titulojpg.style.display = 'flex';
        };

      });
      
    });
    document.querySelectorAll('.img-item-2').forEach(img => {
      img.addEventListener('click', () => {
        imagemSelecionada2 = img.getAttribute('data-url');
        console.log(imagemSelecionada2)
        imgurlinput = imagemSelecionada2;
        const visivel = galeria2.style.display === 'flex';
        galeria2.style.display = visivel ? 'none' : 'flex';
        btnToggle2.textContent = visivel ? 'Mostrar Modelos' : 'Ocultar Modelos';
      });
      
    });
    // Cria mais um requisito
    btnreq.addEventListener('click', () => {
      const input = document.createElement('input');
      input.type = 'text';
      input.placeholder = 'Requisito';
      input.classList.add('requisito');
      reqcontainer.appendChild(input);
    });
    // Cria mais um requisito
    btnbenef.addEventListener('click', () => {
      const input = document.createElement('input');
      input.type = 'text';
      input.placeholder = 'Beneficio';
      input.classList.add('beneficio');
      benefcontainer.appendChild(input);
    });
    // Pega todos os requisitos digitados
    const requisitos = Array.from(document.querySelectorAll('.requisito'))
      .map(input => input.value.trim())
      .filter(v => v !== '');

    // Pega todos os benefícios digitados
    const beneficios = Array.from(document.querySelectorAll('.beneficio'))
      .map(input => input.value.trim())
      .filter(v => v !== '');




let slides = [];
let teste = [];
let index = 0;
let timer = null;
let intervalSec = parseInt(intervalRange.value, 10) * 1000;

//atualizar iframe
function atiframe(){
  const iframe = document.getElementById('meuFrame');
  iframe.contentWindow.location.reload();
};
// Renderização da lista lateral
function renderList(){
  listEl.innerHTML = '';
  slides.forEach((slide, indx) => {
    const item = document.createElement('div');
    item.className = 'item' + (indx===index ? ' active' : '');
    item.innerHTML = `
      <strong>${slide.title !== null ? slide.title: slide.vaga}</strong>
      <span style="font-size:12px;color:${indx===index?"#2dd4bf":"#9fb0bf"}">${slide.text !== null ? slide.text:slide.requisitos}</span>
      <div style="display:flex; gap:6px;">
        <button class="btn" data-idx="${indx}" title="Ver">▶</button>
        <button class="btn" data-del="${indx}" title="Remover">✖</button>
      </div>`;
    item.addEventListener('click', ()=>{ show(indx); pause(); });
    item.querySelector('[data-idx]')?.addEventListener('click', ()=>{ show(indx); pause(); });
    item.querySelector('[data-del]')?.addEventListener('click', (e)=>{ e.stopPropagation(); removeAt(indx); });
    listEl.appendChild(item);
  });
}

function buildStage(){
  
    stage.innerHTML = '';
    slides.forEach((slide, indx) => {
      if(slide.url !== "JPG"){
        const wrap = document.createElement('div');
        wrap.className = 'slide-item' + (indx===index ? ' visible' : '');
        wrap.innerHTML = `<iframe id="frame" src="${slide.url}" title="${slide.title}" ></iframe>`;
        stage.appendChild(wrap);
        
      }else{
        const wrap = document.createElement('div');
        wrap.className = 'slide-item' + (indx===index ? ' visible' : '');
        wrap.innerHTML = `<img id="frame" width='1080px' height='1920px' src="${slide.urlimg}" title="${slide.title}" ></img>`;
        stage.appendChild(wrap);
        
      };
    });
  
}

function show(i){
  if(i < 0) i = slides.length - 1;
  if(i >= slides.length) i = 0;
  index = i;
  stage.querySelectorAll('.slide-item').forEach((n, idx) => {
    n.classList.toggle('visible', idx === index);
    // Monta os dados do slide atual
    
    let  urlshow = slides[i].url;
    let  titleshow = slides[i].title;
    let  textshow = slides[i].text;
    let tempo = document.getElementById("interval").value;
    let urlimgshow = slides[i].urlimg;
    let vagashow = slides[i].vaga;
    let requisitosshow = slides[i].requisitos;
    let salarioshow = slides[i].salario;
    let beneficiosshow = slides[i].beneficios;
    
    if (modelinput === "model1") {
      bodyData = { url: urlshow, title: titleshow, text: textshow, urlimg: urlimgshow, vaga: vagashow, requisitos: requisitosshow, salario: salarioshow, beneficios: beneficiosshow };
    } else {
      
      bodyData = { url: urlshow, title: titleshow, text: textshow, urlimg: urlimgshow, vaga: vagashow, requisitos: requisitosshow, salario: salarioshow, beneficios: beneficiosshow };
    }

    
    if(urlshow !=="JPG" ){
      // Envia os dados para index.php via fetch POST
      fetch(urlshow, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json' // enviando como JSON
        },
        body: JSON.stringify(bodyData)
      })
      .then(response => response.text())
      //.then(data =>{
      //      console.log(bodyData);
      //    })
      .catch(error => {
        console.error('Erro ao enviar slide:', error);
      });
    
    
    };
    renderList();
  });
}

function next(){ show((index + 1) % slides.length); }
function prev(){ show((index - 1 + slides.length) % slides.length); }

function play(){
  if(timer) return;
  timer = setInterval(next, intervalSec);
  playPauseBtn.textContent = 'Pause';
}
function pause(){
  if(!timer) return;
  clearInterval(timer);
  timer = null;
  playPauseBtn.textContent = 'Play';
}

function add(arr){
  let url = "";
  let title = "";
  let text = "";
  let Vaga = "";
  let Requisitos = "";
  let Salario = "";
  let Beneficios = "";
  let urlimg = imgurlinput
  if(!arr) return;
  // Monta o corpo da requisição conforme o modelo
  let bodyData;

  if (modelinput === "model1") {
    url = arr[0];
    title = arr[1];
    text = arr[2];
    bodyData = { url, title, text, urlimg: imgurlinput, vaga: null, requisitos: null, salario: null, beneficios: null };
    slides.push({ url: arr[0], title: arr[1], text: arr[2], urlimg: imgurlinput || null, vaga: null, requisitos: null, salario: null, beneficios: null  });
  } else if (modelinput === "model2"){
    // Aqui assumindo a ordem dos dados no array: Vaga, Requisitos, Salário, Benefícios
    const vaga = document.getElementById('vaga').value.trim();
    const salario = document.getElementById('salario').value.trim();

    // Pega todos os requisitos digitados
    const requisitos = Array.from(document.querySelectorAll('.requisito'))
      .map(input => input.value.trim())
      .filter(v => v !== '');

    // Pega todos os benefícios digitados
    const beneficios = Array.from(document.querySelectorAll('.beneficio'))
      .map(input => input.value.trim())
      .filter(v => v !== '');
    url = arr[0]
    Vaga = vaga;
    Requisitos = requisitos;
    Salario = salario;
    Beneficios = beneficios;
    
    

    bodyData = {url: url, title: null, text: null, urlimage: imgurlinput || null,vaga: Vaga, requisitos: Requisitos, salario: Salario, beneficios: Beneficios };
    slides.push({ url: url, title: null, text: null, urlimg: imgurlinput || null, vaga: Vaga, requisitos: Requisitos, salario: Salario, beneficios: Beneficios  });
    console.log(bodyData);
  }else{
    url = arr[0];
    title = arr[1];
    console.log(jpgconst.value.trim())
    bodyData = { url, title, text: "Imagem JPG, SVG, PNG.", urlimg: jpgconst.value.trim(), vaga: null, requisitos: null, salario: null, beneficios: null };
    slides.push({ url: arr[0], title: arr[1], text: null, urlimg: jpgconst.value.trim() || null, vaga: null, requisitos: null, salario: null, beneficios: null  });
  }
  
  buildStage();
  renderList();
  show(slides.length-1);
  
  fetch("slides.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(bodyData)
  })
  .then(r => r.json())
  .catch(err => document.getElementById("msg").textContent = "Erro: " + err);

}
function removeAt(i){
  if(i<0 || i>=slides.length) return;
  slides.splice(i,1);
  if(index >= slides.length) index = slides.length - 1;
  buildStage();
  renderList();
  show(index);
  console.log("atr: ",index)
  fetch('slides.php', {
    method: 'DELETE',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ index: i }) // remove o item da posição 2

  })
  .then(res => console.log(res))
  .catch(console.error);
  

}



function clearAll(){
  slides = [];
  index = 0;
  buildStage();
  renderList();
  stage.innerHTML = '';
  pause();
}

function togglePlay(){ timer ? pause() : play(); }
function changeInterval(v){
  intervalSec = parseInt(v,10) * 1000;
  intervalLabel.textContent = v + 's';
  if(timer){ pause(); play(); }
}

// Eventos
prevBtn.addEventListener('click', ()=>{ prev(); pause(); });
nextBtn.addEventListener('click', ()=>{ next(); pause(); });
playPauseBtn.addEventListener('click', togglePlay);
intervalRange.addEventListener('input', (e)=> changeInterval(e.target.value));
addBtn.addEventListener('click', ()=> {
  const v = [svgUrlInput, svgTitulo.value.trim(), svgparagrafo.value.trim()];
  if(v) { add(v); svgUrlInput.value = ''; svgTitulo.value =''; svgparagrafo.value = ''; }
  svgTitulo.style.display = 'none';
  svgparagrafo.style.display = 'none';
  vagaconst.style.display = 'none';
  requisitosconst.style.display = 'none';
  salarioconst.style.display = 'none';
  beneficiosconst.style.display = 'none';
  btnreq.style.display = 'none';
  btnbenef.style.display = 'none';
  // Pega todos os benefícios digitados
  document.querySelectorAll('.beneficio').forEach(el => {
    el.style.display = 'none';
  });
  // Pega todos os benefícios digitados
  document.querySelectorAll('.requisito').forEach(el => {
    el.style.display = 'none';
  });
});
clearBtn.addEventListener('click', ()=> { if(confirm('Limpar todos os SVGs?')) clearAll(); });

document.getElementById('fsBtn').addEventListener('click', ()=>{
  if (!document.fullscreenElement) stage.requestFullscreen();
  else document.exitFullscreen();
});

// Carrega o JSON local
fetch("slides.json?t=" + Date.now())
  .then(r => r.json())
  .then(data => {
    slides = data.slides || [];
    if(slides.length > 0){
      buildStage();
      renderList();
      show(0);
      play();
    }
  })
  .catch(err => console.error("Erro ao carregar JSON:", err));
</script>
</body>
</html>
