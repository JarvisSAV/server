<?php  
    // conexionPDO();
    // conexionMSQLI();
    // function conexionPDO(){
    //     $host = "127.0.0.1";
    //     $dbname = "molinos";
    //     $username = "root";
    //     $pss = "";

    //     try{
    //         $conn = new PDO ("mysql:host=$host;dbname=$dbname",$username,$pss);
    //         // echo "Se conecto correctamente";
    //     } catch(PDOException $ex){
    //         echo "Error al conectar con la base de datos:$dbname, error: $ex";
    //         exit;
    //     }
    //     return $conn;
    // }

    function conexionMSQLI(){
        $servername = "containers-us-west-93.railway.app";
        $database = "railway";
        $username = "root";
        $password = "gupZAagttaKdHHSo4OFi";
        $port = '6769';
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $database,$port);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{
            // echo "Connected successfully";    
        }

        return $conn;

        // mysqli_close($conn);
    }
?>