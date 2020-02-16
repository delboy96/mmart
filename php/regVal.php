<?php
    header("Content-type: application/json");
    $data = null;
    $code = 404;
    // include "conn.php";
    if(isset($_POST["registerBtn"])){

        
        $user = $_POST["user"];
        $email = $_POST["email"];
        $pass = $_POST["password"];
        $repassword = $_POST["repassword"];

        $greske = [];

        // var_dump(user);

        $reUser = "/^[a-zA-Z0-9]{2,}+([a-zA-Z0-9](_|-| )[a-zA-Z0-9])*[a-zAZ0-9]*$/";
        $rePass = "/^[0-9A-z]{4,}$/";
        
        if(!preg_match($reUser,$user)){
            $greske[]='Username not valid.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $greske[]='Email not valid.';
            }

        if(!preg_match($rePass,$pass)){
            $greske[]='Password is not in correct format.';
        }

        if($pass!=$repassword){
            $greske[]="Passwords don't match";
        }

        if(count($greske)==0){

        try{
            require_once "conn.php";

            //BCRYPT
            // $pass = password_hash($pass, PASSWORD_BCRYPT);
                $token=rand(1,10000).time().$user;
                $pass = md5($pass);
                $query="INSERT INTO `users` (`id`, `username`, `email`, `password`, 
                `token`, `role_id`, `active`) 
                VALUES (NULL, :user, :email, :pass, 
                :token, '2', '1')";

                $stmt = $conn->prepare($query);
                $stmt->bindParam(":user",$user);
                $stmt->bindParam(":email",$email);
                $stmt->bindParam(":pass",$pass);
                $stmt->bindParam(":token",$token);
            
                $stmt->execute();

                if($stmt->rowCount()){
                    $code=201;
                    $data="Uspesna reg";
                }else{
                    $code=500;
                    $data="Neuspesna reg";
                }
                
                header('location:../index.php?page=login');
                
            } catch(PDOException $e) {
                $code = 409;
                echo $e->getMessage();
            }
        } else {
            $data = $greske;
            $code = 422;
        }

        echo json_encode($data);
        http_response_code($code);
    }
    


   