<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require "../PHPMailer/Exception.php";
    require "../PHPMailer/PHPMailer.php";
    require "../PHPMailer/SMTP.php";

    include("../php/conn.php");

    use PHPMailer\PHPMailer\PHPMailer;

    $titulo = "Mensaje";
    $mensaje = "Introduce tu correo electronico asociado a la cuenta. Te llegara un correo electronico a la cuenta introducida con un codigo asociado.";
    $codigoG = 0;
    $codigoB = false;
    function generarCodigo($l = 6) {
        $digitos = '0123456789';
        $codigo = '';
        for ($i = 0; $i < $l; $i++) {
            $codigo .= $digitos[rand(0, strlen($digitos) - 1)];
        }
        return $codigo;
    }


    if($_POST){

        
        $correo = isset($_POST['email'])? $conn->real_escape_string($_POST['email']) : '';
        $codigoU = isset($_POST['codigo']) ? $conn->real_escape_string($_POST['codigo']) : '';
        $contraU = isset($_POST['contra']) ? $conn->real_escape_string($_POST['contra']) : '';

        if(empty($codigoU)){

            $sql = "SELECT * FROM Usuario WHERE Correo_electronico = '$correo'";

            $resultado = mysqli_query($conn, $sql);
            

            if(mysqli_num_rows($resultado) > 0){

                $fila = mysqli_fetch_assoc($resultado);
                $idU = $fila['ID_usuario'];

                $codigo = trim(generarCodigo());
                $codigoG = $codigo;
                $codigoB = true;
                

                $contenidoM = "
                <html>
                    
                <body style='background-color: #000000; color: #fff';>

                    

                        <div style='margin: 50px 0; text-align:center;'>
                            <h1 style='font-size: 3.3rem;'>Administracion de <a href='http://localhost/FormularioLM/' style='text-decoration: none; color: #fff';'>WEPELINGS</a></h1>
                            <h2 style='margin: 0px;font-size: 2rem;'>Recuperacion de Cuenta</h2>
                        </div>
                    
                        <div style='margin-top: 50px; text-align:center;'>
                            <h2 style='font-size: 3rem;'>Codigo</h2>
                            <h3 style='font-size: 2.5rem;padding-left: 20px; border-bottom: 2px solid red; letter-spacing: 20px;'>$codigo</h3>
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
                $mail->addAddress($correo, 'Destinatario');

                $mail->Subject = 'Recuperacion de cuenta de usuario. CODIGO:' . $codigo;
                $mail->Body = $contenidoM;
                



                if ($mail->send()) {
                    $mensaje = "Se ha enviado un correo electrónico con el código de verificación a tu dirección de correo electrónico: \n" . $correo;
                } else {
                    $mensaje = "Hubo un error al enviar el correo electrónico. Por favor, intenta nuevamente más tarde.";
                }
    
            }else{

                $mensaje = "No se ha encontrado ninguna cuenta asociada a ese correo electronico";
            }

            $correo = "";

        }else if(empty($correo)){

            if($codigoG == $codigoU){

                $contraU_Hashed = password_hash($contraU, PASSWORD_DEFAULT);

                $sql = "UPDATE Usuario SET Password = '$contraU_Hashed' WHERE ID_usuario = $idU";

                $resultado = mysqli_query($con, $sql);

                if($resultado){
                    $mensaje = "Se ha actualizado correctamente";
                }else{
                    $mensaje = "Error al subir los archivos a bd";
                }

            }else{
                $titulo = "Error";
                $mensaje = "Los codigos no coinciden uno:" . $codigoU . "   dos:" . $codigoG;
            }

            
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

            <?php if (!$codigoB){ ?>

                <div class="inputs">
                    <label for="email">
                        <input type="email" id="email" name="email" placeholder="Correo" required>
                    </label>
                </div>

            <?php }else{ ?>

                <div class="inputs">
                    <label for="codigo">
                        <input type="text" id="codigo" name="codigo" placeholder="Codigo" required>
                    </label>

                    <label for="contra">
                        <input type="password" name="contra" id="contra" placeholder="Contraseña" require>
                    </label>
                </div>


            <?php } ?>
            
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