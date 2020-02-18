<?php

require_once 'config.php';
require_once 'functions.php';

try {
    $dsn = "mysql:host=".DB_SERVER.";dbname=".DB_DATABASE.";charset=utf8";
    $conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    logger($e->getMessage());
}

function env(string $key): string
{
    $envPath = "{$_SERVER['DOCUMENT_ROOT']}/present/.env";
    $data = file($envPath);
    $string = "";

    foreach ($data as $key => $value) {
        $config = explode("=", $value);
        if ($config[0] == $key) {
            $string = trim($config[1]);
        }
    }

    return $string;
}