<?php
    //Iniciar las variables de sesion
    session_start();
    //Iniciar la conexion a la bd
    include("../php/conn.php");

    if($_POST){
        
        $titulo = "Mensaje";
        $mensaje = "";

        //Medida de seguridad para controlar caracteres especiales en consultas
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $contra = $conn->real_escape_string($_POST['contra']);

        //Consulta comprobando el nombre de usuario en la base de datos
        $sql = "SELECT * FROM Usuario WHERE Nombre = '$nombre'";
        //Ejecutar consulta a la base de datos
        $resultado = mysqli_query($conn,$sql);

        //Comprueba si ha encontrado algun resultado
        if(mysqli_num_rows($resultado) > 0){
            
            //Asigna los datos del usuaruario de la primera fila que se encuentre
            $usuarioD = mysqli_fetch_assoc($resultado);
            
            //Comprobar la contraseña hasheada de la bd con la contraseña introducida por el usuario
            if(password_verify($contra, $usuarioD['Password'])){

                //Iniciar las variables de sesion con los valores
                $_SESSION["user"] = $usuarioD['Nombre'];
                $_SESSION['id'] = $usuarioD['ID_usuario'];
                $_SESSION["logueado"] = true;
                
                //Redirigir a la pagina de inicio de sesion
                header("Location: ./hangarU.php");
                //Asegurarse de que sale del documento
                exit();

            } else {
                
                $mensaje = "Contraseña incorrecta.";
            }
        } else { 
            
            $mensaje = "No se ha encontrado ningún usuario. Puede recuperar la contraseña en el siguiente <a href=recuperarU.php>enlace</a>.";
        }

        $conn->close();
    }

    include("../templates/headerO.php"); 
    include("../templates/decoracionO.php"); 

?>

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