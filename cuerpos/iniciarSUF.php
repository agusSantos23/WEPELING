<?php
    session_start();
    include("../php/conn.php");

    if($_POST){
        
        $titulo = "Mensaje";
        $mensaje = "";

        //Medida de seguridad para controlar caracteres especiales en consultas
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $contra = $conn->real_escape_string($_POST['contra']);

        
        $sql = "SELECT * FROM Usuario WHERE Nombre = '$nombre'";

        $resultado = mysqli_query($conn,$sql);

        if(mysqli_num_rows($resultado) > 0){
            
            $usuarioD = mysqli_fetch_assoc($resultado);
            
            
            if(password_verify($contra, $usuarioD['Password'])){


                $_SESSION["user"] = $usuarioD['Nombre'];
                $_SESSION["logueado"] = true;
                header("Location: ./hangarU.php");
                exit();

            } else {
                
                $mensaje = "Contraseña incorrecta.";
            }
        } else { 
            
            $mensaje = "No se ha encontrado ningún usuario. Puede recuperar la contraseña en el siguiente <a href=recuperarU.php>enlace</a>.";
        }

        $conn->close();
    }

    

?>
<?php include("../templates/headerO.php"); ?>
    <?php include("../templates/decoracionO.php"); ?>

    <header>
        <h1><a href="../index.php">WEPELINGS</a></h1>
        <h2>Iniciar Sesion</h2>
    </header>

    <main class="cuerpo">
        <form method="post">

            <div class="inputs">
                <label for="nombre">
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                </label>

                <label for="contra">
                    <input type="password" id="contra" name="contra" placeholder="Contraseña" required>
                </label>
            </div>
            
            <button type="submit">Enviar</button>
        </form>
        
    </main>
    <aside class="mensaje">
        <h3><?php echo $titulo ?></h3>
        <p>
            <?php echo $mensaje ?>       
        </p> 
    </aside>
    <?php include("../templates/footer.html") ?>
</body>
</html>