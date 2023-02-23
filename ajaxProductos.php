<?php
include("./config.php");

try {
    //code...
    $conn = conexionMSQLI();
    $json = array();

    $sql = "SELECT * from productos";
    $resultado = $conn->query($sql);

    while ($fila = $resultado->fetch_array()) {
        if ($fila["as"] == 1) {
            $producto["Tipo_Producto_id"] = $fila["Tipo_Producto_id"];
            $producto["id"] = $fila["id"];
            $producto["nombre"] = $fila["nombre"];
            $producto["precio"] = $fila["precio"];
            $producto["stock"] = $fila["stock"];
            $producto["status"] = $fila["status"];
            array_push($json, $producto);
        }
    }

    $conn->close();
    
} catch (Exception $e) {
    //throw $th;
    $json["msg"] = "Error en el servidor";
}

echo json_encode($json);
?>