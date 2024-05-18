<?php

//LLamada a la base de datos
include("./conn.php");

//Comprobar que llegar el id del usuario 
if (isset($_GET["idUsuario"]) || isset($_POST["idUsuario"])) {
    //Asignar en una variable
    $idUsuario = isset($_GET["idUsuario"]) ? $_GET["idUsuario"] : $_POST["idUsuario"];

    //Comprobar si llega por el metodo POST
    if (isset($_POST["idDirigible"])) {

        //Asignar y reasignar las variables
        $idDirigible = $_POST["idDirigible"];
        $idUsuario = $_POST["idUsuario"];

        //Comprobar que a llegado el valor de liked
        if (isset($_POST["liked"])) {

            //Al ser false se agregara a la bd asignado al usuario y true lo eliminara de la bd dependiendo del id de cada uno
            if ($_POST["liked"] === "false") {

                $sql = "INSERT INTO Hangares_de_Usuarios (ID_usuario, ID_dirigible) VALUES ('$idUsuario', '$idDirigible')";

                if (mysqli_query($conn, $sql)) {

                    echo "La operación de inserción";

                } else {

                    echo "ERROR: " . mysqli_error($conn);

                }

            } elseif ($_POST["liked"] === "true") {

                $sql = "DELETE FROM Hangares_de_Usuarios WHERE ID_usuario = '$idUsuario' AND ID_dirigible = '$idDirigible'";

                if (mysqli_query($conn, $sql)) {

                    echo "La operación de eliminación";

                } else {

                    echo "ERROR: " . mysqli_error($conn);
                }
            } else {

                echo "ERROR: Acción no válida";
            }

        } else {

            echo "ERROR: 'liked' no está definido";
        }

    } else {
        //Atraves del metodo Get devolveremos todos los Dirigibles asociados con el usuario

        $sql = "SELECT * FROM Hangares_de_Usuarios WHERE ID_usuario = '$idUsuario'";

        $resultado = mysqli_query($conn, $sql);

        if ($resultado) {

            //Traspasa la respuesta de mysql a una varible
            $dirigibles = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

            //Devolver respuesta como json
            echo json_encode($dirigibles);
            
        } else {

            echo "ERROR: No se pudieron obtener los datos del hangar del usuario. " . mysqli_error($conn);
        }
    }

} else {

    echo "ERROR: Datos incompletos";
}

//Cerrar la conexion
$conn->close();

