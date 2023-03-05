<?php
class Usuario
{
    private $id;
    private $usuarname;
    private $password;
    private $nombre;
    private $apaterno;
    private $amaterno;
    private $fechaNac;
    private $mail;
    private $tipo;
    private $as;
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getUsername()
    {
        return $this->usuarname;
    }
    public function setUsername($usuarname)
    {
        $this->usuarname = $usuarname;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPasword($password)
    {
        $this->password = $password;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function getApaterno()
    {
        return $this->apaterno;
    }
    public function setApaterno($apaterno)
    {
        $this->apaterno = $apaterno;
    }
    public function getAmaterno()
    {
        return $this->amaterno;
    }
    public function setAmaterno($amaterno)
    {
        $this->amaterno = $amaterno;
    }
    public function getFechaNac()
    {
        return $this->fechaNac;
    }
    public function setFechaNac($fechaNac)
    {
        $this->fechaNac = $fechaNac;
    }
    public function getMail()
    {
        return $this->mail;
    }
    public function setMail($mail)
    {
        $this->mail = $mail;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function getAs()
    {
        return $this->as;
    }
    public function setAs($as)
    {
        $this->as = $as;
    }
    //-------------------------------------------------------------------------
//              crear usuario
//-------------------------------------------------------------------------
    function crearUsuario()
    {
        $conn = conexionMSQLI();
        $password = md5($this->password);

        try {
            $sql = $conn->prepare("INSERT into usuarios values (null,?,?,?,?,?,?,?,1,2,1)");
            $sql->bind_param('sssssss', $this->usuarname, $password, $this->nombre, $this->apaterno, $this->amaterno, $this->fechaNac, $this->mail);
            $result = $sql->execute();

            $conn->close();

            $json['msg'] ="Registro exitoso";
            $json['flag'] =true;

            return $json;

        } catch (\Throwable $th) {
            return false;
        }

    }
    //-------------------------------------------------------------------------
//              Validar usuario
//-------------------------------------------------------------------------
    public function validarUsuario()
    {

        try {
            $conex = conexionMSQLI();

            $sql = "SELECT * from usuarios where username = '$this->usuarname'";
            $result = mysqli_query($conex, $sql);
            $json = array();

            if (mysqli_num_rows($result)) {
                if ($row = mysqli_fetch_array($result)) {
                    if (md5($this->password) == $row["password"]) {
                        $json["flag"] = true;
                        $json["id"] = $row["id"];
                        $json["msg"] = "Verificacion Exitosa ";
                    } else {
                        $json["flag"] = false;
                        $json["msg"] = "Usuario o contraseña incorrectos";
                    }
                }
            } else {
                $json["flag"] = false;
                $json["msg"] = "Usuario o contraseña incorrectos";
            }

            $conex->close();

            return $json;

        } catch (\Throwable $e) {
            //throw $th;
            $json["msg"] = "Error en el servidor".$e;
            return $json;
        }
    }
}
?>