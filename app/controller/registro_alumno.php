<?php
require_once '../config/conexion.php';
session_start();

if (isset($_POST['nombre_a']) && !empty($_POST['nombre_a']) && 
    isset($_POST['apellido_a']) && !empty($_POST['apellido_a']) && 
    isset($_POST['ingreso_a']) && !empty($_POST['ingreso_a']) &&
    isset($_POST['carrera_a']) && !empty($_POST['carrera_a']) &&
    isset($_POST['nacimiento_a']) && !empty($_POST['nacimiento_a'])) {

    $nombrealumno = $_POST['nombre_a'];
    $apellidoalumno = $_POST['apellido_a'];
    $ingresoalumno = $_POST['ingreso_a'];
    $carreralumno = $_POST['carrera_a'];
    $nacimientoalumno = $_POST['nacimiento_a'];

    if (is_numeric($ingresoalumno)) {
        $insercion = $conexion->prepare("INSERT INTO t_alumnos (nombre,apellido,ingreso, carrera, nacimiento) 
                                         VALUES(:nombre,:apellido,:ingreso,:carrera,:nacimiento)");
       $nombrealumno = $nombrealumno;
       $apellidoalumno = $apellidoalumno;
       $ingresoalumno = $ingresoalumno;
       $carreralumno = $carreralumno;
       $nacimientoalumno = $nacimientoalumno;

    
        $insercion->bindParam(':nombre',$nombrealumno);
        $insercion->bindParam(':apelido',$apellidoalumno);
        $insercion->bindParam(':ingreso',$ingresoalumno);
        $insercion->bindParam(':carrera',$carreralumno);
        $insercion->bindParam(':nacimiento',$nacimientoalumno);
    
        $insercion->execute();
        
        if ($insercion) {
            echo json_encode([1,"Alumno registrado"]);
        } else {
            echo json_encode([0,"Alumno NO registrado"]);
        }
    } 

} 

?>