<?php
include('../config.php');
include('./carrito.php');

try {
    $accion = "No se encontro ninguna accion";
    $result = false;

    $carrito = new Carrito();

    if (isset($input['accion']) && $input['carrito']) {
        $accion = $input['accion'];
        $carrito->setId($input['carrito']['_id']);
        $carrito->setTotal($input['carrito']['_total']);
        $carrito->setUsuarioId($input['carrito']['_usuarioId']);
    }

    switch ($accion) {
        case 'deleteProductoDeCarrito':
            $result = $carrito->deleteProductoDeCarrito($input['producto_id']);
            break;
        case 'getCarrito':
            $result = $carrito->getCarrito();
            break;
        case 'addCarrito':
            $result = $carrito->addCarrito($input['producto_id'], $input['mantener'], $input['cantidad']);
            break;
        default:
            break;
    }

    if (!$result) {
        $json = "No se encontro ninguna accion";
    } else {
        $json = $result;
    }

} catch (\Throwable $th) {
    $json['flag'] = false;
    $json['msg'] = "Error desde index: " . $th;
}
echo json_encode($json, JSON_UNESCAPED_UNICODE);
?>