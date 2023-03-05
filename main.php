<?php
include('producto.php');
include('config.php');

try {
    //code...
    $accion = "No se encontro ninguna accion";
    $producto = "No se encontro ningun producto";
    $result = false;

    $producto = new Producto();
    if (isset($input["accion"]) && isset($input['producto'])) {
        $accion = $input["accion"];
        $producto->setId($input["producto"]["_id"]);
        $producto->setNombre($input["producto"]["_nombre"]);
        $producto->setTipo($input["producto"]["_tipo"]);
        $producto->setPrecio($input["producto"]["_precio"]);
        $producto->setDescripcion($input["producto"]["_status"]);
    }
    if (isset($_POST["accion"])) {
        $accion = $_POST["accion"];
        $p = json_decode($_POST["producto"]);
        $producto->setid($p->id);
        $producto->setNombre($p->nombre);
        $producto->setDescripcion($p->descripcion);
        $producto->setCaracteristicas($p->caracteristicas);
        $producto->setPrecio($p->precio);
        $producto->setStock($p->stock);
        $producto->setStatus($p->status);
        $producto->setTipo($p->tipo);
        if(isset($_FILES["imagen"])){
            $producto->setImagenes($_FILES['imagen']);
        }
    }

    switch ($accion) {
        case 'getProductosHome':
            $all = false;
            $result = $producto->getProductos($pathServer,$all);
            break;
        case 'getProductosCatalogo':
            $all = true;
            $result = $producto->getProductos($pathServer,$all);
            break;
        case 'crearProducto':
            $result = $producto->crearProducto();
            break;
        case 'getSingleProducto':
            $result = $producto->getSingleProducto($pathServer);
            break;
        case 'deleteProducto':
            $result = $producto->deleteProducto();
            break;
        case 'updateProducto':
            $result = $producto->updateProducto();
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