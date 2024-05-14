<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include("../php/conn.php");


    





    $direccion = "./hangarU.php";
    $nombreEnlace = "Hangar";
    include("../templates/headerI.php") 
?>
    
    <?php include("../templates/decoracionI.php");?>

    <main id="Escaparate">
        <?php 
            $sql = "SELECT * FROM Dirigibles";
            $resultado = mysqli_query($conn, $sql);
        

            foreach($resultado as $row) {
        ?>
            <div id="<?php echo $row['ID_dirigible']?>" class="elementoCarrusel">
                <article>
                    <section>
                        <h2><?php echo $row['Modelo'] ?></h2>
                        <p><?php echo $row['Descripcion'] ?></p>
                    </section>
                    <ul>
                        <li>Autonomia: <?php echo $row['Autonomia'] ?></li>
                        <li>Velocidad: <?php echo $row['Velocidad'] ?></li>
                        <li>Compartimento: <?php echo $row['Compartimento'] ?></li>
                    </ul>
                </article>
                <aside id="carrusel" tabindex="0">
                    
                        <img src="../svg/arrow.svg" alt="flecha Arriba" class="normal svg" onclick="subir()">
                        <img src="<?php echo $row['Imagen']?>" alt="dirigible" class="dirigible">
                        <img src="../svg/arrow.svg" alt="flecha Abajo" class="invertido svg" onclick="bajar()">
                        <img src="../svg/corazon.svg" alt="me gusta" class="corazon">
                    
                </aside>
            </div>
        <?php } ?>
    </main>
    <?php include("../templates/footer.html");?>
    
    <script src="../js/carrusel.js"></script>
</body>
</html>