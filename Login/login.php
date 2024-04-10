<?php

$server = "localhost";
$username = 'root';
$password = '';
$dbname = 'usuarios';

$conn = new msqli($servername, $username, $password, $dbname);


if($conn-> connect_error){
    die("Error en la conexion de la base de datos".$conn->connect_error);
}

$nameUser = $_POST['nameUser'];
$pass = $_POST['password'];


$consulta = "SELECT * FROM usuarios WHERE username ='$nameUser'";
$result = $conn-query($consulta);

if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    if(password_verify($pass, $row["password"])){
        header("Location: index.html");
        exit();
    }else{
        echo"Pass mal";
    }


}else{
    echo "Usuario no encontrada"
}

$conn->close();
?>



