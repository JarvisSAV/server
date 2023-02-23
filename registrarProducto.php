<?php
include("config.php");
session_start();

try {
    //code...
    $conex = conexionMSQLI();
    $nombre = $input["nombre"];
    $precio = $input["precio"];
    $stock = $input["stock"];
    $decripcion = $input["descripcion"];
    $caracteristicas = $input["caracteristicas"];
    $tipo = $input["tipo"];
    $status = $input["status"];
    $json = array();

    try {
        //code...
        $sql = $conex->prepare("INSERT INTO productos values (null,?,?,?,?,?,?,?,1)");
        $sql->bind_param("sssiiii", $nombre, $decripcion, $caracteristicas, $precio, $stock, $status, $tipo);
        $result = $sql->execute();

        if (!$result) {
            $json["flag"] = false;
            $json["msg"] = mysqli_errno($conex) . ": " . mysqli_error($conex);
        } else {
            $json["flag"] = true;
            $json["msg"] = "Registro Exitoso";
        }

        $conex->close();

    } catch (\Throwable $th) {
        //throw $th;
        $json["flag"] = false;
        $json["msg"] = "" . $th;
    }
} catch (Exception $e) {
    //throw $th;
    $json["msg"] = "Error en el servidor";
}

echo json_encode($json);
?>