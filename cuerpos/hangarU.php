<?php 
    //Indicara valores contiene el enlace para ir al hangar o al escaparate
    $direccion = "./escaparateU.php";
    $nombreEnlace = "Escaparate";
 
    // Llamar al header y a la decoracion de la pagina
    include("../templates/headerI.php");
    include("../templates/decoracionI.php");
?>


    <main id="hangar" data-id="<?php echo $_SESSION['id'] ?>">
    </main>


    <?php include("../templates/footer.html") ?>
    <!--Llamar al archivo javaScript-->
    <script src="../js/hangarU.js"></script>
</body>
</html>