<?php 
    //Iniciar las variables de sesion
    session_start();

    //Comprueba de que la sesion este iniciada con en las dos variables
    if (isset($_SESSION["user"]) && $_SESSION["logueado"]) {    
        //Decidira el enlace del Hangar del Usuario o el Escaparate
        $presentacion = ($nombreEnlace == "Escaparate") ? "Hangar de " . $_SESSION["user"] : "Escaparate";
        $presentacion = ($nombreEnlace == "") ? "Con " . $_SESSION["user"] : $presentacion;

    }else{
        //Si no tiene las dos variables de sesion iniciadas volvera a la pagina de inicio
        header("Location: ../index.php");
        exit();
    }
    
    //Si detecta el metodo Get primero vaciara la sesion y despues la destruira, por ultimo lo devulve a la pagina de inicio
    if(isset($_GET['cerrar_sesion'])) {
        
        session_unset();
        session_destroy();
        
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
    <link rel="stylesheet" href="../css/footerI.css">
    <link rel="stylesheet" href="../css/decoracionI.css">
    <title>WEPELINGS-ADMINISTRACION</title>
</head>
<body>
    <header>
        <div>
            <h1>WEPELINGS</h1>
            <h2><?php echo $presentacion ?></h2>
        </div>

        <nav>
            <a href="?cerrar_sesion=true">Cerrar Sesion</a>
            
            <a href="<?php echo $direccion ?>"><?php echo $nombreEnlace ?></a>
        </nav>

    </header>