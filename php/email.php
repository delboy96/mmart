<?php

header("Content-type: application/json");
$data = null;
$code = 404;
if (isset($_POST['emailB'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "dachaczbg@gmail.com";
    $email_subject = "Message";

    /**
     * @param $error
     * @return void
     */
    function died($error): void
    {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error . "<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }


    // validation expected data exists
    if (!isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['message'])) {
        died('Sorry, but there appears to be a problem with the form you submitted.');
    }


    $name = $_POST['name']; // required
    $email_from = $_POST['email']; // required
    $message = $_POST['message']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';



    // TODO: Kad budes upisivao  password u bazu umesto MD5 koristi ovo ==> password_hash('ovde ide userova sifra', PASSWORD_BCRYPT);
    // TODO: Kad budes proveravao password za logovanje  ==> password_verify('userova sifra', 'hash iz baze');
    // TODO: kad pravis token za email verifikaciju koristi ovo ==> bin2hex(random_bytes(60))

    
    if (!preg_match($email_exp, $email_from)) {
        $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'The Name you entered does not appear to be valid.<br />';
    }

    if (strlen($message) < 2) {
        $error_message .= 'The Message you entered do not appear to be valid.<br />';
    }

    if (strlen($error_message) > 0) {
        died($error_message);
    }else{

        $email_message = "Form details below.\n\n";


        function clean_string($string)
        {
            $bad = array("content-type", "bcc:", "to:", "cc:", "href");
            return str_replace($bad, "", $string);
        }


        $email_message .= "Name: " . clean_string($name) . "\n";
        $email_message .= "Email: " . clean_string($email_from) . "\n";
        $email_message .= "Message: " . clean_string($message) . "\n";

    // create email headers
        try{

            $headers = 'From: ' . $email_from . "\r\n" .
            'Reply-To: ' . $email_from . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($email_to, $email_subject, $email_message, $headers);
        ?>
         
        <?php   $data = 'Thank you for contacting me. I will be in touch with you very soon!';
                $code = 200;

        }catch(PDOException $e) {
            echo $e->getMessage();
        }
        

        }
}
echo json_encode($data);
http_response_code($code);
