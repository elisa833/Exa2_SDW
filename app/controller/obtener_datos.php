<?php

require_once '../config/conexion.php';
$datos = '';

$consulta = $conexion->prepare("SELECT * FROM t_alumnos");
$consulta->execute();
$datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($datos);

?>