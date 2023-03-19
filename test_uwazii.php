<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require_once 'src/index.php';
use Uwazii\UwaziiClient as Uwaziimobile;

$username = "SCSSA_Langata";
$password = "Mwaura*123#";
$sender = "NGOISUPAMKT";


$mail = new Uwaziimobile();

$access_token = $mail->accessToken($username,$password);
$results = $mail->sendMessage($access_token,$sender,'254710529757','Test');
var_dump($results);
//$mail->addRoute('admin@testing.com','https://example.com/webhook.php');
//$mail->create('Musa','admin@musapandii.com');
//$mail->getRoutes();
//$mail->deleteRoute('admin@testing.com');
//$mail->getDNS();
//$mail->dns('4758700896');
?>