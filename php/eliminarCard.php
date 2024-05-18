<?php
    //LLamada a la base de datos
    include('./conn.php');

    //Comprobar que ha llegado el valor enviado
    if(isset($_POST['id'])) {
        
        //Guardar valor en una variable
        $id = $_POST['id'];

        // Consulta SQL para eliminar el registro
        $sql = "DELETE FROM Dirigibles WHERE ID_dirigible = '$id'";

        //Ejecutar consulta
        if(mysqli_query($conn, $sql)){
            
            echo "Registro eliminado exitosamente.";
        } else{
            
            // Si hubo algún error en la consulta SQL, devolver un mensaje de error
            echo "ERROR: No se pudo ejecutar la consulta. " . mysqli_error($conn);
        }

    } 
    
    //Cerrar la conexion
    $conn->close();
