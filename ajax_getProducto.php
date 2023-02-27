<?php
include('./config.php');

try {
    //code...
    $conex = conexionMSQLI();
    $id = $input["id"];

    $sql = "SELECT * FROM productos WHERE id = $id";
    $result = $conex->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        if ($fila = $result->fetch_assoc()) {
            $producto["Tipo_Producto_id"] = $fila["Tipo_Producto_id"];
            $producto["id"] = $fila["id"];
            $producto["nombre"] = $fila["nombre"];
            $producto["precio"] = $fila["precio"];
            $producto["stock"] = $fila["stock"];
            $producto["status"] = $fila["status"];
            $producto["descripcion"] = $fila["descripcion"];
            $producto["caracteristicas"] = $fila["caracteristicas"];
        }
        
        $sql2 = "SELECT * FROM imagenes WHERE productos_id = $id";
        $result2 = $conex->query($sql2);    

        if ($result2->num_rows > 0) {
            $images = array();
            while ($fila = $result2->fetch_assoc()) {
                $imagen["path"] = "http://127.0.0.1/server/" . $fila["path"];
                $imagen["id"] = $fila["id"];
                array_push($images, $imagen);
            }
            $producto["images"] = $images;
        }
        $json = $producto;
    } else {
        $json = "0 results";
    }

    $conex->close();
    
} catch (Throwable $th) {
    //throw $th;
    $json["msg"] = "Error en el servidor";
}

echo json_encode($json);
?>