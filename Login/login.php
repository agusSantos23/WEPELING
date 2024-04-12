<?php

$server = "localhost";
$username = 'root';
$password = '';
$dbname = 'usuarios';

$conn = new mysqli($servername, $username, $password, $dbname);


if($conn-> connect_error){
    die("Error en la conexion de la base de datos".$conn->connect_error);
}

$nameUser = $_POST['nameUser'];
$pass = $_POST['password'];


$consulta = "SELECT * FROM usuarios WHERE username ='$nameUser'";
$result = $conn->query($consulta);

if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    
    if(password_verify($password, $row["password"])){
        echo"bien";
    }else{
        echo"Pass mal";
    }
}else{
    echo "Usuario no encontrada";
}

$conn->close();
?>