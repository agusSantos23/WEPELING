<?php 
    session_start();

    

    if (isset($_SESSION["user"]) && $_SESSION["logueado"]) {    
        
        $Bienvenida = "Nos alegra verte de nuevo, " . $_SESSION["user"];

    }else{

        header("Location: ../index.php");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/baseI.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/decoracionI.css">
    <title>Hangar</title>
</head>
<body>