<?php
include("./conn.php");

$conn = conectar();

$nombre = $_POST['nombre'];

$contra = $_POST['contra'];

$contra_Hashed = password_hash($contra, PASSWORD_DEFAULT);


$sql = "INSERT INTO usuario (nombre,PASSWORD) VALUES ('$nombre','$contra_Hashed')";

if($conn->query($sql)){
    
    sleep(2);
    header("Location: http://localhost/FormularioLM/html/iniciarSUF.html", true,301);
    exit();
}else{

    echo "No Registrado " . $conn->error;
}

$conn->close();


