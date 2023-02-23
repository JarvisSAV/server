<?php
include("./config.php");

try {
    //code...
    $conn = conexionMSQLI();
    $id = $input["id"];

    $sql = "UPDATE productos set `as` = 0 where id = $id";
    $resp = $conn->query($sql);
    if (mysqli_errno($conn))
        $json["msg"] = mysqli_errno($conn) . ": " . mysqli_error($conn);
    else
        $json["msg"] = "Registro Eliminado";

    $conn->close();

} catch (\Throwable $th) {
    //throw $th;
    $json["msg"] = "Error en el servidor";
}
echo json_encode($json);
?>