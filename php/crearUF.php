<?php
include("./conn.php");

$conn = conectar();

$nombre = $_POST['nombre'];
$mail = $_POST['email'];
$contra = $_POST['contra'];

$consulta = "SELECT * FROM `usuario` WHERE nombre = '$nombre' or mail = '$mail'";


$resultado = mysqli_query($conn, $consulta);

if (mysqli_num_rows($resultado) > 0) {
    echo"Ya hay usuarios con ese nombre o correo registrados";
} else {
    

    $contra_Hashed = password_hash($contra, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario (nombre,PASSWORD,mail) VALUES ('$nombre','$contra_Hashed','$mail')";

    if($conn->query($sql)){
        
        sleep(2);
        header("Location: http://localhost/FormularioLM/html/iniciarSUF.html", true,301);
        exit();
    }else{

        echo "No Registrado " . $conn->error;
    }
}
$conn->close();


