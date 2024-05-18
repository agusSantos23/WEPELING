<?php
    //Iniciar las variables de sesion
    session_start();
    
    //LLamar a los archivos de PHPMailer
    require "../PHPMailer/Exception.php";
    require "../PHPMailer/PHPMailer.php";
    require "../PHPMailer/SMTP.php";

    //Importamos la clase de PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;

    //Llamada a la bd
    include("../php/conn.php");
    
    //Genera el codigo que sera enviado
    function generarCodigo($l = 6) {
        $digitos = '0123456789';
        $codigo = '';
        for ($i = 0; $i < $l; $i++) {
            $codigo .= $digitos[rand(0, strlen($digitos) - 1)];
        }
        return $codigo;
    }

    //Inicializamos las variables para que puedan ser asignados los mensajes
    $titulo = "Mensaje";
    $mensaje = "Te llegara un correo electronico a la cuenta introducida con un codigo asociado.";
    $codigoGenerado;
 
    //Si se a activado el metodo Post
    if($_POST){

        //Recibe el valor del metodo post 
        $correoU = $_POST['email'];
        
        $sql = "SELECT * FROM Usuario WHERE Correo_electronico = '$correoU'";
        //Realiza la consulta a la bd
        $resultado = mysqli_query($conn, $sql);
            

        if(mysqli_num_rows($resultado) > 0){
            //Asigna los datos del administrador de la primera fila que se encuentre
            $fila = mysqli_fetch_assoc($resultado);

            $_SESSION['id_usuario'] = $fila['ID_usuario'];
            $codigoGenerado = generarCodigo();
            $_SESSION['codigo_generado'] = $codigoGenerado;


            //Contenido del correo
            $contenidoM = "
            <html>
                    
            <body style='background-color: #000000; color: #fff';>

                <div style='margin: 50px 0; text-align:center;'>
                    <h1 style='font-size: 3.3rem;'>Administracion de <a href='http://localhost/FormularioLM/' style='text-decoration: none; color: #fff';'>WEPELINGS</a></h1>
                    <h2 style='margin: 0px;font-size: 2rem;'>Recuperacion de Cuenta</h2>
                </div>
                    
                <div style='margin-top: 50px; text-align:center;'>
                    <h2 style='font-size: 3rem;'>Codigo</h2>
                    <h3 style='font-size: 2.5rem;padding-left: 20px; border-bottom: 2px solid red; letter-spacing: 20px;'>$codigoGenerado</h3>
                </div>
                    
                <footer style='text-align:center;'>
                    ©Agustin Prieto Atienza
                </footer>
                    
            </body>
            </html>";

            //crear el objeto de PHPMailer
            $mail = new PHPMailer(true);

            //Congigurar el mail
            //Indica que el contenido del correo sera en formato HTML
            $mail->isHTML(true);
            //Le indica que utilice el protocolo de SMTP
            $mail->isSMTP();
            //indicamos el SMTP
            $mail->Host = 'smtp.dondominio.com';
            //Indicar que SMTP es autorizado
            $mail->SMTPAuth = true;
            //Encriptacion del SMTP
            $mail->SMTPSecure = 'tls';
            //Indicar el correo y contraseña de la cuenta que enviara el correo
            $mail->Username = 'administracion@agussantos.es';
            $mail->Password = '25822582AgusA@';
            
            //El puerto por el que se conectara al smtp
            $mail->Port = 587;

            //Envio de Correo
            $mail->setFrom('administracion@agussantos.es', 'WEPELINGS Administracion');
            //Destinatario
            $mail->addAddress($correoU, 'Destinatario');

            // Contenido del correo
            $mail->Subject = 'Recuperacion de cuenta de usuario. CODIGO:' . $codigoGenerado;
            $mail->Body = $contenidoM;
                


            if ($mail->send()) {
                //Redirigir a la pagina de inicio de sesion
                header('Location: updateCU.php');
                //Asegurarse de que sale del documento
                exit();
            
            } else {
                //Destrulle la sesion inicializada
                session_destroy();

                $mensaje = "Hubo un error al enviar el correo electrónico. Por favor, Actualice la pagina e intentelo nuevamente o más tarde.";
            }
    
        }else{
            
            $titulo = "Error";
            $mensaje = "No se ha encontrado ninguna cuenta asociada a ese correo electronico.";
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
                <label for="email">
                    <input type="email" id="email" name="email" placeholder="Correo" required>
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