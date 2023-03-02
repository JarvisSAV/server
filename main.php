<?php
include('producto.php');
include('config.php');

try {
    //code...
    $accion = "No se encontro ninguna accion";
    $producto = "No se encontro ningun producto";
    $result = false;

    $producto = new producto();
    if (isset($input["accion"]) && $input["producto"]) {
        $accion = $input["accion"];
        $producto->setNombre($input["producto"]["_nombre"]);
        $producto->setTipo($input["producto"]["_tipo"]);
        $producto->setPrecio($input["producto"]["_precio"]);
        $producto->setDescripcion($input["producto"]["_status"]);
    }
    if (isset($_POST["accion"])) {
        $accion = $_POST["accion"];
        $p = json_decode($_POST["producto"]);
        $producto->setNombre($p->nombre);
        $producto->setDescripcion($p->descripcion);
        $producto->setCaracteristicas($p->caracteristicas);
        $producto->setPrecio($p->precio);
        $producto->setStock($p->stock);
        $producto->setStatus($p->status);
        $producto->setTipo($p->tipo);
        $producto->setImagenes($_FILES['imagen']);
    }

    switch ($accion) {
        case 'getProductosHome':
            $result = $producto->getProductos($pathServer,false);
            break;
        case 'getProductosCatalogo':
            $result = $producto->getProductos($pathServer,true);
            break;
        case 'crearProducto':
            $result = $producto->crearProducto();
            break;
            default:
            $result = false;
            break;
    }
    
    if($result){
        $json["msg"] = $result;
        $json["flag"] = true;
    }else{
        $json['msg'] = "No funcion";
        $json['flag'] = false;

    }
    
} catch (Throwable $th) {
    //throw $th;
    $json['flag'] = false;
    $json['msg'] = "Error en el main: ".$th;
}
echo json_encode($json,JSON_UNESCAPED_UNICODE);
?>