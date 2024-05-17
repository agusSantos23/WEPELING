<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require "../PHPMailer/Exception.php";
    require "../PHPMailer/PHPMailer.php";
    require "../PHPMailer/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;

    $titulo = "";
    $mensaje = "";
    if($_POST){

        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $contenido = $_POST['contenido'];
        $mail = new PHPMailer(true);

        $mail->isHTML(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.dondominio.com'; // Cambia esto por tu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'administracion@agussantos.es'; // Cambia esto por tu correo
        $mail->Password = '25822582AgusA@'; // Cambia esto por tu contraseña
        $mail->Port = 587;

        // Destinatarios
        $mail->setFrom("administracion@agussantos.es", $nombre); // Cambia esto por tu correo y nombre
        $mail->addAddress('administracion@agussantos.es'); // Cambia esto por el correo donde quieres recibir los mensajes

        // Contenido del correo
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body    = "Nombre: $nombre<br>Correo: $email<br>Mensaje: $contenido";
        $mail->AltBody = "Nombre: $nombre\nCorreo: $email\nMensaje:\n$contenido";

        $mail->send();
        $titulo = "Mensaje";
        $mensaje = 'El mensaje ha sido enviado';
    }
    

?>

<?php include("../templates/headerO.php"); ?>
<?php include("../templates/decoracionO.php"); ?>


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

<aside class="mensaje">
        <h3><?php echo $titulo ?></h3>
        <p>
            <?php echo $mensaje ?>       
        </p> 
    </aside>


<?php include("../templates/footer.html");