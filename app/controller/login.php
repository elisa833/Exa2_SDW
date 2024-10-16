<?php
require_once '../config/conexion.php';
session_start();
if ($_POST) {
    if (isset($_POST['nombre']) && !empty($_POST['nombre']) && 
        isset($_POST['apellido']) && !empty($_POST['apellido']) && 
        isset($_POST['pass']) && !empty($_POST['pass'])) {

        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $passw = $_POST['pass'];

        // Consulta a la base de datos buscando el nombre y apellido
        $consulta = $conexion->prepare("SELECT * FROM t_alumnos WHERE nombre = :nombre AND apellido = :apellido");
        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':apellido', $apellido);
        $consulta->execute();
        $datos = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($datos) {
            // Comprobar la contraseña
            if ($datos['pass'] == $passw) {
                $_SESSION['usuario'] = $datos;
                echo json_encode([1, "Datos de acceso correctos"]);
            } else {
                echo json_encode([0, "Error en credenciales de acceso"]);
            }
        } else {
            echo json_encode([0, "Información no localizada"]);
        }
    } else {
        echo json_encode([0, "Tienes que llenar los datos en el formulario"]);
    }
}

?>