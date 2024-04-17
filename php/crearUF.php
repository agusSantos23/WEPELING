<?php
include("./conn.php");

$conn = conectar();

$nombre = $_POST['nombre'];

$contra = $_POST['contra'];

$contra_Hashed = password_hash($contra, PASSWORD_DEFAULT);


$sql = "INSERT INTO usuario (nombre,PASSWORD) VALUES ('$nombre','$contra_Hashed')";

if($conn->query($sql)){
    echo "Registrado";
}else{
    echo "No Registrado " . $conn->error;
}

$conn->close();


