<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$arquivo = __DIR__ . '/slides.json';

// Se não existir o arquivo, cria um padrão
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode(['slides' => []], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// ================================
// GET → Retorna todos os slides
// ================================
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo file_get_contents($arquivo);
    exit;
}

// ================================
// POST → Adiciona novo slide
// ================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = json_decode(file_get_contents('php://input'), true);
    error_log("vaga: ".$dados['vaga'].", "."Salario: ".$dados['salario'].",".$dados['beneficios']);

    if (!$dados) {
        echo json_encode(['erro' => 'Nenhum dado recebido']);
        exit;
    }

    // Carrega o JSON atual
    $json = json_decode(file_get_contents($arquivo), true);

    // Detecta automaticamente o tipo do modelo
    $isModelo1 = isset($dados['url'], $dados['title'], $dados['text']) && !empty($dados['url']);

    if ($isModelo1) {
        // Modelo 1 → Slide de imagem/texto
        $novo = [
            'url' => $dados['url'] ?? null,
            'title' => $dados['title'] ?? null,
            'text' => $dados['text'] ?? null,
            'urlimg' => $dados['urlimg'] ?? null,
            'vaga' => $dados['vaga'] ?? null,
            'requisitos' => $dados['requisitos'] ?? null,
            'salario' => $dados['salario'] ?? null,
            'beneficios' => $dados['beneficios'] ?? null
        ];
    } else {
        // Modelo 2 → Slide de vaga
        $novo = [
            'url' => $dados['url'] ?? null,
            'title' => $dados['title'] ?? null,
            'text' => $dados['text'] ?? null,
            'urlimg' => $dados['urlimage'] ?? null,
            'vaga' => $dados['vaga'] ?? null,
            'requisitos' => $dados['requisitos'] ?? null,
            'salario' => $dados['salario'] ?? null,
            'beneficios' => $dados['beneficios'] ?? null
        ];
    }

    // Adiciona ao array de slides
    $json['slides'][] = $novo;

    // Salva o JSON novamente
    file_put_contents($arquivo, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo json_encode(['sucesso' => true, 'modelo' => $isModelo1 ? 'modelo1' : 'modelo2']);
    exit;
}

// ================================
// DELETE → Remove um slide por índice
// ================================
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $dados = json_decode(file_get_contents('php://input'), true);
    if (!isset($dados['index'])) {
        echo json_encode(['erro' => 'Índice não especificado']);
        exit;
    }

    $json = json_decode(file_get_contents($arquivo), true);
    $index = intval($dados['index']);
    error_log($index);

    if (!isset($json['slides'][$index])) {
        echo json_encode(['erro' => 'Slide não encontrado']);
        exit;
    }

    // Remove o slide e reordena os índices
    array_splice($json['slides'], $index, 1);
    file_put_contents($arquivo, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo json_encode(['sucesso' => true, 'removido' => $index]);
    exit;
}

// ================================
// OPTIONS → Resposta CORS
// ================================
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

echo json_encode(['erro' => 'Método não suportado']);
