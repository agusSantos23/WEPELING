<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    if(isset($_POST["idDirigible"]) && isset($_POST["idUsuario"])){
        include("./conn.php");

        $idDirigible = $_POST["idDirigible"];
        $idUsuario = $_POST["idUsuario"];


        $sql = "INSERT INTO Hangares_de_Usuarios (ID_usuario,ID_dirigible) VALUES ('$idUsuario','$idDirigible')";

        if(mysqli_query($conn, $sql)){
            echo "Todo a salido bien";
        }else{
            echo "ERROR: No se pudo ejecutar la consulta. " . mysqli_error($conn);
        }

        $conn->close();

    }