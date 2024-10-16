<?php 
$user = "root1";
$pass = "1234";
$server = "localhost";
$nameDB = "escuela";

try {
    $conexion = new PDO("mysql:host=$server;dbname=$nameDB",$user,$pass);
} catch (PDOException $e) {
    die('Conexion fallida: '.$e);
}

?>