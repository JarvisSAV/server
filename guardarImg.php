<?php
include("config.php");

try {
    //code...
    if (isset($_FILES["imagen"])) {
        $cantidad = count($_FILES["imagen"]["tmp_name"]);
        // echo "cantidad " . $cantidad;
        for ($i = 0; $i < $cantidad; $i++) {
            $file = $_FILES["imagen"];
            $nombre = $file["name"][$i];
            $tipo = $file["type"][$i];
            $ruta_provisional = $file["tmp_name"][$i];
            $size = $file["size"][$i];
            $dimensiones = getimagesize($ruta_provisional);
            $whitd = $dimensiones[0];
            $heigt = $dimensiones[1];
            $carpeta = "img/";
            // $json["warning"] = $tipo;
            if ($tipo != 'image/jpeg') {
                $json["warning"] = "Error el archivo no es imagen";
            } else if ($size > 3 * 1024 * 1024) {
                $json["warning"] = "El tamaño maximo permitido es de 3MB";
            } else {
                $nombre = getUniqueName();
                $src = $carpeta . $nombre;
                if (insertar($src, $_POST["user"])) {
                    move_uploaded_file($ruta_provisional, $src);
                    $json["warning"] = "Imagen guardada con exito";
                } else {
                    $json["warning"] = "Error al insertar en la base de datos";
                }
            }
        }
    } else {
        $json["warning"] = "No se recibio ninguna imagen";
    }

} catch (Exception $e) {
    //throw $th;
    $json["msg"] = "Error en el servidor";
}

function insertar($path, $nombre){

    $conex = conexionMSQLI();

    try {
        $sql = "SELECT id FROM productos WHERE nombre = '$nombre'";
        $result = $conex->query($sql);
        // echo $sql;
        
        if ($result->num_rows > 0) {
            // output data of each row
            while ($fila = $result->fetch_assoc()) {
                $id = $fila["id"];
            }

            $sql = $conex->prepare("INSERT INTO imagenes values(null,?,?,1)");
            $sql->bind_param("is", $id, $path);
            $result = $sql->execute();

            if (!$result) {
                $json["flag"] = false;
                $json["msg"] = mysqli_errno($conex) . ": " . mysqli_error($conex);
                echo $json["msg"];
                return false;
            } else {
                $json["flag"] = true;
                $json["msg"] = "Registro Exitoso";
                echo $json["msg"];
                return true;
            }
        }

        $conex->close();

    } catch (\Throwable $th) {
        $json["flag"] = false;
        $json["msg"] = "Puñetas2.0 " . $th;
        echo json_encode($json);
        return false;
    }
}

function getUniqueName($extension = 'jpg'){
        
    switch ($extension) {
        case "FJPG":
        case "FJPEG":
            $extension = 'jpg';
            break;
        case "FPNG":
            $extension = 'png';
            break;
        case "FGIF":
            $extension = 'gif';
            break;
    }
    date_default_timezone_set('America/Mexico_City');
    $name = "img_";
    $name .= date("YmdHis");
    $name .= substr(md5(rand(0, PHP_INT_MAX)), 10);
    $name .= "." . $extension;
    return $name;
}

echo json_encode($json);
?>