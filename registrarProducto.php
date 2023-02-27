<?php
include("config.php");
session_start();

$conex = conexionMSQLI();

if (isset($_POST["producto"])) {
    $producto = json_decode($_POST["producto"]);

    // Iniciar la transacción
    $conex->begin_transaction();

    try {
        // Insertar el producto
        $sql = $conex->prepare("INSERT INTO productos values (null,?,?,?,?,?,?,?,1)");
        $sql->bind_param("sssiiii", $producto->nombre, $producto->descripcion, $producto->caracteristicas, $producto->precio, $producto->stock, $producto->status, $producto->tipo);
        $result = $sql->execute();
        $producto_id = $conex->insert_id;

        if (isset($_FILES["imagen"])) {
            $imagenes = $_FILES["imagen"];

            //Verifica la puresa de las images
            foreach ($imagenes['tmp_name'] as $key => $tmp_name) {
                //filtrar por extension
                if ($imagenes['type'][$key] != 'image/jpeg') {
                    $flag["msg"] = "Error, el archivo no es imagen, o no es jpeg";
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
                    $sql->bind_param("is", $producto_id, $ruta_archivo);
                    $result = $sql->execute();
                }

                $conex->commit();
                $json["flag"] = true;
                $json["msg"] = "Producto creado correctamente";
            } else {
                $conex->rollback();
                $json["flag"] = false;
                $json["msg"] = "" . $flag["msg"];
            }
        } else {
            $conex->rollback();
            $json["flag"] = false;
            $json["msg"] = "No se a encontrado ninguna imagen";
        }

    } catch (Throwable $e) {
        // Si ocurre un error, deshacer la transacción y mostrar el mensaje de error
        $conex->rollback();
        $json["flag"] = false;
        $json["msg"] = "Error al crear el producto: " . $e;
    }
    echo json_encode($json);
}
$conex->close();
?>