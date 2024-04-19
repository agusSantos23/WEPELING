<?php
include("./conn.php");

$conn = conectar();

$codigo = $_POST['codigo'];

$sql = "SELECT * FROM `administrador` WHERE codigo = 1234";

$result = mysqli_query($conn, $sql);

if ($result){
    $row = $result->fetch_assoc();
    

    if ($row['codigo'] == $codigo){
        header('Local: http://localhost/FormularioLM/html/hangarA.php');
    }else{
        echo 'no son iguales';
        
        echo $codigo;
    }
} else{

    echo "Ha fallado la consulta";
}

$conn->close();

?>