<?php
    include("../php/conn.php");

    if($_POST){
        
        $codigo = mysqli_real_escape_string($conn, $_POST['codigo']);

        $sql = "SELECT * FROM `administrador` WHERE codigo = '$codigo'";

        $resultado = mysqli_query($conn, $sql);

        if(mysqli_num_rows($resultado) > 0){

            echo "si";

        }else{
            
            header("Location: ../index.html");

            exit();
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/decoracionUno.css">
    <title>Iniciar sesion Administrador</title>
</head>
<body>
    <?php include("../templates/decoracion.php"); ?>

    <header>
        <h1><a href="../index.html">WEPELINGS</a></h1>
        <h2>Administracion</h2>
    </header>
    <main>
        <form method="post">
            
            <label for="codigo">
                <input type="password" id="codigo" name="codigo" placeholder="Codigo" required>
            </label>
            <button type="submit">Enviar</button>
        </form>
    </main>
</body>
</html>