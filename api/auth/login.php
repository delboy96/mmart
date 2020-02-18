<?php

@session_start();

header("Content-type: application/json");

$data = null;
$code = 404;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';

    $passReg = "/^[a-z0-9]{4,}$/";

    $greske = [];

    if (!$email) {
        $greske[] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $greske[] = "Email not valid";
    }

    if (!$pass) {
        $greske[] = 'Password is required';
    } elseif (!preg_match($passReg, $pass)) {
        $greske[] = "Password not valid";
    }

    if (count($greske) === 0) {
        require_once "../../php/conn.php";
        require_once '../../models/user.php';
        require_once '../../php/functions.php';

        $user = getUserByEmail($conn, $email);

        if ($user === null) {
            $code = 404;
            $data = ['message' => 'User with that email does not exist.'];
        }

        if ($user && !$user->active) {
            $code = 409;
            $data = ['message' => 'Your account is not verified.'];
            //TODO: send verifiaction mail again
        } else {
            if ($user && password_verify($pass, $user->password)) {
                $_SESSION['user'] = $user;
                $code = 200;
                $data = ['message' => 'Successfully logged in.'];
            } else {
                $code = 400;
                $data = ['message' => 'Invalid password.'];
            }
        }
    } else {
        $data = $greske;
        $code = 422;
    }
}

echo json_encode($data);
http_response_code($code);
