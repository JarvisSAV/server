<?php
include("./config.php");

try {
    //code...
    $conn = conexionMSQLI();
    $producto_tipo = $input["producto_tipo"];
    $producto_status = $input["producto_status"];
    $productos_limite = $input["productos_limit"];
    $json = array();

    if($productos_limite != -1  && $producto_status != -1){
        $sql = "SELECT * from productos where Tipo_Producto_id = $producto_tipo and `as` = 1 limit $productos_limite";
    }else{
        $sql = "SELECT * from productos where `as` = 1";
    }

    $resultado = $conn->query($sql);

    while ($fila = $resultado->fetch_array()) {
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
                    $imagen["path"] = "/".$fila["path"];
                    $imagen["id"] = $fila["id"];
                    array_push($images, $imagen);
                }
                $producto["images"] = $images;
            }else{
                $producto["images"] = [];
            }

            array_push($json, $producto);
    }

    $conn->close();
    
} catch (Exception $e) {
    //throw $th;
    $json["msg"] = "Error en el servidor";
}

echo json_encode($json);
?>