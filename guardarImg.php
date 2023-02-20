<?php
include("config.php");

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
        // echo $tipo;
        if ($tipo != 'image/jpeg') {
            echo "Error el archivo no es imagen";
        } else if ($size > 3 * 1024 * 1024) {
            echo "El tamaño maximo permitido es de 3MB";
        } else {
            $nombre = getUniqueName();
            $src = $carpeta . $nombre;
            insertar($src, $_POST["user"]);
            move_uploaded_file($ruta_provisional, $src);
            echo "Imagen guardada con exito";
        }
    }
} else {
    echo "No se recibio ninguna imagen";
}
function getUniqueName($extension = 'jpg')
{
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

function insertar($path, $nombre)
{

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
            
            $sql = $conex->prepare("INSERT INTO imagenes values(null,?,?)");
            $sql->bind_param("si", $path, $id);
            $result = $sql->execute();
            
            if (!$result) {
                $json["flag"] = false;
                $json["msg"] = mysqli_errno($conex) . ": " . mysqli_error($conex);
            } else {
                $json["flag"] = true;
                $json["msg"] = "Registro Exitoso";
            }
            echo json_encode($json);
        }
    } catch (\Throwable $th) {
        $json["flag"] = false;
        $json["msg"] = "" . $th;
        echo json_encode($json);
    }
}
