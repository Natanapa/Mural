HTML Slider / Mural de Slides Dinâmico

Olá Tudo bom? Estou desenvolvendo um sistema de mural de slides interativo utilizando ferramenteas como PHP e JavaScript/AJAX, capaz de alternar automaticamente entre páginas HTML, imagens e outros conteúdos, com suporte a diferentes modelos de dados e interface de controle, a ideia principal é criar um modelo paginado em HTML e passar dados como imagens e textos pra poder complementar o modelo e apresentar como um mural, nos exemplos é utilizado valores da Emrpresa Rhede Transformadores um dos Líderes em reforma de trasnformadores.

Funcionalidades:

     Slider dinâmico com intervalos configuráveis (1–30 segundos). Obs: Pode ser alterado em código pra rodar em minutos

     Suporte a iframe (páginas externas/locais) e imagens (JPG, PNG, SVG). Obs: Por enquanto os Slides suportam somente iframes já predefinidos como nos modelos apresentados

     Modelos de slides diferentes:



    Modelo 1: Título, parágrafo e Imagem.

    Modelo 2: Vaga, requisitos, salário e benefícios.

    Modelo 3: Imagem pura (JPG, PNG, GIF, SVG).



    Lista lateral com slides carregados, com botões para visualizar ou remover.

    Galerias de seleção para modelos e imagens de fundo.

    Controle total via botões: play/pause, próximo/anterior, fullscreen.

    Persistência de dados via slides.json.

    Atualização em tempo real via AJAX sem recarregar a página.

Tecnologias Utilizadas
    Back-end	PHP 7+ (endpoint JSON)
    Front-end	HTML5, CSS3, JavaScript (ES6+)
    Comunicação	AJAX (fetch API)
    Dados	    JSON (slides.json)
    Servidor	Apache (XAMPP, WAMP ou LAMP)


Instalação e Configuração

Clone o repositório:

git clone https://github.com/SEU_USUARIO/mural.git


Coloque os arquivos no servidor local:

No XAMPP/WAMP, copie para htdocs/mural (ou similar).

Acesse via navegador:

http://localhost/mural/index.php

Observações Técnicas

O slider utiliza fetch para enviar dados via POST e DELETE para slides.php.

A página suporta múltiplos modelos de slide e galerias de imagens, permitindo flexibilidade de conteúdo, se atentando a largura máxima de 1080px e a altura devendo ser de 1920px.

O JSON (slides.json) é carregado no carregamento da página e atualizado dinamicamente.

Esse modelo é feito apenas para telas do tamanho de 1080X1920(modo retrato), e não possui nenhuma atualização para dinamismo de vários tamanhos de telas.


README feito com ajuda do CHATGPT