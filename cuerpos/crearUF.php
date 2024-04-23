<?php 

    $servername = "localhost";
    $database = "zepelin";
    $username = "root";
    $password = "";


    try{

        $conn = new mysqli($servername,$username,$password,$database);

    }catch(Exception $e){

        echo $e->getMessage();
    }

    if($_POST){

        $titulo = "Mensaje";
        $mensaje = "";

        $nombre = $_POST['nombre'];
        $mail = $_POST['email'];
        $contra = $_POST['contra'];

        $consulta = "SELECT * FROM `usuario` WHERE nombre = '$nombre' OR mail = '$mail'";


        $resultado = mysqli_query($conn, $consulta);

        if(mysqli_num_rows($resultado) > 0) {

            $mensaje = "Ya hay usuarios con ese nombre o correo registrados";

        } else {
            

            $contra_Hashed = password_hash($contra, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuario (nombre,PASSWORD,mail) VALUES ('$nombre','$contra_Hashed','$mail')";

            if($conn->query($sql)){
                
                $mensaje = "Si";
            }else{

                echo "No Registrado " . $conn->error;
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
    <link rel="stylesheet" href="../css/decoracionUno.css">
    
    <title>Crear usuario</title>
</head>
<body>
    <?php include("../templates/decoracion.php"); ?>
    <header>
        <h1>WEPELINGS</h1>
        <h2>Creacion de usuario</h2>
    </header>
    <main>
        <form method="post">
            
            <div class="inputs">
                <label for="nombre">
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre">
                </label>
    
                <label for="email">
                    <input type="email" id="email" name="email" placeholder="Correo">
                </label>
                
    
                <label for="contra">
                    <input type="password" id="contra" name="contra" placeholder="Contraseña">
                </label>
            </div>
            

            <button type="submit">Crear Usuario</button>
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