<?php

//LLamada a la base de datos
include("./conn.php");

//Consulta
$sql = "SELECT * FROM Dirigibles";
//Ejecucion de la consulta
$resultado = mysqli_query($conn, $sql);

//Confirmacion de resultados
if ($resultado) {

    //Traspasa la respuesta de mysql a una varible
    $dirigibles = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

    //Devolver respuesta como json
    echo json_encode($dirigibles);

} else {

    //Mensaje de error
    echo "ERROR: No se pudieron obtener los dirigibles. " . mysqli_error($conn);

}

//Cerrar la conexion
$conn->close();

