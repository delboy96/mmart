<?php

header('Content-Type: application/json');

$code = 404;
$data = null;

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Ucitavanje fajlova
    require_once '../../php/conn.php';
    require_once '../../models/project.php';
    require_once '../../php/functions.php';

    $data = getProject($conn, $id);

    if ($data === null) {
        logger('Project not found.');
        $code = 404;
        $data = ['message' => 'Project not found.'];
    }

    if (deleteProject($conn, $id)) {
        // TODO: remove file from server
        unlink($data->image);
        $code = 204;
        $data = null;
    } else {
        logger('Server error.');

        $code = 500;
        $data = ['message' => 'Server error.'];
    }
}

http_response_code($code);
echo json_encode($data);