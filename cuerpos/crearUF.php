<?php 
    include("../php/conn.php");
    
    if($_POST){

        $titulo = "Mensaje";
        $mensaje = "";

        $nombre = $conn->real_escape_string($_POST['nombre']);
        $mail = $conn->real_escape_string($_POST['email']);
        $contra = $conn->real_escape_string($_POST['contra']);

        

        if(strlen($contra) < 8 || !preg_match('/[A-Z]/', $contra) || !preg_match('/[a-z]/', $contra)) {

            $mensaje = "La contraseña debe tener al menos 8 caracteres y contener al menos una letra mayúscula y una minúscula.";
    
        } else {
    
            $sql = "SELECT * FROM `usuario` WHERE nombre = '$nombre' OR mail = '$mail'";
            $resultado = mysqli_query($conn, $sql);
        
            if(mysqli_num_rows($resultado) > 0) {

                $mensaje = "Ya hay usuarios con ese nombre o correo registrados";

            } else {
                $contra_Hashed = password_hash($contra, PASSWORD_DEFAULT);
        
                $sql = "INSERT INTO usuario (nombre,PASSWORD,mail) VALUES ('$nombre','$contra_Hashed','$mail')";
        
                if($conn->query($sql)){

                    header("Location: iniciarSUF.php");
                    exit();

                } else {
                    echo "No Registrado " . $conn->error;
                }
            }
        }


        $conn->close();

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/decoracionUno.css">
    
    <title>Crear usuario</title>
</head>
<body>
    <?php include("../templates/decoracion.php"); ?>
    <header>
        <h1><a href="../index.html">WEPELINGS</a></h1>
        <h2>Creacion de usuario</h2>
    </header>
    <main class="cuerpo">
        <form method="post">
            
            <div class="inputs">
                <label for="nombre">
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                </label>
    
                <label for="email">
                    <input type="email" id="email" name="email" placeholder="Correo" required>
                </label>
                
    
                <label for="contra">
                    <input type="password" id="contra" name="contra" placeholder="Contraseña" required>
                </label>
            </div>
            

            <button type="submit">Crear Usuario</button>
        </form>

        <?php include("./templates/footer.html"); ?>
    </main>

    <aside class="mensaje">
        <h3><?php echo $titulo ?></h3>
        <p>
            <?php echo $mensaje ?>
        </p>
    </aside>
</body>
</html>