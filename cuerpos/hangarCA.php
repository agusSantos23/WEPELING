<?php

    $titulo = "";
    $mensaje = "";

    if($_POST){

        include("../php/conn.php");

        //datos
        $model = $_POST['model'];
        $descripcion = $_POST['descripcion'];
        $autonomia = $_POST['autonomia'];
        $velocidad = $_POST['velocidad'];
        $compartimento = $_POST['compartimento'];

        $nameimagen=$_FILES['fileInput']['name'];
        $tmpimagen=$_FILES['fileInput']['tmp_name'];
        $ruta = 'uploads/'.$nameimagen;

        if(is_uploaded_file($tmpimagen)) {

            // Crea el directorio si no existe
            if (!file_exists('uploads')) {
                if(mkdir('uploads', 0755, true)){
                    echo'creado';

                }else{
                    $error = error_get_last();
                    echo 'Error al copiar el archivo: ' . $error['message']. "              ";
                }
            }


            if (copy($tmpimagen, $ruta)) {
                echo 'Éxito al copiar el archivo.';
            } else {
                $error = error_get_last();
                echo 'Error al copiar el archivo: ' . $error['message'];
            }
            
            
            echo'Exito de archivo copiado';

            $sql = "INSERT INTO Dirigibles (Modelo,Descripcion,Autonomia,Velocidad,Compartimento,Imagen) VALUES ('$model','$descripcion','$autonomia','$velocidad','$compartimento','$ruta')";

            if($conn->query($sql)){
                echo "Exito";
            }else{
                echo "fracaso";
            }

        }else{

            echo "error de uploaded file";

        }

    }


    $direccion = "";
    $nombreEnlace = "";

    include("../templates/headerI.php");
?>
    <div id="formularioC" style="display: flex;">
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
                        <button onclick="document.getElementById('fileInput').click()">Seleccionar archivo</button>
                    </div>
                    

                    <textarea name="descripcion" id="descripcion" cols="40" rows="7" placeholder="Este modelo se fabrico en ..." required></textarea>

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

                <button type="submit">Guardar</button>
            </form>

            <div id="Mensaje">
                <h3><?php echo $titulo?></h3>
                <p><?php echo $mensaje?></p>
            </div>
        </main>
    </div>
    <?php include("../templates/decoracionI.php");?>

    <main id="hangar">
        
        <div id="card">
            
            <img id="Crear" src="../svg/plus.svg" alt="crear">

        </div>
    </main>

    

    <?php include("../templates/footer.html"); ?>
    <script src="../js/crearDirigible.js"></script>
</body>
</html>