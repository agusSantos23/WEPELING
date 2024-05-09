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
    
            $sql = "SELECT * FROM Usuario WHERE Nombre = '$nombre' OR Correo_electronico = '$mail'";
            $resultado = mysqli_query($conn, $sql);
        
            if(mysqli_num_rows($resultado) > 0) {

                $mensaje = "Ya hay usuarios con ese nombre o correo registrados";

            } else {
                $contra_Hashed = password_hash($contra, PASSWORD_DEFAULT);
        
                $sql = "INSERT INTO Usuario (Nombre,Password,Correo_electronico) VALUES ('$nombre','$contra_Hashed','$mail')";
        
                $resultado = mysqli_query($conn, $sql);
                if($resultado){

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

<?php include("../templates/headerO.php"); ?>
    <?php include("../templates/decoracionO.php"); ?>


    <header>
        <h1><a href="../index.php">WEPELINGS</a></h1>
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

    </main>

    <aside class="mensaje">
        <h3><?php echo $titulo ?></h3>
        <p>
            <?php echo $mensaje ?>
        </p>
    </aside>
    <?php include("../templates/footer.html"); ?>

</body>
</html>