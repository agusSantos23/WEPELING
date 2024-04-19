<?php

include("./conn.php");


$nombre = $_POST['nombre'];
$contra = $_POST['contra'];


$consulta = "SELECT * FROM `usuario` WHERE nombre = '$nombre' && PASSWORD = '$contra'";

$resultado = mysqli_query($con,$consulta);

if(mysqli_num_rows($resultado)> 0){

   echo"si";
}else{

    echo "No se a encontrado ningun usuario.";
}

