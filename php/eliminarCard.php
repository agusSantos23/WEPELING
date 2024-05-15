<?php
if(isset($_POST['id'])) {
    include('./conn.php');
    

    $id = $_POST['id'];

    // Consulta SQL para eliminar el registro
    $sql = "DELETE FROM Dirigibles WHERE ID_dirigible = '$id'";

    if(mysqli_query($conn, $sql)){
        
        echo "Registro eliminado exitosamente.";
    } else{
        // Si hubo algún error en la consulta SQL, devolver un mensaje de error
        echo "ERROR: No se pudo ejecutar la consulta. " . mysqli_error($conn);
    }

    mysqli_close($conn);
} 
