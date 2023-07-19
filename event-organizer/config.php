<?php 
    $database_host = 'localhost';
    $database_name = 'swe';
    $database_user = 'root';
    $database_password = '';
    try{
        $pdo = new PDO("mysql:host={$database_host};dbname={$database_name}",$database_user,$database_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $exception){
        echo "Connection error: ".$exception->getMessage();
    }

?>