<?php

header("Content-type: application/json");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require '../vendor/autoload.php';
require '../../php/vendor/phpmailer/phpmailer/src/Exception.php';
require '../../php/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../php/vendor/phpmailer/phpmailer/src/SMTP.php';

$data = null;
$code = 404;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST["user"] ?? '';
    $email = $_POST["email"] ?? '';
    $pass = $_POST["password"] ?? '';
    $repassword = $_POST["repassword"] ?? '';

    $greske = [];

    $reUser = "/^[a-zA-Z0-9]{2,}+([a-zA-Z0-9](_|-| )[a-zA-Z0-9])*[a-zAZ0-9]*$/";
    $rePass = "/^[0-9A-z]{4,}$/";

    if (!$user) {
        $greske[] = 'Username is required.';
    } elseif (!preg_match($reUser, $user)) {
        $greske[] = 'Username not valid.';
    }

    if (!$email) {
        $greske[] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $greske[] = 'Email not valid.';
    }

    if (!$pass) {
        $greske[] = 'Password is required.';
    } elseif (!preg_match($rePass, $pass)) {
        $greske[] = 'Password is not in correct format.';
    }

    if ($pass != $repassword) {
        $greske[] = "Passwords don't match";
    }

    if (count($greske) === 0) {
        try {
            require_once "../../php/conn.php";
            require_once '../../models/user.php';
            require_once '../../php/functions.php';

            $isEmailAvailable = getUserByEmail($conn, $email);

            if ($isEmailAvailable) {
                $data = ['message' => 'Email is already in use.'];
                $code = 409;
            }

            $password = password_hash($pass, PASSWORD_BCRYPT);
            $token = bin2hex(random_bytes(60));

            $production = false;

            if (register($conn, $user, $email, $password, $token)) {
                $code = 201;
                $data = ['message' => 'Uspesna reg'];
                // TODO: Send verification email
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'auditornephp@gmail.com';
                    $mail->Password = 'Sifra123';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->SMTPOptions = [
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        ]
                    ];

                    //Recipients
                    $mail->setFrom('dachaczbg@gmail.com', 'MMart');
                    $mail->addAddress($email);
                    //Content
                    $fullUrl =  $production ? "https://milicamisicart.000webhostapp.com/" : "http://localhost/present/"; // pa ja sam hardkodovao idi dole i vidi e sad ga imamo sacem prepravim
                    $mail->Subject = 'Activate your account';
                    $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
      
      <head>
        <title>Founder Mantras</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Founder Mantras Email Forms">
        <meta name="keywords" content="Founder Mantras">
        <style type="text/css">
          body {
            font: 14px/20px Arial, sans-serif;
            margin: 0;
            padding: 75px 0 0 0;
            text-align: center;
            -webkit-text-size-adjust: none;
          }
      
          p {
            padding: 0 0 10px 0;
          }

          ul li {
            list-style-type: none;
          }

          a {
            text-decoration: none;
          }
      
          h1 img {
            max-width: 100%;
            height: auto !important;
            vertical-align: bottom;
          }
      
          h2 {
            font-size: 22px;
            line-height: 28px;
            margin: 0 0 12px 0;
          }
      
          h3 {
            margin: 0 0 12px 0;
          }
      
          .headerBar {
            background: none;
            padding: 0;
            border: none;
          }
      
          .wrapper {
            width: 600px;
            margin: 0 auto 10px auto;
            text-align: left;
          }
      
          input.button {
            border: none !important;
          }
      
          .button {
            display: inline-block;
            font-weight: 500;
            font-size: 16px;
            line-height: 42px;
            font-family: Arial, sans-serif;
            width: auto;
            white-space: nowrap;
            height: 42px;
            margin: 12px 5px 12px 0;
            padding: 0 22px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            border: 0;
            border-radius: 3px;
            vertical-align: top;
          }
      
          .button span {
            display: inline;
            font-family: Arial, sans-serif;
            text-decoration: none;
            font-weight: 500;
            font-style: normal;
            font-size: 16px;
            line-height: 42px;
            cursor: pointer;
            border: none;
          }
      
          .rounded6 {
            border-radius: 6px;
          }
      
          .poweredWrapper {
            padding: 20px 0;
            width: 560px;
            margin: 0 auto;
          }
      
          .poweredBy {
            display: block;
          }
      
          span.or {
            display: inline-block;
            height: 32px;
            line-height: 32px;
            padding: 0 5px;
            margin: 5px 5px 0 0;
          }
      
          .clear {
            clear: both;
          }
      
          .profile-list {
            display: block;
            margin: 15px 20px;
            padding: 0;
            list-style: none;
            border-top: 1px solid #eee;
          }
      
          .profile-list li {
            display: block;
            margin: 0;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
          }
      
          html[dir=rtl] .wrapper,
          html[dir=rtl] .container,
          html[dir=rtl] label {
            text-align: right !important;
          }
      
          html[dir=rtl] ul.interestgroup_field label {
            padding: 0;
          }
      
          html[dir=rtl] ul.interestgroup_field input {
            margin-left: 5px;
          }
      
          html[dir=rtl] .hidden-from-view {
            right: -5000px;
            left: auto;
          }
      
          body,
          #bodyTable {
            background-color: #f5f5f5;
          }
      
          h1 {
            font-size: 28px;
            line-height: 110%;
            margin-bottom: 30px;
            margin-top: 0;
            padding: 0;
          }
      
          #templateContainer {
            background-color: #f5f5f5;
          }
      
          #templateBody {
            background-color: #f5f5f5;
          }
      
          .bodyContent {
            line-height: 150%;
            font-family: Helvetica;
            font-size: 14px;
            color: #ffffff;
            padding: 20px;
          }
      
          a:link,
          a:active,
          a:visited,
          a {
            color: #f3f3f3;
          }
      
          .button:link,
          .button:active,
          .button:visited,
          .button,
          .button span {
            background-color: #ffffff !important;
            color: #90988b !important;
          }
      
          .button:hover {
            background-color: #000000 !important;
            color: #ffffff !important;
          }
      
          label {
            line-height: 150%;
            font-family: Helvetica;
            font-size: 16px;
            color: #ffffff;
          }
      
          .field-group input,
          select,
          textarea,
          .dijitInputField {
            font-family: Helvetica;
            color: #333333 !important;
          }
      
          .asterisk {
            color: #111111;
            font-size: 20px;
          }
      
          label .asterisk {
            visibility: hidden;
          }
      
          .indicates-required {
            display: none;
          }
      
          .field-help {
            color: #777;
          }
      
          .error,
          .errorText {
            color: #ffffff;
            font-weight: bold;
          }
      
          @media (max-width: 620px) {
            body {
              width: 100%;
              -webkit-font-smoothing: antialiased;
              padding: 10px 0 0 0 !important;
              min-width: 300px !important;
            }
      
          }
      
          @media (max-width: 620px) {
            .wrapper,
            .poweredWrapper {
              width: auto !important;
              max-width: 600px !important;
              padding: 0 10px;
            }
      
          }
      
          @media (max-width: 620px) {
            #templateContainer,
            #templateBody,
            #templateContainer table {
              width: 100% !important;
              -moz-box-sizing: border-box;
              -webkit-box-sizing: border-box;
              box-sizing: border-box;
            }
      
          }
      
          @media (max-width: 620px) {
            .addressfield span {
              width: auto;
              float: none;
              padding-right: 0;
            }
      
          }
      
          @media (max-width: 620px) {
            .captcha {
              width: auto;
              float: none;
            }
      
          }
        </style>
      
        <style type="text/css">
        </style>
      </head>
      
      <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="font: 14px/20px Arial, sans-serif;margin: 0;padding: 15px 0 0 0;text-align: center;-webkit-text-size-adjust: none;background-color: #f5f5f5;">
        <center>
          <table border="0" cellpadding="20" cellspacing="0" height="100%" width="100%" id="bodyTable" style="background-color: #f5f5f5;">
            <tr>
              <td align="center" valign="top">
                <!-- // BEGIN CONTAINER -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer" class="rounded6" style="border-radius: 6px;background-color: #90988b;">
                  <tr>
                    <td align="center" valign="top">
                      <!-- // BEGIN HEADER -->
                      <table border="0" cellpadding="0" cellspacing="0" width="600">
                        <tr>
                          <td>
                            <h1 align="center" style="font-size: 28px; line-height: 110%; margin-bottom: 30px; margin-top: 0; padding: 0; color:#f8f9fa !important; ">
                              Thanks for joining MMart!
                            </h1>
      
                          </td>
                        </tr>
                      </table>
                      <!-- END HEADER \\ -->
                    </td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">
                      <!-- // BEGIN BODY -->
                      <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody" class="rounded6" style="border-radius: 6px;background-color: #90988b;">
                        <tr>
                          <td align="left" valign="top" class="bodyContent" style="line-height: 150%;font-family: Helvetica;font-size: 14px;color: #ffffff;padding: 20px;">
                            <h2 style="font-size: 22px;line-height: 28px;margin: 0 0 12px 0; color:#f8f9fa !important; font-weight: 100;">Please confirm your email address to continue. Click the link below to get started.
                            </h2> 
                            <a class="button" href="'.$fullUrl.'index.php?page=activation&token='.$token.'" style="color: #90988b !important;display: inline-block;font-weight: 500;font-size: 16px;line-height: 42px;font-family:Arial, sans-serif;width: auto;white-space: nowrap;height: 42px;margin: 12px 5px 12px 0;padding: 0 22px;text-decoration: none;text-align: center;cursor: pointer;border: 0;border-radius: 3px;vertical-align: top;background-color: #ffffff !important;">
                              <span style="display: inline;font-family:Arial, sans-serif;text-decoration: none;font-weight: 500;font-style: normal;font-size: 18px;line-height: 42px;cursor: pointer;border: none;background-color: #90988b !important;color: #grey !important; font-weight: bold;"></span> Confirm Email Address
                            </a>
                           
                            <div>
                              <p style="padding:10px; margin-bottom: -13px; font-weight: bold; background-color: #90988b; text-align: center; color:#f8f9fa !important; ">In case you forgot your infos :)</p>
                              
                                <ul style="padding: 0 0 10px 0; border-radius: 1px; border: 2px solid #f8f9fa; padding: 1em; line-height: 2.5em; color:#f8f9fa !important; ">
                                  <li>
                                      <b style="color:#f8f9fa !important;" >UserName</b>: '.$user.'
                                  </li>
                                  <li>
                                      <b style="color:#f8f9fa !important; text-decoration: none; ">Email</b>: '.$email.'
                                  </li>
                                  <li>
                                      <b style="color:#f8f9fa !important;" >Password</b>: '.$pass.'
                                  </li>
                                </ul>
                  
                              
                              <p style="padding: 0 0 10px 0; color:#f8f9fa !important;">For any questions, please contact:
                                <br>
                                <br> 
                                <a href="mailto:milicamisic@gmail.com" style="color:#f8f9fa !important; padding:1em; background-color: #1c2331;">Email:milicamisic@gmail.com</a>
                              </p>
                            </div>
                            <span itemscope itemtype="http://schema.org/EmailMessage">
                              <span itemprop="description" content="We need to confirm your email address."></span>
      
                              <span itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction">
                                <meta itemprop="name" content="Confirm Subscription">
                                <span itemprop="handler" itemscope itemtype="http://schema.org/HttpActionHandler">
                                  <meta itemprop="url" content="https://foundermantras.us7.list-manage.com/subscribe/smartmail-confirm?u=1b74d38c8380f562118a12b0b&id=8fde0ceecc&e=d060b89991&inline=true">
                                  <link itemprop="method" href="http://schema.org/HttpRequestMethod/POST">
                                </span>
                              </span>
                            </span>
                          </td>
                        </tr>
                      </table>
                      <!-- END BODY \\ -->
                    </td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">
                      <!-- // BEGIN FOOTER -->
                      <table border="0" cellpadding="20" cellspacing="0" width="600">
                        <tr>
                          <td align="center" valign="top"></td>
                        </tr>
                      </table>
                      <!-- END FOOTER \\ -->
                    </td>
                  </tr>
                </table>
                <!-- END CONTAINER \\ -->
              </td>
            </tr>
          </table>
        </center>
      </body>   
      </html>';
                    $mail->Body = $body;
                    $mail->isHTML(true);
                    $mail->send();
                    $code = 201;
                    $data = 'Registration successfull. </br> Please check your email.';
                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                }
            }
        } catch (PDOException $e) {
            $code = 409;
            $data = ['message' => 'Email is already in use.'];
        }
    } else {
        $data = $greske;
        $code = 422;
    }
}

echo json_encode($data);
http_response_code($code);
