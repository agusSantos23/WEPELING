<?php
    $direccion = "";
    $nombreEnlace = "";


    include("../templates/headerI.php");
?>
    <div id="formularioC" style="display: flex;">
        <main>
            <img id="Cerrar" src="../svg/plus.svg" alt="cerrar">
            <img id="engranaje" src="../svg/gear.svg" alt="Engranaje">
            <form method="post">

                <div id="inputs">
                    <label for="model">
                        <input type="text" id="model" name="model" placeholder="Modelo" required>
                    </label>

                    
                    <div id="Subir">
                        <input type="file" id="fileInput" accept=".png">
                        <button onclick="document.getElementById('fileInput').click()">Seleccionar archivo</button>
                    </div>
                    

                    <textarea name="descripcion" id="descripcion" cols="50" rows="10" required></textarea>

                    <div>
                        <label for="Autonomia"><input type="number" required></label>
                        <label for="Velocidad"><input type="number" required></label>
                        <label for="Compartimento"><input type="number" required></label>
                    </div>
                </div>

                <button type="submit">Subir</button>
            </form>
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