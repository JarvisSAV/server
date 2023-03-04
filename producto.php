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
    public function setImagenes($imagenes)
    {
        $this->imagenes = $imagenes;
    }
    public function jsonSerialize()
    {
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
//              edita un producto del catalogo    
//-------------------------------------------------------------------------
    function updateProducto()
    {
        $conex = conexionMSQLI();

        try{
            // Iniciar la transacción
            $conex->begin_transaction();

            try {
                // Actualiza el producto
                $sql = "UPDATE productos set nombre = '$this->nombre', descripcion = '$this->descripcion', caracteristicas = '$this->caracteristicas', precio = $this->precio, stock = $this->stock, status = $this->status, Tipo_Producto_id = $this->tipo where id = $this->id";
                echo $sql;
                $resp = $conex->query($sql);


                if ($this->imagenes) {

                    //Verifica la puresa de las images
                    foreach ($this->imagenes['tmp_name'] as $key => $tmp_name) {
                        //filtrar por extension
                        if ($this->imagenes['type'][$key] != 'image/jpeg' && $this->imagenes['type'][$key] != 'image/png') {
                            $flag["msg"] = "Error, no se admiten archivos con extension " . $this->imagenes['type'][$key];
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
                            $sql->bind_param("is", $this->id, $ruta_archivo);
                            $result = $sql->execute();
                        }

                        $conex->commit();
                        $json["flag"] = true;
                        $json["msg"] = "Producto editado correctamente";
                    } else {
                        $conex->rollback();
                        $json["flag"] = false;
                        $json["msg"] = "" . $flag["msg"];
                    }
                } else {
                    // $conex->rollback();
                    $conex->commit();
                    $json["flag"] = true;
                    $json["msg"] = "Producto editado correctamente";
                }
            } catch (Throwable $e) {
                // Si ocurre un error, deshacer la transacción y mostrar el mensaje de error
                $conex->rollback();
                $json["flag"] = false;
                $json["msg"] = "Error al editar el producto: " . $e;
            }
            
            $conex->close();
            return $json;

        }catch (\Throwable $th) {
            //throw $th;
            return "Error: ".$th;
        }
    }
    //-------------------------------------------------------------------------
//              Elimina un producto de catalogo    
//-------------------------------------------------------------------------
    function deleteProducto()
    {
        try {
            //code...
            $conn = conexionMSQLI();

            $sql = "UPDATE productos set `as` = 0 where id = $this->id";
            $resp = $conn->query($sql);
            if (mysqli_errno($conn))
                $json["msg"] = mysqli_errno($conn) . ": " . mysqli_error($conn);
            else
                $json["msg"] = "Registro Eliminado";

            $conn->close();
            return $json;

        } catch (\Throwable $th) {
            //throw $th;
            return "Error en el servidor";
        }
    }
    //-------------------------------------------------------------------------
//              consulta toda la informacion de un solo producto        
//-------------------------------------------------------------------------
    function getSingleProducto($pathServer)
    {
        try {
            $conn = conexionMSQLI();

            $sql = "SELECT * FROM productos WHERE id = $this->id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                if ($fila = $result->fetch_assoc()) {
                    $this->tipo = $fila["Tipo_Producto_id"];
                    $this->id = $fila["id"];
                    $this->nombre = $fila["nombre"];
                    $this->precio = $fila["precio"];
                    $this->stock = $fila["stock"];
                    $this->status = $fila["status"];
                    $this->descripcion = $fila["descripcion"];
                    $this->caracteristicas = $fila["caracteristicas"];
                }

                $json = $this->getImagenes($this, $conn, $pathServer);

            } else {
                $json = [];
            }

            $conn->close();
            return $json;

        } catch (\Throwable $th) {
            //throw $th;
            return 'Error: ' . $th;
        }
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
            return "Error: " . $th;
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
            if ($all) {
                $sql = "SELECT * FROM productos WHERE `as` = 1";
            } else {
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

                $p = $this->getImagenes($p, $conn, $pathServer);

                array_push($response, json_encode($p, JSON_UNESCAPED_UNICODE));
            }

            $conn->close();

            return $response;

        } catch (Throwable $th) {
            //throw $th;
            return "Error en funcion getProductosHome: " . $th;
        }
    }

    //-------------------------------------------------------------------------
//                      obtener imagenes de un producto
//-------------------------------------------------------------------------
    function getImagenes($p, $conn, $pathServer)
    {
        $sqlImages = "SELECT * FROM imagenes WHERE productos_id = $p->id and `as` = 1";
        $resultadoImages = $conn->query($sqlImages);
        $images = [];

        if ($resultadoImages->num_rows > 0) {
            while ($fila = $resultadoImages->fetch_assoc()) {
                $imagen["path"] = $pathServer . $fila["path"];
                $imagen["id"] = $fila["id"];
                array_push($images, $imagen);
            }
            $p->setImagenes($images);
        } else {
            $p->setImagenes([]);
        }

        // $conn->close();
        return $p;
    }
}
?>