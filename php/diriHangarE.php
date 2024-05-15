<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    if(isset($_POST["idDirigible"]) && isset($_POST["idUsuario"])){
        include("./conn.php");

        $idDirigible = $_POST["idDirigible"];
        $idUsuario = $_POST["idUsuario"];

        $sql = "DELETE FROM Hangares_de_Usuarios Where ID_usuario = '$idUsuario' && ID_dirigible = '$idDirigible'";

        if(mysqli_query($conn, $sql)){
            echo "Todo a salido bien";
        }else{
            echo "ERROR: No se pudo ejecutar la consulta. " . mysqli_error($conn);
        }

        $conn->close();
    }