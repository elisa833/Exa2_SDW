<?php
session_start();
require_once '../config/conexion.php';

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$ingreso = $_POST['ingreso'];
$carrera= $_POST['carrera'];
$nacimiento= $_POST['nacimiento'];


$actualizacion = $conexion->prepare("UPDATE t_alumno 
        SET nombre = :nombre, apellido = :apellido, ingreso = :ingreso,
        carrera = :carrera, nacimiento = :nacimeinto

        WHERE id_alumno = :id_alumno");

$actualizacion->bindParam(':nombre',$nombre);
$actualizacion->bindParam(':apellido',$apellido);
$actualizacion->bindParam(':ingreso',$ingreso);
$actualizacion->bindParam(':carrera',$carrera);
$actualizacion->bindParam(':nacimiento',$nacimiento);
$actualizacion->bindParam(':id_alumno',$_SESSION['usuario']['id_alumno']);

$actualizacion->execute();

if ($actualizacion) {
    $consulta = $conexion->prepare("SELECT * FROM t_alumno WHERE id_alumno = :id_alumno");
    $consulta->bindParam(':id_alumno',$_SESSION['usuario']['id_alumno']);
    $consulta->execute();
    $datos = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($datos) {
        $_SESSION['usuario'] = $datos;
        echo json_encode([1,"Informacion actualizada correctamente"]);
    } else {
        echo json_encode([0,"Error al actualizar datos"]);
    }
} else {
    echo json_encode([0,"Error al actualizar datos"]);
}

?>