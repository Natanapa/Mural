
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
if(!isset($_SESSION['imgurl'])){
    $_SESSION['imgurl'] = "http://nada.com/img";
}

if(!isset($_SESSION['title'])){
    $_SESSION['title'] = "Nada Por Enquanto!";
}

if(!isset($_SESSION['text'])){
    $_SESSION['text'] = "Muito Menos aqui Por enquanto!";
}


if ($_SERVER['REQUEST_METHOD']=== 'POST'){
  
  // Recebe JSON do desenv.php
  $data = json_decode(file_get_contents('php://input'), true);
  if ($data) {
      

      if (isset($data['url'])) {
          $_SESSION['url'] = $data['url'];
      }
      if (isset($data['urlimg'])) {
          $_SESSION['imgurl'] = $data['urlimg'];
      }

      if (isset($data['title'])) {
          $_SESSION['title'] = $data['title'] ?? '';
      }

      if (isset($data['text'])) {
          $_SESSION['text'] = $data['text'] ?? '';
      }

      if (isset($data['acao'])) {
          $_SESSION['acao'] = $data['acao'] ?? '';
      }
      if (isset($data['tempo'])) {
          $_SESSION['tempo'] = $data['tempo'] ?? '';
      }

      
      // Se quiser usar as variáveis localmente também:
      $url   = $_SESSION['url']   ?? '';
      $title = $_SESSION['title'] ?? '';
      $text  = $_SESSION['text']  ?? '';
      $acao  = $_SESSION['acao']  ?? '';
      $tempo  = $_SESSION['tempo']  ?? 5;
      $imgurl = $_SESSION['imgurl'] ?? '';
      

      



      //error_log("Title: ".$title." Text: ".$text);
      if ( isset($acao) && $acao === 'atualizar') {
        $data = ["status" => "ok", "url" => $url, "title" => $title, "text" => $text, "tempo"=>$tempo, "acao" => 'atualizar', "imgurl"=> $imgurl];
        
        echo json_encode(["status" => "ok", "url" => $url, "title" => $title, "text" => $text, "tempo"=>$tempo, "acao" => 'atualizar', "imgurl"=> $imgurl]);
      } else {
        $data = ["status" => "ok", "url" => $url, "title" => $title, "text" => $text, "tempo" =>$tempo, "imgurl"=> $imgurl];
        
        echo json_encode(["status" => "ok", "url" => $url, "title" => $title, "text" => $text, "tempo" =>$tempo, "imgurl"=> $imgurl]);
      }
      // Retorna os dados como resposta (pode ser usado para log ou debug)
      
      exit; // termina a requisição POST
  };
};
?>

<!doctype html>
<html>
  <head>
    <title>Slides Mural</title>
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
      
      <img id="slideimg" class="img_6030" src="images/IMG_6030.svg" alt="" style="width: 1080px; height: 70%; ">
      <div style="width: 70vw; justify-self: center; margin: 10px 10px 10px 10px;">
        <div style="width: 70vw; justify-self: center; margin: 10px 10px 10px 10px;">
          <p class="text" id="text" ></p>
        </div>
        <div style="width: 70vw; justify-self: center; margin: 10px 10px 10px 10px; justify-content: center; align-items: center;">
          <p class="text-2" id="text-2" ></p>
        </div>
      </div>
      <img class="logo_rhede-horizontal-principal" src="images/Logo_Rhedel.svg" alt="" style="width: 380px;">
      <div class="row group">
        <div class="layer"></div>
        <div class="layer-2"></div>
        <div class="layer-3"></div>
        <div class="layer-4"></div>
      </div>
    </div>
    <script>
      const titleEl = document.getElementById('text');
      const textEl = document.getElementById('text-2');
      const imgEl = document.getElementById('slideimg')

      // Função para atualizar os dados do slide
      function atualizarSlide(title, text){
          titleEl.textContent = title;
          textEl.textContent = text;
      }
      function feat(){
        fetch('index.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify({ acao: 'atualizar' })
        
        })
        .then(response => response.json()) // converte o retorno PHP em JSON
        .then(data =>{
          atualizarSlide(data.title, data.text);
          if(data.imgurl !== "http://192.168.3.16/mural-main/"){
            imgEl.src = data.imgurl
          }else{
            imgEl.src = "images/IMG_6030.svg"
          };
        })
      }
      fetch('index.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ acao: 'atualizar' })
      
      })
      .then(response => response.json()) // converte o retorno PHP em JSON
      .then(data =>{
        atualizarSlide(data.title, data.text);
        const intervaloMs = data.tempo * 1000; // converte pra milissegundos
        if(data.imgurl !== "http://192.168.3.16/mural-main/"){
            imgEl.src = data.imgurl
          }else{
            imgEl.src = "images/IMG_6030.svg"
          };
        // exemplo: controlar a troca de slides
        setInterval(() => {
          feat();
        }, 900);
      })

      
      
    </script>
  </body>
</html>