<?php
include('config.php');

try {
    $accion = "No se encontro ninguna accion";
    $conexion = "No se encontro ninguna conexion";
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
            $result = $carrito->addCarrito($input['producto_id'],$input['mantener'],$input['cantidad']);
            break;
        default:
            # code...
            break;
    }

    if($result){
        $json["msg"] = $result;
        $json["flag"] = true;
    }else{
        $json['msg'] = "No funcion";
        $json['flag'] = false;

    }
} catch (\Throwable $th) {
    //throw $th;
    $json['flag'] = false;
    $json['msg'] = "Error desde Carrito: ".$th;
}
echo json_encode($json,JSON_UNESCAPED_UNICODE);

class Carrito
{
    private $id;
    private $total;
    private $usuarioId;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getTotal()
    {
        return $this->total;
    }
    public function setTotal($total)
    {
        $this->total = $total;
    }
    public function getUsuarioId()
    {
        return $this->usuarioId;
    }
    public function setUsuarioId($usuarioId)
    {
        $this->usuarioId = $usuarioId;
    }
//-------------------------------------------------------------------------
//              Agrega producto a carrito
//-------------------------------------------------------------------------
function addCarrito($producto_id, $mantener, $cuantia)
{
    try {
        //code...
        $conn = conexionMSQLI();
        // Obtener el id de usuario
        $user_id = $this->usuarioId;
        
        // Verificar si el usuario ya tiene un carrito
        $query = "SELECT id FROM carritos WHERE usuario_id = $user_id";
        $result = mysqli_query($conn, $query);
    
        if (mysqli_num_rows($result) == 0) {
            // Si no tiene un carrito, crear uno nuevo
            $query = "INSERT INTO carritos (usuario_id) VALUES ($user_id)";
            mysqli_query($conn, $query);
        }
    
        // Obtener el id del carrito del usuario
        $query = "SELECT id FROM carritos WHERE usuario_id = $user_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $carrito_id = $row['id'];
    
        // Verificar si el producto existe
        $query = "SELECT * FROM productos WHERE id = $producto_id";
        $result = mysqli_query($conn, $query);
    
        if (mysqli_num_rows($result) == 0) {
            // Si el producto no existe, mostrar un mensaje de error
            $json["msg"] = "El producto no existe";
        } else {
            // Verificar si el producto ya está en el carrito
            $query = "SELECT * FROM carritos_has_productos WHERE carritos_id = $carrito_id AND productos_id = $producto_id";
            $result = mysqli_query($conn, $query);
    
            if (mysqli_num_rows($result) > 0) {
                // Si el producto ya está en el carrito, actualizar su cantidad
                $row = mysqli_fetch_assoc($result);
                if($mantener && $row["as"]==1){
                    $cantidad = $row['cantidad'] + $cuantia;
                }else{
                    $cantidad = $cuantia;
                }
                $query = "UPDATE carritos_has_productos SET cantidad = $cantidad, `as` = 1 WHERE carritos_id = $carrito_id AND productos_id = $producto_id";
                mysqli_query($conn, $query);
            } else {
                // Si el producto no está en el carrito, agregarlo
                $cantidad = $cuantia;
                $query = "INSERT INTO carritos_has_productos (carritos_id, productos_id, cantidad, `as`) VALUES ($carrito_id, $producto_id, $cantidad, 1)";
                mysqli_query($conn, $query);
            }
    
            $query = "SELECT total FROM carritos WHERE usuario_id = $user_id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $total = $row['total'];
    
            $json["total"] = $total;
            $json["msg"] = "Producto agregado correctamente";
            $json["flag"] = true;
        }

        return $json;
    
    } catch (\Throwable $th) {
        //throw $th;
        return "Error al agregar producto ".$th;
    }
}
//-------------------------------------------------------------------------
//              consulta los productos en carrito del usuario
//-------------------------------------------------------------------------
    function getCarrito()
    {
        try {
            //code...
            $conex = conexionMSQLI();
            $json = array();
            
            $sql = "CALL vista_carrito ($this->usuarioId)";
            $result = $conex->query($sql);
        
            if ($result->num_rows > 0) {
                // output data of each row
                while ($fila = $result->fetch_assoc()) {
                    $producto["id"] = $fila["id"];
                    $producto["nombre"] = $fila["nombre"];
                    $producto["precio"] = $fila["precio"];
                    $producto["stock"] = $fila["stock"];
                    $producto["cantidad"] = $fila["cantidad"];
                    $producto["path"] = $fila["path"];
                    $producto["total"] = $fila["total"];
                    array_push($json,$producto);
                }
                
            }
        
            $conex->close();
            return $json;
            
        } catch (Throwable $th) {
            //throw $th;
            return "Error al consultar: ".$th;
        }
        
    }
//-------------------------------------------------------------------------
//              Elimina un producto de carrito 
//-------------------------------------------------------------------------
    function deleteProductoDeCarrito($producto_id)
    {
        try {
            //code...
            $conn = conexionMSQLI();

            //consultar el id del carrito del usuario
            $query = "SELECT * from carritos where usuario_id = $this->usuarioId";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $this->setId($row['id']);

            $query = "UPDATE carritos_has_productos set `as` = 0 where carritos_id = $this->id and productos_id = $producto_id";
            mysqli_query($conn, $query);

            $json["msg"] = "Producto eliminado correctamente" . mysqli_error($conn);
            $json["flag"] = true;
        } catch (\Throwable $th) {
            //throw $th;
            $json["msg"] = "Error al eliminar" . $th;
            $json["flag"] = false;
        }

        $conn->close();
        return $json;
    }
}
?>