<?php

header('Content-Type: application/json');

$code = 404;
$data = null;

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Ucitavanje fajlova
    require_once '../../php/conn.php';
    require_once '../../php/queries.php';

    $data = getExhibition($conn, $id);

    if ($data === null) {
        $code = 404;
        $data = ['message' => 'Exhibition not found.'];
    }

    if (deleteExhibition($conn, $id)) {
        // TODO: remove file from server
        unlink($data->image);
        $code = 204;
        $data = null;
    } else {
        $code = 500;
        $data = ['message' => 'Server error.'];
    }
}

http_response_code($code);
echo json_encode($data);