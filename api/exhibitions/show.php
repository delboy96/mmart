<?php

$code = 404;
$data = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Ucitavanje fajlova
    require_once '../../php/conn.php';
    require_once '../../models/exhibition.php';
    require_once '../../php/functions.php';

    $data = getExhibition($conn, $id);
    $code = 200;

    // Obrada greske ukoliko exibition ne postoji.
    if ($data === null) {
        logger('Exhibition not found.');
        $data = ['message' => 'Exhibition not found.'];
        $code = 404;
    }
}

http_response_code($code);
echo json_encode($data);