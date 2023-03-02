<?php
include "conexion.php";
include("funciones.php");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header("Content-type: application/json; charset=utf-8");
$input = json_decode(file_get_contents("php://input"), true);

$pathServer = "http://192.168.1.69/server/"


?>