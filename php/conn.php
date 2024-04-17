<?php

    function conectar() {

        $servername = "localhost";
        $database = "zepelin";
        $username = "root";
        $password = "";


        try{
            $conn = new mysqli($servername,$username,$password,$database);
            return $conn;
        }catch(Exception $e){
            echo $e->getMessage();
        }

    }
?>