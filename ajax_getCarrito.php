<?php
include('./config.php');

try {
    //code...
    $conex = conexionMSQLI();
    $user_id = $input["user_id"];
    $json = array();

    $sql = "CALL vista_carrito ($user_id)";
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
        
    }

    // $json["msg"] = mysqli_error($conex);

    $conex->close();
    
} catch (Throwable $th) {
    //throw $th;
    $json["msg"] = "Error en el servidor";
}

echo json_encode($json);
?>