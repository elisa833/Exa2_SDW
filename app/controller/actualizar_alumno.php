<?php 
require_once '../config/conexion.php';
session_start();

if ($_POST) {
    $id_alumno = $_POST['idInput'];
    $nombrealumno = $_POST['nombre_a'];
    $apellidoalumno = $_POST['apellido_a'];
    $ingresoalumno = $_POST['ingreso_a'];
    $carreralumno = $_POST['carrera_a'];
    $nacimientoalumno = $_POST['nacimiento_a'];
    
    // Validar que todos los campos estén llenos
    if (empty($nombrealumno) || empty($apellidoalumno) || empty($ingresoalumno) || empty($carreralumno) || empty($nacimientoalumno)) {
        echo json_encode([0, "Datos incompletos"]);
        exit;
    }
    
    // Validar que ingreso sea un número
    if (!is_numeric($ingresoalumno)) {
        echo json_encode([0, "El ingreso debe ser un número"]);
        exit;
    }
    
    // Validar formato de nacimiento (dd/MM/AAAA)
    $fechaNacimiento = DateTime::createFromFormat('d/m/Y', $nacimientoalumno);
    if (!$fechaNacimiento || $fechaNacimiento->format('d/m/Y') !== $nacimientoalumno) {
        echo json_encode([0, "Formato de fecha de nacimiento incorrecto. Debe ser DD/MM/AAAA"]);
        exit;
    }
    
    // Actualización en la base de datos
    $actualizacion = $conexion->prepare("UPDATE t_alumnos 
        SET nombre = :nombre, apellido = :apellido, ingreso = :ingreso, carrera = :carrera, nacimiento = :nacimiento  
        WHERE id_alumno = :id_alumno");

    $actualizacion->bindParam(':id_alumno', $id_alumno);
    $actualizacion->bindParam(':nombre', $nombrealumno);
    $actualizacion->bindParam(':apellido', $apellidoalumno);
    $actualizacion->bindParam(':ingreso', $ingresoalumno);
    $actualizacion->bindParam(':carrera', $carreralumno);
    $actualizacion->bindParam(':nacimiento', $nacimientoalumno);

    if ($actualizacion->execute()) {
        echo json_encode([1, "Alumno actualizado correctamente"]);
    } else {
        echo json_encode([0, "Alumno NO actualizado correctamente"]);
    }
}


/*

if (!empty($_POST['nombre_a']) && !empty($_POST['apellido_a']) && !empty($_POST['ingreso_a'] && !empty($_POST['carrera_a'])) && !empty($_POST['nacimiento_a'])) {

    $id_alumno = $_POST['idInput'];
    $nombrealumno = $_POST['nombre_a'];
    $apellidoalumno = $_POST['apellido_a'];
    $ingresoalumno = $_POST['ingreso_a'];
    $carreralumno = $_POST['carrera_a'];
    $nacimientoalumno = $_POST['nacimiento_a'];

    if (is_numeric($precioProducto) && is_numeric($cantidadProducto)) {
        $actualizacion = $conexion->prepare("UPDATE t_alumnos 
        SET nombre = :nombre, apellido = :apellido, ingreso = :ingreso, carrera = :carrera, nacimiento = :nacimeinto  
        WHERE id_alumno = :id_alumno");
    
        $nombrealumno = $nombrealumno;
        $apellidoalumno = $apellidoalumno;
        $ingresoalumno = $ingresoalumno;
        $carreralumno = $carreralumno;
        $nacimientoalumno = $nacimientoalumno;
        $id_alumno = $id_alumno;
        
        $actualizacion->bindParam(':id_alumno',$id_alumno);
        $actualizacion->bindParam(':nombrealumno',$nombrealumno);
        $actualizacion->bindParam(':apellidoalumno',$apellidoalumno);
        $actualizacion->bindParam(':ingresoalumno',$ingresoalumno);
        $actualizacion->bindParam(':carreralumno',$carreralumno);
        $actualizacion->bindParam(':nacimientoalumno',$nacimientoalumno);
    
        $actualizacion->execute();
    
        if ($actualizacion) {
            echo json_encode([1,"Alumno actualizado correctamente"]);
        } else {
            echo json_encode([0,"Alumno NO actualizado correctamente"]);
        }
    } else {
        echo json_encode([0,"formato de fecha de nacimento DD/MM/AAAA e ingreso con numero"]);
    }

    
} else {
    echo json_encode([0,"Datos incompletos"]);
}

?>

*/

?>

