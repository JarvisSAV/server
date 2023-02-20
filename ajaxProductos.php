<?php
include("./config.php");

$conn = conexionMSQLI();

$sql = "SELECT * from productos";
$resultado = $conn->query($sql);

$json = array();
while($fila = $resultado->fetch_array()){
    // $producto[] = array_map('utf8_encode', $fila);
    $producto["Tipo_Producto_id"] = $fila["Tipo_Producto_id"];
    $producto["id"] = $fila["id"];
    $producto["nombre"] = $fila["nombre"];
    $producto["precio"] = $fila["precio"];
    $producto["stock"] = $fila["stock"];
    $producto["status"] = $fila["status"];
    array_push($json,$producto);
}

echo json_encode($json);
$resultado->close();
?>