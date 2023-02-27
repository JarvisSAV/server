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
            
            $sql2 = "SELECT * FROM imagenes WHERE productos_id =".$producto['id'];
            $result2 = $conn->query($sql2);    
        
            if ($result2->num_rows > 0) {
                $images = array();
                while ($fila = $result2->fetch_assoc()) {
                    $imagen["path"] = "http://127.0.0.1/server/" . $fila["path"];
                    $imagen["id"] = $fila["id"];
                    array_push($images, $imagen);
                }
                $producto["images"] = $images;
            }else{
                $producto["images"] = [];
            }

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