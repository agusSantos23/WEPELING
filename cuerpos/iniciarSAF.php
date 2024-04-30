<?php
    session_start();
    include("../php/conn.php");

    if($_POST){
        
        $codigo = mysqli_real_escape_string($conn, $_POST['codigo']);

        $sql = "SELECT * FROM Administrador WHERE Codigo = '$codigo'";

        $resultado = mysqli_query($conn, $sql);

        if(mysqli_num_rows($resultado) > 0){

            $administradorD = mysqli_fetch_assoc($resultado);

            $_SESSION["user"] = $administradorD['Nombre'];
            $_SESSION["logueado"] = true;
            header("Location: ./hangarCA.php");
            exit();

        }else{
            
            header("Location: ../index.html");
            exit();
        }

    }

?>

<?php include("../templates/headerO.php"); ?>
    <?php include("../templates/decoracionO.php"); ?>


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