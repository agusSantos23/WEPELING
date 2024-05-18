<?php 
    //LLamar a los archivos de PHPMailer
    require "../PHPMailer/Exception.php";
    require "../PHPMailer/PHPMailer.php";
    require "../PHPMailer/SMTP.php";

    //Importamos la clase de PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    
    //Inicializamos las variables para que puedan ser asignados los mensajes
    $titulo = "";
    $mensaje = "";

    //Si se a activado el metodo Post
    if($_POST){
        
        //Asignar los valores enviados
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $contenido = $_POST['contenido'];
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
        //Indicar el correo y contraseña de la cuenta que enviara el correo
        $mail->Username = 'administracion@agussantos.es'; 
        $mail->Password = '25822582AgusA@'; 
        //El puerto por el que se conectara al smtp
        $mail->Port = 587;

        //Envio de Correo
        $mail->setFrom("administracion@agussantos.es", $nombre); 
        //Destinatario
        $mail->addAddress('administracion@agussantos.es'); 

        // Contenido del correo
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body    = "Nombre: $nombre<br>Correo: $email<br>Mensaje: $contenido";
        $mail->AltBody = "Nombre: $nombre\nCorreo: $email\nMensaje:\n$contenido";

        //Enviar el correo y notificar al usurio
        $mail->send();
        $titulo = "Mensaje";
        $mensaje = 'El mensaje ha sido enviado';
    }
    // Llamar al encabezado y a la decoracion de la pagina
    include("../templates/headerO.php");
    include("../templates/decoracionO.php"); 
?>
<header>
    <h1><a href="../index.php">WEPELINGS</a></h1>
    <h2>Formulario de Contacto</h2>
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
        </div>
        <textarea id="contenido" name="contenido" cols="20" rows="7" maxlength="330" required></textarea>

        <button type="submit">Enviar</button>
    </form>

</main>
<!--Mostrar Mensajes al usuario-->
<aside class="mensaje">
        <h3><?php echo $titulo ?></h3>
        <p>
            <?php echo $mensaje ?>       
        </p> 
    </aside>


<?php include("../templates/footer.html");