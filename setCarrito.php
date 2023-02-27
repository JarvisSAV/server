<?php
include("config.php");

try {
    //code...
    $conn = conexionMSQLI();
    // Obtener el id de usuario
    $user_id = $input['user_id'];
    
    // Verificar si el usuario ya tiene un carrito
    $query = "SELECT id FROM carritos WHERE usuario_id = $user_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        // Si no tiene un carrito, crear uno nuevo
        $query = "INSERT INTO carritos (usuario_id) VALUES ($user_id)";
        mysqli_query($conn, $query);
    }

    // Obtener el id del carrito del usuario
    $query = "SELECT id FROM carritos WHERE usuario_id = $user_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $carrito_id = $row['id'];

    // Verificar si el producto existe
    $producto_id = $input['producto_id'];
    $query = "SELECT * FROM productos WHERE id = $producto_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        // Si el producto no existe, mostrar un mensaje de error
        $json["msg"] = "El producto no existe";
    } else {
        // Verificar si el producto ya está en el carrito
        $query = "SELECT * FROM carritos_has_productos WHERE carritos_id = $carrito_id AND productos_id = $producto_id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Si el producto ya está en el carrito, actualizar su cantidad
            $row = mysqli_fetch_assoc($result);
            if($row["as"] == 0){
                $cantidad = $input["cantidad"];
            }else{
                $cantidad = $row['cantidad'] + $input['cantidad'];
            }
            $query = "UPDATE carritos_has_productos SET cantidad = $cantidad, `as` = 1 WHERE carritos_id = $carrito_id AND productos_id = $producto_id";
            mysqli_query($conn, $query);
        } else {
            // Si el producto no está en el carrito, agregarlo
            $cantidad = $input['cantidad'];
            $query = "INSERT INTO carritos_has_productos (carritos_id, productos_id, cantidad, `as`) VALUES ($carrito_id, $producto_id, $cantidad, 1)";
            mysqli_query($conn, $query);
        }
        $json["msg"] = "Producto agregado correctamente";
    }

} catch (\Throwable $th) {
    //throw $th;
    $json["msg"] = "Error al agregar producto ".$th;
}
echo json_encode($json);
?>