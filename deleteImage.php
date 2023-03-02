<?php
include("config.php");

try {
    //code...
    $conn = conexionMSQLI();
    $id = $input['id'];
    
    $sql = "UPDATE imagenes SET `as` = 0 where `id` = $id";
    $result = $conn->query($sql);
    
    $json['msg'] = "Todo chevere";
} catch (\Throwable $th) {
    //throw $th;
    $json['msg'] = "Algo anda mal ".$th;
}
echo json_encode($json);

?>