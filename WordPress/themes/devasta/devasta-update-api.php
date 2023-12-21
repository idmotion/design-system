<?php
$data = array(
    'version' => '1.2.15',
    'download_url' => 'https://updates.idmotion.com.br/devasta/devasta-1.2.15.zip'
);
header('Content-Type: application/json');
echo json_encode($data);
?>
