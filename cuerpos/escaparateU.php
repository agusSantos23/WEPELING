<?php 


    $direccion = "./hangarU.php";
    $nombreEnlace = "Hangar";
    include("../templates/headerI.php");

    
?>
    
    <?php include("../templates/decoracionI.php");?>

    <main id="Escaparate" data-id="<?php echo $_SESSION['id']; ?>">
        
    </main>
    <?php include("../templates/footer.html");?>
    
    <script src="../js/escaparate.js"></script>
</body>
</html>