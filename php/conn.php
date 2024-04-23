<?php
    
    $servername = "localhost";
    $database = "zepelin";
    $username = "root";
    $password = "";


    try{

        $conn = new mysqli($servername,$username,$password,$database);

    }catch(Exception $e){

        echo $e->getMessage();
    }


    
?>