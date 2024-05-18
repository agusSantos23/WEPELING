<?php
    //Conexion a la base de datos
    //Configuracion de conexion
    $servername = "localhost";
    $database = "zepelin";
    $username = "root";
    $password = "";

    //Intento de conexion con la base de datos
    try{

        $conn = new mysqli($servername,$username,$password,$database);

    }catch(Exception $e){

        echo $e->getMessage();
    }

