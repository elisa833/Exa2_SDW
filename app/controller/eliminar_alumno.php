<?php
require_once '../config/conexion.php';
session_start();

$id_alumno = $_POST['idInput'];

$eliminar = $conexion->prepare("DELETE FROM t_alumno WHERE id_alumno = :id_alumno");
$id = $id_alumno;
$eliminar->bindParam(':id_alumno',$id);
$eliminar->execute();

if ($eliminar) {
    echo json_encode([1,'Alumno eliminado correctamente']);
} else {
    echo json_encode([0,'Alumno NO eliminado correctamente']);
}

?>