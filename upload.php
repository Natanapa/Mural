<?php
$dir = 'C:\\xampp\\htdocs\\mural\\Assets\\imgs\\';
if (!file_exists($dir)) mkdir($dir, 0777, true);

if(!isset($_FILES['files'])){
    echo "Nenhum arquivo enviado.";
    exit;
}

foreach($_FILES['files']['tmp_name'] as $i=>$tmp){
    $name = basename($_FILES['files']['name'][$i]);
    move_uploaded_file($tmp, $dir . $name);
}

echo "Upload concluído.";
?>
