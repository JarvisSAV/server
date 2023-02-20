<?php
include("config.php");
session_start();

$conex = conexionMSQLI();
$usuario = $input["user"];
$password = $input["password"];

$sql = "SELECT * from usuarios where username = \"$usuario\"";
$result = mysqli_query($conex, $sql);
$json = Array();

if (mysqli_num_rows($result)) {
    if ($row = mysqli_fetch_array($result)) {
        if(md5($password) == $row["password"]){
            $_SESSION["id"] = $row["id"];
            $_SESSION["user_active"] = true;
            $_SESSION["user"] = $row["username"];
            $_SESSION["password"] = $row["password"];
            $json["flag"] = true;
            $json["msg"] = "Verificacion Exitosa ";
            // echo json_encode("1");
        }else{
            $json["flag"] = false;
            $json["msg"] = "Usuario o contraseña incorrectos";
            // $json["msg"] = "Contraseña incorrecta";
            // echo json_encode("Contraseña incorrecta");
        }
    }
} else {
    $json["flag"] = false;
    $json["msg"] = "Usuario o contraseña incorrectos";
    // echo json_encode("Usuario no encontrado");
}
echo json_encode($json);
?>