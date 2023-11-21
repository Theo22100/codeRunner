<?php 
$servername = "localhost";
$dbname = "coderunner";
$sqlusername = "root";
$sqlpassword = "root";

try {
    $handler = new PDO("mysql:host=$servername;dbname=$dbname", $sqlusername, $sqlpassword);
    $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    
   echo 'Echec Connexion : ' . $e->getMessage();
}
?>