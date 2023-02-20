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
