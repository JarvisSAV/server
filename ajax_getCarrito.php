<?php
include('./config.php');

try {
    //code...
    $conex = conexionMSQLI();
    $id = $input["id"];
    $json = array();

    $sql = "CALL vista_carrito ($id)";
    $result = $conex->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($fila = $result->fetch_assoc()) {
            $producto["id"] = $fila["id"];
            $producto["nombre"] = $fila["nombre"];
            $producto["precio"] = $fila["precio"];
            $producto["stock"] = $fila["stock"];
            $producto["cantidad"] = $fila["cantidad"];
            $producto["path"] = $fila["path"];
            $producto["total"] = $fila["total"];

            array_push($json,$producto);
        }
        
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