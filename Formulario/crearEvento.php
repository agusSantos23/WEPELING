<?php

    $hostname = "localhost";
    $bd = "gestorEventos";
    $usuario = "root";
    $pass = "";

    $conn = new mysqli($hostname,$usuario,$pass,$bd);

    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }
    
    if($_POST){

        $nombre = $_POST["name"];
        $fecha = $_POST["date"];
        $ubicacion = $_POST["location"];
        $areaDescripcion = $_POST["areaDescription"];
        $categoria = $_POST["cate"];
        $pago = $_POST["tipePay"];



        
    }else{
        echo "No ha llegado nada"
    }