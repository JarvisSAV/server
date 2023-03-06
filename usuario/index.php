<?php
include('../config.php');
include('./usuario.php');

try {
    $accion = "No se encontro ninguna accion";
    $result = false;

    $usuario = new Usuario();
    
    if(isset($input['accion'])){
        $accion = $input['accion'];
        $usuario->setId($input['usuario']['_id']);
        $usuario->setUsername($input['usuario']['_username']);
        $usuario->setPasword($input['usuario']['_password']);
        $usuario->setNombre($input['usuario']['_nombre']);
        $usuario->setApaterno($input['usuario']['_apaterno']);
        $usuario->setAmaterno($input['usuario']['_amaterno']);
        $usuario->setFechaNac($input['usuario']['_fechaNac']);
        $usuario->setMail($input['usuario']['_mail']);
        $usuario->setTipo($input['usuario']['_tipo']);
        $usuario->setAs($input['usuario']['_as']);
    }

    switch($accion){
        case 'crearUsuario':
            $result = $usuario->crearUsuario();
            break;
        case 'validarUsuario':
            $result = $usuario->validarUsuario();
            break;
        case 'getUsuario':
            $result = $usuario->getUsuario();
            break;
        default:
            break;
    }

    if(!$result){
        $json = "No se encontro ninguna accion";
    }else{
        $json = $result;
    }

} catch (\Throwable $th) {
    $json['flag'] = false; 
    $json['msg'] = "Error en index: ".$th; 
}
echo json_encode($json);
?>