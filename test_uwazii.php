<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require_once 'src/index.php';
use Uwazii\UwaziiClient as Uwaziimobile;

$username = "";
$password = "";
$sender = "";


$uwazii = new Uwaziimobile();

$access_token = $uwazii->accessToken($username,$password);
$results = $uwazii->sendMessage($access_token,$sender,'2547xxxxxxxx','Test');
var_dump($results);

?>
