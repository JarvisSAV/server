<?php
include("config.php");

try {
    //code...
    $conn = conexionMSQLI();
    $user_id = $input["user_id"];
    $producto_id = $input["producto_id"];

    //consultar el id del carrito del usuario
    $query = "SELECT * from carritos where usuario_id = $user_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $carrito_id = $row['id'];

    $query = "UPDATE carritos_has_productos set `as` = 0 where carritos_id = $carrito_id and productos_id = $producto_id";
    mysqli_query($conn, $query);

    $json["msg"] = "Producto eliminado correctamente".mysqli_error($conn);
    $json["flag"] = true;
} catch (\Throwable $th) {
    //throw $th;
    $json["msg"] = "Error al eliminar".$th;
    $json["flag"] = false;
}

echo json_encode($json);
?>