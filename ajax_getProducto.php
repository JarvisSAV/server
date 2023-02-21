<?php
include('./config.php');
try {
    //code...

    $conex = conexionMSQLI();
    $id = $input["id"];

    $sql = "SELECT * FROM productos WHERE id = $id";
    $sql2 = "SELECT * FROM imagenes WHERE productos_id = $id";
    $result = $conex->query($sql);
    $result2 = $conex->query($sql2);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($fila = $result->fetch_assoc()) {
            $producto["Tipo_Producto_id"] = $fila["Tipo_Producto_id"];
            $producto["id"] = $fila["id"];
            $producto["nombre"] = $fila["nombre"];
            $producto["precio"] = $fila["precio"];
            $producto["stock"] = $fila["stock"];
            $producto["status"] = $fila["status"];
            $producto["descripcion"] = $fila["descripcion"];
            $producto["caracteristicas"] = $fila["caracteristicas"];
        }
        
        if($result2->num_rows > 0){
            $images = array();
            while ($fila = $result2->fetch_assoc()) {
                $imagen["path"] ="http://127.0.0.1/server/".$fila["path"];
                $imagen["id"] = $fila["id"];
                array_push($images,$imagen);
            }
            $producto["images"] = $images;
        }
        echo json_encode($producto);
    } else {
        echo json_encode("0 results");
    }


    $conex->close();
} catch (Throwable $th) {
    //throw $th;
    $json["msg"] = "".$th;
    echo json_encode($json);

}
