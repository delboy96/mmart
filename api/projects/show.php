<?php

$code = 404;
$data = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Ucitavanje fajlova
    require_once '../../php/conn.php';
    require_once '../../models/project.php';
    require_once '../../php/functions.php';

    $data = getProject($conn, $id);
    $code = 200;

    // Obrada greske ukoliko exibition ne postoji.
    if ($data === null) {
        logger('Project not found.');
        $data = ['message' => 'Project not found.'];
        $code = 404;
    }
}

http_response_code($code);
echo json_encode($data);