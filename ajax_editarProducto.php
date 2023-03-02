<?php
include("config.php");

$conex = conexionMSQLI();

if (isset($_POST["producto"])) {
    $producto = json_decode($_POST["producto"]);

    // Iniciar la transacción
    $conex->begin_transaction();

    try {
        // Actualiza el producto
        $sql = "UPDATE productos set nombre = '$producto->nombre', descripcion = '$producto->descripcion', caracteristicas = '$producto->caracteristicas', precio = $producto->precio, stock = $producto->stock, status = $producto->status, Tipo_Producto_id = $producto->tipo where id = $producto->id";
        $resp = $conex->query($sql);


        if (isset($_FILES["imagen"])) {
            $imagenes = $_FILES["imagen"];

            //Verifica la puresa de las images
            foreach ($imagenes['tmp_name'] as $key => $tmp_name) {
                //filtrar por extension
                if ($imagenes['type'][$key] != 'image/jpeg' && $imagenes['type'][$key] != 'image/png') {
                    $flag["msg"] = "Error, no se admiten archivos con extension ".$imagenes['type'][$key];
                    break 1;
                } else if ($imagenes['size'][$key] > 3 * 1024 * 1024) {
                    $flag["msg"] = "Algunas imagenes exeden el tamaño permitido, el máximo es de 3MB";
                    break 1;
                }
            }
            if (!isset($flag)) {
                // Insertar las imágenes
                foreach ($imagenes['tmp_name'] as $key => $tmp_name) {
                    $nombre_archivo = getUniqueName(pathinfo($imagenes['name'][$key], PATHINFO_EXTENSION));
                    $ruta_archivo = 'img/' . $nombre_archivo;
                    move_uploaded_file($tmp_name, $ruta_archivo);
                    $sql = $conex->prepare("INSERT INTO imagenes values(null,?,?,1)");
                    $sql->bind_param("is", $producto->id, $ruta_archivo);
                    $result = $sql->execute();
                }

                $conex->commit();
                $json["flag"] = true;
                $json["msg"] = "Producto editado correctamente";
            } else {
                $conex->rollback();
                $json["flag"] = false;
                $json["msg"] = "" . $flag["msg"];
            }
        } else {
            // $conex->rollback();
            $conex->commit();
            $json["flag"] = true;
            $json["msg"] = "Producto editado correctamente";
        }
    } catch (Throwable $e) {
        // Si ocurre un error, deshacer la transacción y mostrar el mensaje de error
        $conex->rollback();
        $json["flag"] = false;
        $json["msg"] = "Error al editar el producto: " . $e;
    }
    echo json_encode($json);
}else{
    echo "No hay ni madres";
}
$conex->close();
?>