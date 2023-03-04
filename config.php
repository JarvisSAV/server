<?php
include "conexion.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header("Content-type: application/json; charset=utf-8");
$input = json_decode(file_get_contents("php://input"), true);

$pathServer = "http://192.168.1.69/server/";

function getUniqueName($extension)
{
    date_default_timezone_set('America/Mexico_City');
    $name = "img_";
    $name .= date("YmdHis");
    $name .= substr(md5(rand(0, PHP_INT_MAX)), 10);
    $name .= "." . $extension;
    return $name;
}
?>