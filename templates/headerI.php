<?php 
    session_start();

    if (isset($_SESSION["user"]) && $_SESSION["logueado"]) {    
        
        $mensaje = ($nombreEnlace == "Escaparate") ? "Hangar de " . $_SESSION["user"] : "Escaparate";
        $mensaje = ($nombreEnlace == "") ? "Administracion con " . $_SESSION["user"] : $mensaje;

    }else{

        header("Location: ../index.php");
        exit();
    }

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
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/decoracionI.css">
    <title>Hangar</title>
</head>
<body>
    <header>
        <div>
            <h1>WEPELINGS</h1>
            <h2><?php echo $mensaje ?></h2>
        </div>

        <span>
            <a href="?cerrar_sesion=true">Cerrar Sesion</a>
            
            <a href="<?php echo $direccion ?>"><?php echo $nombreEnlace ?></a>
        </span>
            
        

        
        
    </header>