<?php
    //Iniciar las variables de sesion
    session_start();
    //Iniciar la conexion a la bd
    include("../php/conn.php");

    
    if($_POST){
    
        //Recibir el valor del metodo POST evitando Inyeccion en la consulta de la bd
        $codigo = $conn->real_escape_string($_POST['codigo']);

        $sql = "SELECT * FROM Administrador WHERE Codigo = '$codigo'";
        //Realiza la consulta a la bd
        $resultado = mysqli_query($conn, $sql);
        //Revisa cuantas filas se encuentra en el resultado
        if(mysqli_num_rows($resultado) > 0){

            //Asigna los datos del administrador de la primera fila que se encuentre
            $administradorD = mysqli_fetch_assoc($resultado);

            //Iniciar las variables de sesion con los valores
            $_SESSION["user"] = $administradorD['Nombre'];
            $_SESSION["id"] = $administradorD['ID_admin'];
            $_SESSION["logueado"] = true;
            
            //Redirigir a la pagina de inicio de sesion
            header("Location: ./hangarCA.php");
            //Asegurarse de que sale del documento
            exit();

        }else{

            //Redirigir a la pagina de inicio de sesion
            header("Location: ../index.php");
            //Asegurarse de que sale del documento
            exit();
        }
    }

    include("../templates/headerO.php");
    include("../templates/decoracionO.php");
?>


    <header>
        <h1><a href="../index.php">WEPELINGS</a></h1>
        <h2>Administracion</h2>
    </header>
    <main class="cuerpo">
        <form method="post">
            
            <label for="codigo">
                <input type="password" id="codigo" name="codigo" placeholder="Codigo" required>
            </label>
            <button type="submit">Enviar</button>
        </form>
    </main>

    <?php include("../templates/footer.html"); ?>
</body>
</html>