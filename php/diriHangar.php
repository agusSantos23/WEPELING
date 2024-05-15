<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("./conn.php");

if (isset($_GET["idUsuario"]) || isset($_POST["idUsuario"])) {

    $idUsuario = isset($_GET["idUsuario"]) ? $_GET["idUsuario"] : $_POST["idUsuario"];

    if (isset($_POST["idDirigible"])) {

        $idDirigible = $_POST["idDirigible"];
        $idUsuario = $_POST["idUsuario"];

        if (isset($_POST["liked"])) {

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

        $sql = "SELECT * FROM Hangares_de_Usuarios WHERE ID_usuario = '$idUsuario'";

        $resultado = mysqli_query($conn, $sql);

        if ($resultado) {

            $rows = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            echo json_encode($rows);
            
        } else {

            echo "ERROR: No se pudieron obtener los datos del hangar del usuario. " . mysqli_error($conn);
        }
    }

} else {

    echo "ERROR: Datos incompletos";
}


$conn->close();

