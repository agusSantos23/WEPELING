<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("./conn.php");

$sql = "SELECT * FROM Dirigibles";
$resultado = mysqli_query($conn, $sql);

if ($resultado) {

    $dirigibles = array();

    foreach ($resultado as $fila) {
        $dirigibles[] = $fila;
    }

    echo json_encode($dirigibles);

} else {

    echo "ERROR: No se pudieron obtener los dirigibles. " . mysqli_error($conn);

}

$conn->close();

