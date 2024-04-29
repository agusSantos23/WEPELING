<?php
    include("../php/conn.php");

    if($_POST){

        $titulo = "Mensaje";
        $mensaje = "";

        $correo = $conn->real_escape_string($_POST['email']);
        $contra = $conn->real_escape_string($_POST['contra']);

        if(strlen($contra) < 8 || !preg_match('/[A-Z]/', $contra) || !preg_match('/[a-z]/', $contra)) {

            $mensaje = "La contraseña debe tener al menos 8 caracteres y contener al menos una letra mayúscula y una minúscula.";
    
        } else {

            $sql = "SELECT * FROM `usuario` WHERE mail = `$correo`";
            $resultado = mysqli_query($conn, $sql);

            

            if(mysqli_num_rows($resultado) > 0){

                $mensaje = "Contraseña actualizada correctamente";

            }else { 
                
                $mensaje = "No se ha encontrado ningún usuario con ese correo.";
            }

        }
    }

?>

<?php include("../templates/headerO.php"); ?>
    <?php include("../templates/decoracion.php"); ?>
    <header>
        <h1><a href="../index.php">WEPELINGS</a></h1>
        <h2>Recuperar Usuario</h2>
    </header>

    <main class="cuerpo">
        <form method="post">

            <div class="inputs">
                <label for="email">
                    <input type="email" id="email" name="email" placeholder="Correo" required>
                </label>

                <label for="contra">
                    <input type="password" id="contra" name="contra" placeholder="Nueva Contraseña" required>
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
    <?php include("../templates/footer.html"); ?>

</body>
</html>