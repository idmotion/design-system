<?php
$data = array(
    'version' => '1.1.0',
    'download_url' => 'https://updates.idmotion.com.br/unify/unify-1.1.0.zip'
);
header('Content-Type: application/json');
echo json_encode($data);
?>