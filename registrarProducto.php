<?php
include("config.php");
session_start();

$conex = conexionMSQLI();
$nombre = $input["nombre"];
$precio = $input["precio"];
$stock = $input["stock"];
$decripcion = $input["descripcion"];
$caracteristicas = $input["caracteristicas"];
$tipo = $input["tipo"];
$status = $input["status"];
$json = Array();

// try {
//     $sql = $conex->prepare("INSERT INTO  productos values (null,?,?,?,?,?,?)");
//     $json =["flag" => $sql->execute([$nombre,$decripcion,$precio,$stock,$status,$tipo])];
//     $json += ["msg" => "Registro Exitoso"];
//     echo json_encode($json);
// } catch (PDOException $th) {
//     $json = ["flag" => false];
//     $json += ["msg" => $th];
//     echo json_encode($json);
// }

// try {
//     //code...
//     $sql = "INSERT INTO productos values (null,'$nombre','$decripcion','$caracteristicas',$precio,$stock,$status,$tipo)";
//     $result = mysqli_query($conex,$sql);
//     // mysqli_errno($conex) . ": " . mysqli_error($conex) . "\n";
//     if(mysqli_errno($conex)){
//         $json["flag"] = false;
//         $json["msg"] = mysqli_errno($conex) . ": " . mysqli_error($conex);
//     }else{
//         $json["flag"] = true;
//         $json["msg"] = "Registro Exitoso";
//     }
// } catch (\Throwable $th) {
//     //throw $th;
//     $json["flag"] = false;
//     $json["msg"] = "".$th;
// }
try {
    //code...
    $sql = $conex->prepare("INSERT INTO productos values (null,?,?,?,?,?,?,?)");
    $sql->bind_param("sssiiii",$nombre,$decripcion,$caracteristicas,$precio,$stock,$status,$tipo);
    $result = $sql->execute(); 

    if(!$result){
        $json["flag"] = false;
        $json["msg"] = mysqli_errno($conex) . ": " . mysqli_error($conex);
    }else{
        $json["flag"] = true;
        $json["msg"] = "Registro Exitoso";
    }

    echo json_encode($json);
    // $json["msg"] = $result;
} catch (\Throwable $th) {
    //throw $th;
    $json["flag"] = false;
    $json["msg"] = "".$th;
    echo json_encode($json);
}

?>