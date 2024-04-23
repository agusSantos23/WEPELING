<?php
    

    include("../php/conn.php");

    if($_POST){
        
        $titulo = "Mensaje";
        $mensaje = "";

        $nombre = $_POST['nombre'];
        $contra = $_POST['contra'];


        $consulta = "SELECT * FROM `usuario` WHERE nombre = '$nombre' && PASSWORD = '$contra'";

        $resultado = mysqli_query($conn,$consulta);

        if(mysqli_num_rows($resultado) > 0){
            $mensaje = "si";
        }else{

            $mensaje = "No se a encontrado ningun usuario.";
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
    <title>Usuario</title>
</head>
<body>
    <?php include("../templates/decoracion.php"); ?>

    <header>
        <h1>WEPELINGS</h1>
        <h2>Iniciar Sesion</h2>
    </header>

    <main>
        <form method="post">

            <div class="inputs">
                <label for="nombre">
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre">
                </label>

                <label for="contra">
                    <input type="password" id="contra" name="contra" placeholder="Contraseña">
                </label>
            </div>
            
            <button type="submit">Enviar</button>
        </form>
        
    </main>
    <aside>
        <h3><?php echo $titulo ?></h3>
        <p>
            <?php echo $mensaje ?>
        </p> 
    </aside>
</body>
</html>