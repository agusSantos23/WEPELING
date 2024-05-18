<?php
    //Iniciar las variables de sesion
    session_start();
    //Conexion a la bd
    include("../php/conn.php");


    //Inicializamos las variables para que puedan ser asignados los mensajes
    $titulo = "Mensaje";
    $mensaje = "Se ha enviado un correo electrónico con el código de verificación a tu dirección de correo electrónico.";
    
    //Si se a activado el metodo Post
    if($_POST){

        //Recibir el valor del metodo POST evitando Inyeccion en la consulta de la bd
        $codigoU = $conn->real_escape_string($_POST['codigo']);
        $contraU = $conn->real_escape_string($_POST['contra']);

        //Recibe los valores de la variable de sesion
        $idU = $_SESSION['id_usuario'];
        $codigoGenerado = $_SESSION['codigo_generado'];

        if($codigoGenerado == $codigoU){

            //Comprueba que la contraseña sea segura
            if(strlen($contraU) < 8 || !preg_match('/[A-Z]/', $contraU) || !preg_match('/[a-z]/', $contraU)) {
                
                $titulo = "Mensaje";
                $mensaje = "La contraseña debe tener al menos 8 caracteres y contener al menos una letra mayúscula y una minúscula.";
                    
            }else{

                // Hashea la contraseña nueva para para subirla hasheada a la bd
                $contraU_Hashed = password_hash($contraU, PASSWORD_DEFAULT);
                // Crea la consulta
                $sql = "UPDATE Usuario SET Password = '$contraU_Hashed' WHERE ID_usuario = $idU";

                

                if(mysqli_query($conn, $sql)){
                    //Destrulle la sesion creada
                    session_destroy();
                    //Redirigir a la pagina de inicio de sesion
                    header("Location: iniciarSUF.php");
                    //Asegurarse de que sale del documento
                    exit();

                }else{
                    
                    $mensaje = "Error al subir los datos a la base de datos. Intentalo de nuevo o mas tarde.";
                }
            }

        }else{

            $titulo = "Error";
            $mensaje = "Los codigos no coinciden.";
        }
    }

    include("../templates/headerO.php"); 
    include("../templates/decoracionO.php"); 
?>

    <header>
        <h1><a href="../index.php">WEPELINGS</a></h1>
        <h2>Recuperar Usuario</h2>
    </header>

    <main class="cuerpo">
        <form method="post">

            <div class="inputs">
                <label for="codigo">
                    <input type="text" id="codigo" name="codigo" placeholder="Codigo" required>
                </label>

            <label for="contra">
                    <input type="password" name="contra" id="contra" placeholder="Contraseña" require>
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