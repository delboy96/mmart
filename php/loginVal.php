<?php
@session_start();
header("Content-type: application/json");
$data = null;
$code = 404;
if (isset($_POST['loginBtn'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $passReg = "/^[a-z0-9]{4,}$/";

    $greske = [];

    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        array_push($greske, "Email not valid");
    }

    if (!preg_match($passReg,$pass)){
        array_push($greske, "Password not valid");
    }
    
    if (count($greske) === 0) {
        require_once "conn.php";

        //BCRYPT    
        // $hashSql = "SELECT u.password AS pass
        // FROM users u 
        // WHERE u.email = :email";
        // $hashSql = $conn->prepare($upit);
        // $hashSql->bindParam(":email", $email);
        // try{
        //     $hashFromDB = $stmt->fetch();
        // }catch(PDOException $e) {
        //     echo $e->getMessage();
        // }
        
        // $passVerified = password_verify($pass, $hashFromDB);           
            
        $pass = md5($pass);
            
        $upit = "SELECT u.id, u.username, u.email, u.token, u.dateReg, r.id AS role_id, r.name 
                    FROM users u INNER JOIN roles r
                    ON u.role_id = r.id
                    WHERE u.email = :email AND u.password = :password ";

        $stmt = $conn->prepare($upit);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $pass);
        try {
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user) {
                $_SESSION['user'] = $user;
                $data = 'You have succesfully logged in!';
                $code = 200;
                header('location:../index.php?page=gallery');
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        $data = $greske;
        $code = 422;
    }
}
echo json_encode($data);
http_response_code($code);
