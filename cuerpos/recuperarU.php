<?php
    session_start();

    require "../PHPMailer/Exception.php";
    require "../PHPMailer/PHPMailer.php";
    require "../PHPMailer/SMTP.php";

    include("../php/conn.php");

    use PHPMailer\PHPMailer\PHPMailer;

    function generarCodigo($l = 6) {
        $digitos = '0123456789';
        $codigo = '';
        for ($i = 0; $i < $l; $i++) {
            $codigo .= $digitos[rand(0, strlen($digitos) - 1)];
        }
        return $codigo;
    }


    $titulo = "Mensaje";
    $mensaje = "Introduce el correo electronico asociado a la cuenta. Te llegara un correo electronico a la cuenta introducida con un codigo asociado.";
    $codigoGenerado;
 

    if($_POST){

        $correoU = $conn->real_escape_string($_POST['email']);
        

        $sql = "SELECT * FROM Usuario WHERE Correo_electronico = '$correoU'";

        $resultado = mysqli_query($conn, $sql);
            

        if(mysqli_num_rows($resultado) > 0){

            $fila = mysqli_fetch_assoc($resultado);
            $_SESSION['id_usuario'] = $fila['ID_usuario'];
            $codigoGenerado = generarCodigo();
            $_SESSION['codigo_generado'] = $codigoGenerado;



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


            $mail = new PHPMailer(true);

            $mail->isHTML(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.dondominio.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'administracion@agussantos.es';
            $mail->Password = '25822582AgusA@';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;


            $mail->setFrom('administracion@agussantos.es', 'WEPELINGS Administracion');
            $mail->addAddress($correoU, 'Destinatario');
            $mail->Subject = 'Recuperacion de cuenta de usuario. CODIGO:' . $codigoGenerado;
            $mail->Body = $contenidoM;
                



            if ($mail->send()) {

                header('Location: updateCU.php');
                exit();
            
            } else {
                session_destroy();
                $mensaje = "Hubo un error al enviar el correo electrónico. Por favor, Actualice la pagina e intentelo nuevamente o más tarde.";
            }
    
        }else{
            $titulo = "Error";
            $mensaje = "No se ha encontrado ninguna cuenta asociada a ese correo electronico.";
        }

      
        
    }

    
    

?>

<?php include("../templates/headerO.php"); ?>
    <?php include("../templates/decoracionO.php"); ?>

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