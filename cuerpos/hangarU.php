<?php 
    $direccion = "./escaparateU.php";
    $nombreEnlace = "Escaparate";


    include("../templates/headerI.php") 
?>


    <?php include("../templates/decoracionI.php") ?>


    <main id="hangar" data-id="<?php echo $_SESSION['id'] ?>">

        
    </main>


    <?php include("../templates/footer.html") ?>
    <script src="../js/hangarU.js"></script>
</body>
</html>