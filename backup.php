<?php
include('config.php');
try {
    $conn = conexionMSQLI();

    date_default_timezone_set("America/Mexico_City");
    $fecha = date('Ymd_His');
    $nombre_archivo = 'backup_'.$fecha.'.sql';

    // Configuración de la base de datos
    $host = 'localhost';
    $usuario = 'admin';
    $contrasena = '1234';
    $base_datos = 'molinos';

    // Ruta del archivo de respaldo
    $ruta_backup = './backups/'.$nombre_archivo;

    // Comando para realizar el respaldo
    $comando = "mysqldump -h$host -u$usuario -p$contrasena --opt $base_datos > ".$ruta_backup;

    // Ejecución del comando
    exec($comando);
} catch (\Throwable $th) {
    //throw $th;
    echo "".$th;
}
?>