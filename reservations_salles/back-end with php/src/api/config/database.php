<?php

function getPdo(): PDO{
  $servername = 'localhost';
  $dbname = 'reservations_salles';
  $username = 'root';
  $password = 'root';
    //On établit la connexion
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    catch(PDOException $e){
        echo 'Erreur de connexion à la BDD: ' . $e->getMessage();
    }
}
 
?>