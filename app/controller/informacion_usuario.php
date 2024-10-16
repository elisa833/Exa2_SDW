<?php
session_start();
require_once '../config/conexion.php';

if (isset($_SESSION['usuario'])) {
    // Utilizamos el id_alumno desde la sesión
    $consulta = $conexion->prepare("SELECT * FROM t_alumno WHERE id_alumno = :id_alumno");
    $consulta->bindParam(':id_alumno', $_SESSION['usuario']['id_alumno']);
    $consulta->execute();
    $datos = $consulta->fetch(PDO::FETCH_ASSOC);

    // Devolvemos los datos del alumno
    echo json_encode($datos);
} else {
    echo json_encode(['error' => 'No autenticado']);
}


?>