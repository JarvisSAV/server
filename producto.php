<?php

class Producto implements \JsonSerializable
{
    private $id;
    private $nombre;
    private $descripcion;
    private $caracteristicas;
    private $precio;
    private $precioPublico;
    private $stock;
    private $status;
    private $tipo;
    private $as;
    private $imagenes;

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setCaracteristicas($caracteristicas)
    {
        $this->caracteristicas = $caracteristicas;
    }
    public function getCaracteristicas()
    {
        return $this->caracteristicas;
    }
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function setPrecioPublico($precioPublico)
    {
        $this->precioPublico = $precioPublico;
    }
    public function getPrecioPublico()
    {
        return $this->precioPublico;
    }
    public function setStock($stock)
    {
        $this->stock = $stock;
    }
    public function getStock()
    {
        return $this->stock;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function setAs($as)
    {
        $this->as = $as;
    }
    public function getAs()
    {
        return $this->as;
    }

    public function crear($data)
    {
        echo $data;
        return $data;
    }
    public function getImagenes()
    {
        return $this->imagenes;
    }
    public function setImagenes($imagenes)
    {
        $this->imagenes = $imagenes;
    }
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'caracteristicas' => $this->caracteristicas,
            'precio' => $this->precio,
            'precioPublico' => $this->precioPublico,
            'stock' => $this->stock,
            'status' => $this->status,
            'tipo' => $this->tipo,
            'as' => $this->as,
            'imagenes' => $this->imagenes
        ];
    }
//-------------------------------------------------------------------------
//                      Pruebas
//-------------------------------------------------------------------------
public function prueba()
{
    return "exito";
}
//-------------------------------------------------------------------------
//                      crear producto
//-------------------------------------------------------------------------
function crearProducto()
{
    try {
        //code...
        $conex = conexionMSQLI();
        // Iniciar la transacción
    $conex->begin_transaction();

    try {
        // Insertar el producto
        $sql = $conex->prepare("INSERT INTO productos values (null,?,?,?,?,?,?,?,1)");
        $sql->bind_param("sssiiii", $this->nombre, $this->descripcion, $this->caracteristicas, $this->precio, $this->stock, $this->status, $this->tipo);
        $result = $sql->execute();
        //regresa el id del producto insetado
        $producto_id = $conex->insert_id;

        if ($this->imagenes) {

            //Verifica la puresa de las images
            foreach ($this->imagenes['tmp_name'] as $key => $tmp_name) {
                //filtrar por extension
                if ($this->imagenes['type'][$key] != 'image/jpeg') {
                    $flag["msg"] = "Error, el archivo no es imagen, o no es jpeg";
                    break 1;
                } else if ($this->imagenes['size'][$key] > 3 * 1024 * 1024) {
                    $flag["msg"] = "Algunas imagenes exeden el tamaño permitido, el máximo es de 3MB";
                    break 1;
                }
            }
            if (!isset($flag)) {
                // Insertar las imágenes
                foreach ($this->imagenes['tmp_name'] as $key => $tmp_name) {
                    $nombre_archivo = getUniqueName(pathinfo($this->imagenes['name'][$key], PATHINFO_EXTENSION));
                    $ruta_archivo = 'img/' . $nombre_archivo;
                    move_uploaded_file($tmp_name, $ruta_archivo);
                    $sql = $conex->prepare("INSERT INTO imagenes values(null,?,?,1)");
                    $sql->bind_param("is", $producto_id, $ruta_archivo);
                    $result = $sql->execute();
                }

                $conex->commit();
                $json["msg"] = "Producto creado correctamente";
            } else {
                $conex->rollback();
                $json["msg"] = "" . $flag["msg"];
            }
        } else {
            $conex->rollback();
            $json["msg"] = "No se a encontrado ninguna imagen";
        }

    } catch (Throwable $e) {
        // Si ocurre un error, deshacer la transacción y mostrar el mensaje de error
        $conex->rollback();
        $json["msg"] = "Error al crear el producto: " . $e;
    }
    // echo json_encode($json);

    $conex->close();
    return $json['msg'];
} catch (\Throwable $th) {
    //throw $th;
    return "Error: ".$th;
}
}
//-------------------------------------------------------------------------
//                      getProductos
//-------------------------------------------------------------------------
    public function getProductos($pathServer, $all)
    {
        try {
            //code...
            $conn = conexionMSQLI();
            if($all){
                $sql = "SELECT * FROM productos WHERE `as` = 1";
            }else{
                $sql = "SELECT * FROM productos WHERE Tipo_Producto_id = $this->tipo and `as` = 1 and status = 1 limit $this->precio";
            }
            $resultado = $conn->query($sql);
            $response = array();

            
            while ($fila = $resultado->fetch_assoc()) {
                $p = new Producto();
                $p->setId($fila['id']);
                $p->setNombre($fila['nombre']);
                $p->setPrecio($fila['precio']);
                $p->setStock($fila['stock']);
                $p->setStatus($fila['status']);
                $p->setDescripcion($fila['descripcion']);
                $p->settipo($fila['Tipo_Producto_id']);

                $sqlImages = "SELECT * FROM imagenes WHERE productos_id =" . $p->getId();
                $resultadoImages = $conn->query($sqlImages);
                $images = [];

                if ($resultadoImages->num_rows > 0) {
                    while ($fila = $resultadoImages->fetch_assoc()) {
                        $imagen["path"] = $pathServer . $fila["path"];
                        $imagen["id"] = $fila["id"];
                        array_push($images,$imagen );
                    }
                    $p->setImagenes($images);
                } else {
                    $p->setImagenes([]);
                }
                
                array_push($response, json_encode($p,JSON_UNESCAPED_UNICODE));
            }

            $conn->close();

            return $response;

        } catch (Throwable $th) {
            //throw $th;
            return "Error en funcion getProductosHome: " . $th;
        }
    }

}
?>