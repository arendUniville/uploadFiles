<?php

    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "upload";

    $mysqli = new mysqli($host,$user,$pass,$bd);

    if($mysqli->connect_errno){

        echo "COnnect failed: " . $mysqli->connect_error;
        exit();
    }else{

        echo "<p style='color: green;'>Connection success.</p>";

    }


?>