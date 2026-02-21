function renderList(){
  el.listEl.innerHTML = '';
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
    el.listEl.appendChild(item);
  });
}
function escapeHtml(s) {
  return String(s ?? "").replace(/[&<>"']/g, (m) => ({
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    "'": "&#039;"
  }[m]));
}

function buildvaga(slide) {
  let listaRequisitosHTML = '';
  let listaBeneficiosHTML = '';

  const requisitos = Array.isArray(slide.requisitos) ? slide.requisitos : [];
  const beneficios = Array.isArray(slide.beneficios) ? slide.beneficios : [];

  for (let i = 0; i < requisitos.length; i++) {
    listaRequisitosHTML += `<li>${escapeHtml(requisitos[i])}</li>`;
  }
  for (let i = 0; i < beneficios.length; i++) {
    listaBeneficiosHTML += `<li>${escapeHtml(beneficios[i])}</li>`;
  }

  return `
    <div class="prancheta-1">
      <div class="col-2">
        <div class="row group">
          <div class="col-5">
            <p class="text">A Rhede Transformadores está contratando!</p>
            <p class="vaga">VAGA:</p>
          </div>
          <img class="logo_rhede-horizontal-principal" src="http://192.168.3.69/mural-main/muralvaga/images/logo_rhede-horizontal-pri.png" alt="">
        </div>

        <div id="vaga" class="layer-holder">${escapeHtml(slide.vaga)}</div>

        <div class="col-4">
          <p class="text-3">Sobre a Rhede</p>
          <p class="text-4">
            Somos uma empresa líder nacional na recuperação de transformadores para distribuidoras de energia elétrica.
            Atuamos com excelência, inovação e compromisso com nossos clientes e colaboradores.
          </p>

          <div class="wrapper-6 group">
            <p class="requisitos">Requisitos</p>
            <ul id="listrequisitos" class="listrequisitos">${listaRequisitosHTML}</ul>
          </div>

          <p class="text-7">Salário</p>
          <p id="salario" class="text-8">${escapeHtml(slide.salario || "A combinar.")}</p>

          <div class="wrapper-6 group">
            <p class="text-9">Benefícios</p>
            <ul id="listbeneficios" class="listrequisitos">${listaBeneficiosHTML}</ul>
          </div>
        </div>

        <div class="col group">
          <p class="text-14">
            Para saber mais sobre essa vaga e se candidatar,
            <strong class="fw600">envie um curriculo no email abaixo</strong>
            ou &nbsp;pelo <strong class="fw600">QR code: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
            <strong><a href="mailto:rh@rhede.ind.br" class="text-style">rh@rhede.ind.br</a></strong>
          </p>
          <img class="qr-code" src="http://192.168.3.69/mural-main/muralvaga/images/qr-code.png" alt="">
        </div>

        <div class="row-2 group">
          <img class="logo_rhede-horizontal-negativa" src="http://192.168.3.69/mural-main/muralvaga/images/logo_rhede-horizontal-neg.png" alt="">
          <p class="text-15">Faça parte de uma equipe que valoriza seu crescimento!</p>
        </div>
      </div>
    </div>
  `;
}

// monta um HTML completo (com head, css e body)
function buildVagaDocument(slide, opts = {}) {
  const title = opts.title || (slide.vaga ? `Vaga - ${slide.vaga}` : "Vaga");
  const cssHref = opts.cssHref || "http://192.168.3.69/mural-main/muralvaga/style.css"; // pode passar URL absoluta se precisar

  return `<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>${escapeHtml(title)}</title>
  <link rel="stylesheet" href="${cssHref}">
  <style>
    /* Estilos adicionais para garantir que a vaga ocupe toda a tela */
    body, html {
      width: 1080px;
      height: 1920px;
      max-width: 1080px;
      max-height: 1920px;
    }
    .col-2 {
      height: 1920px;
    }
    .col-5{
      margin: 124px 0 0;
    }
    .text-3{
      font-size: font-size: 4.6875rem;
    }
    .text-4{
      font-size: 2.06rem;
      margin: 96px 0 0 5.11245%;
    }
    .requisitos{  
      font-size: 3.6875rem;
      margin: 1.5% 0 0 2.111245%;
    }
    .listrequisitos{
      font-size: 2.06rem;
    }
    .text-3{
      font-size: 3.6875rem;
      margin: 0 0 0 4.811245%;
    }
    .text-7{
      font-size: 3.6875rem;
      margin: 1.5% 0 0 4.811245%;
    }
    .text-8{
      font-size: 2.06rem;
    }
    .text-9{
      font-size: 3.6875rem;
      margin: 0px 9.045977% 15px 20px;
    }
    .col{
      left: 30.49074%;
      width: 34.574074%;
      margin: -201px auto 0;
    }
    .row-2{
      margin: 75px auto 0;
    }
    .col-4{
      min-height: 1087px;
    }
    .text-14{
      font-size: 1.4625rem;
    }
    .text-15{
      font-size: 2.65rem;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

</head>
<body>
<button id="btnDownloadJPG">Baixar JPG</button>

  ${buildvaga(slide)}
</body>
<script>
  function baixarJPGDaVaga(nomeArquivo = "vaga.jpg") {
    const prancheta = document.querySelector('.prancheta-1');

    if (!prancheta) {
      alert("Nenhuma prancheta encontrada.");
      return;
    }

    html2canvas(prancheta, {
      scale: 2, // aumenta a qualidade
      useCORS: true,
      backgroundColor: "#ffffff"
    }).then(canvas => {
      const link = document.createElement('a');
      link.download = nomeArquivo;
      link.href = canvas.toDataURL("image/jpeg", 0.95);
      link.click();
    });
  }
  document.getElementById('btnDownloadJPG').addEventListener('click', () => {
    baixarJPGDaVaga("vaga.jpg");
  }); 
</script>
</html>`;
}

/**
 * 1) Abre uma página temporária (nova aba) com o HTML gerado
 */
function openVagaTempPage(slide, opts = {}) {
  const html = buildVagaDocument(slide, opts);
  const blob = new Blob([html], { type: "text/html;charset=utf-8" });
  const url = URL.createObjectURL(blob);

  // precisa ser chamado a partir de clique do usuário (browser bloqueia popups)
  const w = window.open(url, "_blank");
  if (!w) alert("O navegador bloqueou o popup. Tente clicar novamente e permitir popups.");
  
  // opcional: liberar depois de um tempo
  setTimeout(() => URL.revokeObjectURL(url), 60_000);
}

/**
 * 2) Faz download de um .html gerado com os parâmetros do slide
 */
function downloadVagaHtml(slide, opts = {}) {
  const html = buildVagaDocument(slide, opts);
  const blob = new Blob([html], { type: "text/html;charset=utf-8" });
  const url = URL.createObjectURL(blob);

  const nome = (opts.filename || `vaga_${(slide.vaga || "slide").slice(0,30).replace(/\s+/g,"_")}.html`);

  const a = document.createElement("a");
  a.href = url;
  a.download = nome;
  document.body.appendChild(a);
  a.click();
  a.remove();

  URL.revokeObjectURL(url);
}

function buildStage(){
    
    stage.innerHTML = '';
    slides.forEach((slide, indx) => {
      if(slide.url !== "JPG"){
        const wrap = document.createElement('div');
        wrap.className = 'slide-item' + (indx===index ? ' visible' : '');
        wrap.style.inlineSize = "fit-content";
        

        wrap.innerHTML = buildvaga(slide);

        
      stage.appendChild(wrap);
        
      }else{
        const wrap = document.createElement('div');
        wrap.className = 'slide-item' + (indx===index ? ' visible' : '');
        wrap.innerHTML = `<img id="frame"  src="${site_url}/${slide.urlimg}" title="${slide.title}" ></img>`;
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
    
    let  urlshow = site_url+"/"+slides[i].url;
    let  titleshow = slides[i].title;
    let  textshow = slides[i].text;
    let tempo = document.getElementById("interval").value;
    let urlimgshow = site_url+"/"+slides[i].urlimg;
    let vagashow = slides[i].vaga;
    let requisitosshow = slides[i].requisitos;
    let salarioshow = slides[i].salario;
    let beneficiosshow = slides[i].beneficios;
    
    if (modelinput === "model1") {
      bodyData = { url: urlshow, title: titleshow, text: textshow, urlimg: urlimgshow, vaga: vagashow, requisitos: requisitosshow, salario: salarioshow, beneficios: beneficiosshow };
      coso
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
    const vaga = document.getElementById('vagainput').value;
    const salario = document.getElementById('salario').value;

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
    console.log(el.jpgconst.value.trim())
    bodyData = { url, title, text: "Imagem JPG, SVG, PNG.", urlimg: el.jpgconst.value.trim(), vaga: null, requisitos: null, salario: null, beneficios: null };
    slides.push({ url: arr[0], title: arr[1], text: null, urlimg: el.jpgconst.value.trim() || null, vaga: null, requisitos: null, salario: null, beneficios: null  });
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