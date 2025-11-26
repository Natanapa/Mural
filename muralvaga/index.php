
<?php
if (session_status() === PHP_SESSION_NONE) {
    // Nenhuma sessão ativa, então criamos
    session_start();
};
// Permite qualquer origem (ou restrinja ao seu domínio)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if(!isset($_SESSION['url'])){
    $_SESSION['url'] = "http://nada.com";
}
if(!isset($_SESSION['vaga'])){
    $_SESSION['vaga'] = "Nenhuma Por enquanto!";
}

if(!isset($_SESSION['requisitos'])){
    $_SESSION['requisitos'] = "Sem Requisitos!";
}

if(!isset($_SESSION['salario'])){
    $_SESSION['salario'] = "Sem Salario!";
}
if(!isset($_SESSION['beneficios'])){
    $_SESSION['beneficios'] = "Sem Beneficio!";
}


if ($_SERVER['REQUEST_METHOD']=== 'POST'){
  
  // Recebe JSON do desenv.php
  $data = json_decode(file_get_contents('php://input'), true);
  if ($data) {

      
      
      if (isset($data['url'])) {
          $_SESSION['url'] = $data['url'];
      }
      if (isset($data['vaga'])) {
          $_SESSION['vaga'] = $data['vaga'];
      }

      if (isset($data['requisitos'])) {
          $_SESSION['requisitos'] = $data['requisitos'] ?? '';
      }

      if (isset($data['salario'])) {
          $_SESSION['salario'] = $data['salario'] ?? '';
      }
      if (isset($data['beneficios'])) {
          $_SESSION['beneficios'] = $data['beneficios'] ?? '';
      }

      if (isset($data['acao'])) {
          $_SESSION['acao'] = $data['acao'] ?? '';
      }
      if (isset($data['tempo'])) {
          $_SESSION['tempo'] = $data['tempo'] ?? '';
      }

      
      // Se quiser usar as variáveis localmente também:
      $url   = $_SESSION['url']   ?? '';
      $vaga = $_SESSION['vaga'] ?? '';
      $requisitos  = $_SESSION['requisitos']  ?? '';
      $salario = $_SESSION['salario'];
      $beneficios = $_SESSION['beneficios'];
      $acao  = $_SESSION['acao']  ?? '';
      $tempo  = $_SESSION['tempo']  ?? 5;
      
    

      



      //error_log("Title: ".$vaga." Text: ".$requisitos);
      if ( isset($acao) && $acao === 'atualizar') {
        $data = ["status" => "ok", "url" => $url, "vaga" => $vaga, "requisitos" => $requisitos, "salario"=> $salario, "beneficios"=> $beneficios, "tempo"=>$tempo,  "acao" => 'atualizar'];
          
        echo json_encode(["status" => "ok", "url" => $url, "vaga" => $vaga, "requisitos" => $requisitos, "salario"=> $salario, "beneficios"=> $beneficios,  "acao" => 'atualizar', "tempo"=>$tempo]);
      } else {
        $data = ["status" => "ok", "url" => $url, "vaga" => $vaga, "requisitos" => $requisitos,"salario"=> $salario, "tempo" =>$tempo, "beneficios"=> $beneficios];
        
        echo json_encode(["status" => "ok", "url" => $url, "vaga" => $vaga, "requisitos" => $requisitos, "salario"=> $salario, "tempo" =>$tempo, "beneficios"=> $beneficios]);
      }
      // Retorna os dados como resposta (pode ser usado para log ou debug)
      
      exit; // termina a requisição POST
  };
}
?>
<!doctype html>
<html>
  <head>
    <title>Your site's title should be here</title>
    <meta charset="UTF-8">
    <meta name="description" content="Your site's description should be here">
    <meta name="keywords" content="Your site's keywords should be here">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" href="style.css"> 
    <!--[if IE 6]>
	<style type="text/css">
		* html .group {
			height: 1%;
		}
	</style>
  <![endif]--> 
    <!--[if IE 7]>
	<style type="text/css">
		*:first-child+html .group {
			min-height: 1px;
		}
	</style>
  <![endif]--> 
    <!--[if lt IE 9]> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script> 
  <![endif]--> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed:100,200,300,regular,500,600,700,800,900,100italic,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin,latin-ext,vietnamese">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,200,300,regular,500,600,700,800,900,100italic,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin,latin-ext,math,symbols,vietnamese">
  </head>
  <body>
    <div class="prancheta-1">
      <div class="col-2">
        <div class="row group">
          <div class="col-5">
            <p class="text">A Rhede Transformadores está contratando!</p>
            <p class="vaga">VAGA:</p>
          </div>
          <img class="logo_rhede-horizontal-principal" src="images/logo_rhede-horizontal-pri.png" alt="">
        </div>
        <div id="vaga" class="layer-holder">
          Auxiliar Técnico de Laboratório
        </div>
        <div class="col-4">
          <p class="text-3">Sobre a Rhede</p>
          <p class="text-4">Somos uma empresa líder nacional na recuperação de transformadores para distribuidoras de energia elétrica. Atuamos com excelência, inovação e compromisso com nossos clientes e colaboradores.</p>
          <p class="requisitos">Requisitos</p>
          <ul id="listrequisitos" class="listrequisitos">
            
          </ul>
          
          <p class="text-7">Salário</p>
          <p id="salario" class="text-8">A combinar.</p>
          <div class="wrapper-6 group">
            <p class="text-9">Benefícios</p>
            <ul id="listbeneficios" class="listrequisitos">
            
            </ul>
          </div>
        </div>
        <div class="col group">
          <p class="text-14">Para saber mais sobre essa vaga e se candidatar, <strong class="fw600">envie um curriculo no email abaixo</strong> ou &nbsp;pelo <strong class="fw600">QR code: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong><strong><a href="mailto:rh@rhede.ind.br" class="text-style">rh@rhede.ind.br</a></strong></p>
          <img class="qr-code" src="images/qr-code.png" alt="">
        </div>
        <div class="row-2 group">
          <img class="logo_rhede-horizontal-negativa" src="images/logo_rhede-horizontal-neg.png" alt="">
          <p class="text-15">Faça parte de uma equipe que valoriza seu crescimento!</p>
        </div>
      </div>
    </div>
    <script>
      const vagaco = document.getElementById('vaga');
      const Requisitosco = document.getElementById('listrequisitos');
      const Salarioco = document.getElementById('salario');
      const Beneficiosco = document.getElementById('listbeneficios');

      // Função para atualizar os dados do slide
      function atualizarSlide(vaga, requisitos, salario, beneficios){
          vagaco.textContent = vaga;
          ///
          // limpa o conteúdo antigo (opcional)
          Requisitosco.innerHTML = '';

        
          requisitos.forEach(item => {
          const li = document.createElement('li'); // cria o <li>
          li.textContent = item;                   // define o texto
          li.classList.add('teste'); // adiciona a classe CSS
          Requisitosco.appendChild(li);            // adiciona na <ul>
          });

          
          Salarioco.textContent = salario;

          Beneficiosco.innerHTML = '';
          
          ///
          
          beneficios.forEach(item => {
          const li = document.createElement('li'); // cria o <li>
          li.textContent = item;                   // define o texto
          Beneficiosco.appendChild(li);            // adiciona na <ul>
          });
      }
      function feat(){
        fetch('index.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify({ acao: 'atualizar' })
        
        })
        .then(response => response.json()) // converte o retorno PHP em JSON
        .then(data =>{
          //console.log(data.beneficios)
          atualizarSlide(data.vaga, data.requisitos, data.salario, data.beneficios );
        })
      }
      fetch('index.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ acao: 'atualizar' })
      
      })
      .then(response => response.json()) // converte o retorno PHP em JSON
      .then(data =>{
        atualizarSlide(data.vaga, data.requisitos, data.salario, data.beneficios );
        // exemplo: controlar a troca de slides
        setInterval(() => {
          feat();
        }, 900);
      })

      
      
    </script>
  </body>
</html>