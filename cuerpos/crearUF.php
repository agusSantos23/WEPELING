<?php 
    //Llamar a la base de datos
    include("../php/conn.php");
    
    //Se ejecuta cuando se active el metodo POST
    if($_POST){

        //Inicializamos las variables para que puedan ser asignados
        $titulo = "Mensaje";
        $mensaje = "";

        //Recibir los valores a traves del metodo Post
        //El real_escape_string evita una Inyeccion en la consulta de la bd
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $mail = $conn->real_escape_string($_POST['email']);
        $contra = $conn->real_escape_string($_POST['contra']);

        //Comprobar que la contraseña es mayor a 7 caracteres y que contiene almenos una letra Mayuscula y Minuscula
        if(strlen($contra) < 8 || !preg_match('/[A-Z]/', $contra) || !preg_match('/[a-z]/', $contra)) {

            $mensaje = "La contraseña debe tener al menos 8 caracteres y contener al menos una letra mayúscula y una minúscula.";
            
        } else {
            //Comprueba si en la base de datos ya hay algun usurio con el mismo nombre o correo
            $sql = "SELECT * FROM Usuario WHERE Nombre = '$nombre' OR Correo_electronico = '$mail'";
            $resultado = mysqli_query($conn, $sql);
        
            if(mysqli_num_rows($resultado) > 0) {

                $mensaje = "Ya hay usuarios con ese nombre o correo registrados";

            } else {
                //Se convierte la contraseña introducida por el usuario en una contraseña hasheada
                $contra_Hashed = password_hash($contra, PASSWORD_DEFAULT);
        
                $sql = "INSERT INTO Usuario (Nombre,Password,Correo_electronico) VALUES ('$nombre','$contra_Hashed','$mail')";
        
                //Se ejecuta la consulta en la base de datos
                if(mysqli_query($conn, $sql)){
                    //Redirigir a la pagina de inicio de sesion
                    header("Location: iniciarSUF.php");
                    //Asegurarse de que sale del documento
                    exit();

                } else {
                    echo "No Registrado " . $conn->error;
                }
            }
        }

        //Cerrar la bd
        $conn->close();

    }
    //Llamar a la cabecera y a la decoracion
    include("../templates/headerO.php");
    include("../templates/decoracionO.php");
?>

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
    
    <!--Mostrar Mensajes al usuario-->
    <aside class="mensaje">
        <h3><?php echo $titulo ?></h3>
        <p>
            <?php echo $mensaje ?>
        </p>
    </aside>

    <?php include("../templates/footer.html"); ?>

    <script>
        // Llama a las etiquetas en el documento y le asigna una variable
        const contra = document.getElementById("contra");
        const h3 = document.querySelector("h3");
        const p = document.querySelector("p");

        //La funcion se activara cada vez que se modifique el valor de la etiqueta input
        contra.addEventListener('input', () => {
            //Comprueba si el valor es menor de 8 caracteres y si contiene alguna letra Mayuscula y Minuscula
            if (contra.value.length < 8 || !/[A-Z]/.test(contra.value) || !/[a-z]/.test(contra.value)) {
                //Notifica al usuario
                h3.textContent = "Mensaje";
                p.textContent = "La contraseña debe tener al menos 8 caracteres y contener al menos una letra mayúscula y una minúscula.";
            } else {
                h3.textContent = "";
                p.textContent = "";
            }
        })
    </script>
</body>
</html>