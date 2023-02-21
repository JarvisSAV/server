<?php
include("./config.php");

$conn = conexionMSQLI();
$id = $input["id"];

try {
    $sql = "UPDATE productos set `as` = 0 where id = $id";
    $resp = $conn->query($sql);
    if(mysqli_errno($conn))
        $json["msg"] = mysqli_errno($conn) . ": " . mysqli_error($conn);
    else
        $json["msg"] = "Registro Eliminado";
} catch (\Throwable $th) {
    //throw $th;
    $json["msg"] = "Error ".$th;
}
echo json_encode($json);
?>