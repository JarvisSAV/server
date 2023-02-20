<?php
include "conexion.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header("Content-type: application/json; charset=utf-8");
$input = json_decode(file_get_contents("php://input"), true);
?>