<?php

header('Content-Type: application/json');

$code = 404;
$data = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Ucitavanje fajlova
    require_once '../../php/conn.php';
    require_once '../../php/queries.php';

    $data = getProject($conn, $id);
    $code = 200;

    // Obrada greske ukoliko exibition ne postoji.
    if ($data === null) {
        $data = ['message' => 's not found.'];
        $code = 404;
    }

    $errors = [];
    $tmp = [];
    parse_str(file_get_contents("php://input"), $tmp);

    var_dump($_FILES);

//    echo '<pre>';
//    var_dump(json_encode($data));
//    echo '</pre>';


    // prihvatis podake iz
    $data = $tmp;

    // TODO: validation
}

http_response_code($code);
echo json_encode($data);