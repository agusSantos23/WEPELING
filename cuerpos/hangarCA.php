<?php
    //Inicializamos las variables para que puedan ser asignados los mensajes
    $titulo = "";
    $mensaje = "";

    //No se le indica nada ya que en el header se encuentra la condicion para decidir cual de los dos enlaces sera
    $direccion = "";
    $nombreEnlace = "";

    //Conexion a la bd
    include("../php/conn.php");
    //Llamada al encabezado
    include("../templates/headerI.php");

    //Si se activa el metodo POST
    if($_POST){
        //Recibe los datos del metodo POST
        $model = $_POST['model'];
        $descripcion = $_POST['descripcion'];
        $autonomia = $_POST['autonomia'];
        $velocidad = $_POST['velocidad'];
        $compartimento = $_POST['compartimento'];

        //seleciona el nombre de la imagen
        $nameimagen=$_FILES['fileInput']['name'];
        //seleciona el archivo en si
        $tmpimagen=$_FILES['fileInput']['tmp_name'];
        //crea la ruta donde se va a almacenar el archivo
        $ruta = 'uploads/'.$nameimagen;

        //Recoge el valor de la variable de sesion
        $ID_administrador = $_SESSION['id'];

        //Comprueba el tamaño de la imagen para que no esceda de 500Kb 
        if($_FILES['fileInput']['size'] > 500000){

            $titulo = "Error";
            $mensaje = 'El archivo es demasiado grande';

        }else{
            //Carga el archivo a una zona de preparacion
            if(is_uploaded_file($tmpimagen)) {
                
                //Hace una copia del archivo recogiendo, el archivo en si y la ruta 
                if (copy($tmpimagen, $ruta)) {

                    $titulo = "";
                    $mensaje = 'Éxito al copiar el archivo.';
                
                } else {

                    $error = error_get_last();
                    echo 'Error al copiar el archivo: ' . $error['message'];
                }

                //Crea la consulta
                $sql = "INSERT INTO Dirigibles (Modelo,Descripcion,Autonomia,Velocidad,Compartimento,Imagen,ID_administrador) VALUES ('$model','$descripcion','$autonomia','$velocidad','$compartimento','$ruta','$ID_administrador')";

                //Realiza la consulta a la bd
                if(mysqli_query($conn,$sql)){
                    $titulo = "Exito";
                    $mensaje = "El modelo de dirigible se subio correctamente";

                }else{
                    $titulo = "Error";
                    $mensaje = "Se produjo un error al guardar el archivo en la base de datos";
                }

            }else{
                $titulo = "Error:";
                $mensaje = "Se produjo un error a la hora de cargar el archivo";

            }        
        }
    }
?>
    <div id="formularioC" style="display: none;">
        <main>
            <img id="Cerrar" src="../svg/plus.svg" alt="cerrar">
            <img id="engranaje" src="../svg/gear.svg" alt="Engranaje">
            <form method="post" enctype="multipart/form-data">

                <div id="inputs">
                    <label for="model">
                        <input type="text" id="model" name="model" placeholder="Modelo" required>
                    </label>

                    
                    <div id="Subir">
                        <input type="file" id="fileInput" name="fileInput" accept=".png">
                        <!--Cuando se clicke sobre el boton se activara seguidamente el input-->
                        <button onclick="document.getElementById('fileInput').click()">Seleccionar archivo</button>
                    </div>
                    

                    <textarea name="descripcion" id="descripcion" cols="40" rows="7" maxlength="360" placeholder="Este modelo se fabrico en ..." required></textarea>

                    <div id="Datos">
                        <label for="autonomia">
                            <input type="text" id="autonomia" name="autonomia" placeholder="Autonomia" required>
                        </label>
                        <label for="velocidad">
                            <input type="text" id="velocidad" name="velocidad" placeholder="Velocidad" required>
                        </label>
                        <label for="compartimento">
                            <input type="text" id="compartimento" name="compartimento" placeholder="Compartimento" required>
                        </label>
                    </div>
                </div>

                <button type="submit" id="submitBtn">Guardar</button>
            </form>

            <div id="Mensaje">
                <h3 id="tituloM"></h3>
                <p id="contenidoM"></p>
            </div>
        </main>
    </div>
    <?php include("../templates/decoracionI.php");?>

    <main id="hangar">
        <?php 
            //Crea la consulta
            $sql = "SELECT * FROM Dirigibles";
            //Realiza la consulta a la bd
            $resultado = mysqli_query($conn, $sql);
            //Por cada fila mostrara un elemento
            foreach($resultado as $row) {
        ?>

            <div class="cards" data-id="<?php echo $row['ID_dirigible']?>">
                <div>
                    <img src="<?php echo $row['Imagen'] ?>" alt="<?php echo $row['ID_dirigible']?>">
                    <h3><?php echo $row['Modelo'] ?></h3>
                </div>
                <button class="btnEliminar">Eliminar</button>
            </div>

        <?php }?>

        
        <div id="card">
            
            <img id="Crear" src="../svg/plus.svg" alt="crear">

        </div>
    </main>

    

    <?php include("../templates/footer.html"); ?>
    <!--Llamar al archivo javaScript-->
    <script src="../js/crdDirigible.js"></script>
</body>
</html>