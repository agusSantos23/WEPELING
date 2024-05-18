<?php 
    //Indicara valores contiene el enlace para ir al hangar o al escaparate
    $direccion = "./hangarU.php";
    $nombreEnlace = "Hangar";

    // Llamar al header y a la decoracion de la pagina
    include("../templates/headerI.php");
    include("../templates/decoracionI.php");
?>
    
    <main id="Escaparate" data-id="<?php echo $_SESSION['id']; ?>">
    </main>

    <?php include("../templates/footer.html");?>
    <!--Llamar al archivo javaScript-->
    <script src="../js/escaparate.js"></script>
</body>
</html>