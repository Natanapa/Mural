<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$json = file_get_contents("slides.json");

if ($json === false) {
    echo json_encode(["error" => "Não foi possível abrir slides.json"]);
    exit;
}

echo $json;
