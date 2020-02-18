<?php

header('Content-Type: application/json');

$code = 404;
$data = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $data = [
        'title' => $_POST['title'] ?? '',
        'subtitle' => $_POST['subtitle'] ?? '',
        'body' => $_POST['body'] ?? '',
        'image' => $_FILES['image'] ?? null
    ];

    // Maksimalna velicina slike za upload
    define('FILE_SIZE', 2097152); // 2 MB

    // Dozvoljeni fajl tipovi
    $allowedExtensions = [
        'image/jpg',
        'image/png',
        'image/jpeg',
    ];
    //TODO: Validation

    if (!$data['title']) {
        $errors[] = 'Title is required.';
    }

    if (!$data['subtitle']) {
        $errors[] = 'Subtitle is required.';
    }

    if (!$data['body']) {
        $errors[] = 'Body is required.';
    }

    if (!in_array($data['image']['type'], $allowedExtensions)) {
        $error[] = 'Image type must be one of allowed.';
    }

    if ($data['image']['size'] > FILE_SIZE) {
        $error[] = 'Image size must be less than 2MB.';
    }

    if (count($errors) > 0) {
        $code = 422;
        $data = ['errors' => $errors];
    } else {
        require_once '../../php/conn.php';
        //TODO: Improve this with sha1
        $newFile = time().$data['image']['name'];

        $filePATH = '../../images/radovi/'.$newFile;

        // Image validation
        if (move_uploaded_file($data['image']['tmp_name'], $filePATH)) {
            $fileDBPath = 'images/radovi/'.$newFile;
            if (addExhibition($conn, $data['title'], $data['subtitle'], $data['body'], $fileDBPath)) {
                $code = 201;
                $data = ['message' => 'Successfully added new exhibition.'];
            } else {
                $code = 500;
                $data = ['message' => 'Server error.'];
            }
        }
    }
}

http_response_code($code);
echo json_encode($data);