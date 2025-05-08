<?php
    $db_server = "localhost";
    $db_username = "root";  
    $db_password = "";
    $db_name = "smart_gym";
    $conn = "";

    try{
    $conn = mysqli_connect("localhost", "root", "", "smart_gym");
    }
    
    catch(Exception $e){
        echo "Connection failed: " . $e->getMessage();
    }
    
    if ($conn) {
        echo "Connected successfully";
    }
?>