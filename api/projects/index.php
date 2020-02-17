<?php

$code = 404;
$data = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ucitavanje fajlova
    require_once '../../php/conn.php';
    require_once '../../php/queries.php';

    $data = getProjects($conn);
    $code = 200;
}

http_response_code($code);
echo json_encode($data);