<?php

const MAIL_USER = 'caohoanganhminh@gmail.com';      
const MAIL_PASS = 'vpna ycfo vkvx jgur';        
const MAIL_NAME = 'Anh Minh';                  

const DB_HOST = 'localhost';
const DB_NAME = 'qlkhachhang';
const DB_USER = 'root';
const DB_PASS = '';

require __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer-master/src/SMTP.php';
require __DIR__ . '/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

function taoMailer(): PHPMailer
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->CharSet    = 'UTF-8';
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = MAIL_USER;
    $mail->Password   = MAIL_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
    $mail->Port       = 465;                         
  
    $mail->SMTPOptions = ['ssl' => [
        'verify_peer'       => false,
        'verify_peer_name'  => false,
        'allow_self_signed' => true,
    ]];
    $mail->setFrom(MAIL_USER, MAIL_NAME);
    $mail->isHTML(true);
    return $mail;
}