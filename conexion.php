<?php  
    //conexionPDO();
    function conexionPDO(){
        $host = "localhost";
        $dbname = "molinos";
        $username = "root";
        $pss = "";

        try{
            $conn = new PDO ("mysql:host=$host;dbname=$dbname",$username,$pss);
            // echo "Se conecto correctamente";
        } catch(PDOException $ex){
            echo "Error al conectar con la base de datos:$dbname, error: $ex";
            exit;
        }
        return $conn;
    }

    function conexionMSQLI(){
        $servername = "localhost";
        $database = "molinos";
        $username = "root";
        $password = "";
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $database);
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