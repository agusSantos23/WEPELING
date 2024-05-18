<?php 
    //LLamada a la base de datos
    include("./conn.php");

    //Comprobar si han llegado los dos valores 
    if(isset($_POST["idDirigible"]) && isset($_POST["idUsuario"])){

        //Guardar valores en variables
        $idDirigible = $_POST["idDirigible"];
        $idUsuario = $_POST["idUsuario"];

        //Crear consulta
        $sql = "DELETE FROM Hangares_de_Usuarios Where ID_usuario = '$idUsuario' && ID_dirigible = '$idDirigible'";

        //Ejecutar consulta 
        if(mysqli_query($conn, $sql)){

            echo "Todo a salido bien";
        }else{
            
            echo "ERROR: No se pudo ejecutar la consulta. " . mysqli_error($conn);
        }

        //Cerrar la conexion
        $conn->close();
    }