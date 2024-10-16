<?php
require_once "../config/conexion.php";
session_start();

$expresion = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

if (isset($_SESSION['usuario'])) {
    header("location: ./index.php");
}

if ($_POST) {
    if (isset($_POST['nombre']) && !empty($_POST['nombre']) && 
        isset($_POST['apellido']) && !empty($_POST['apellido']) &&
        isset($_POST['email']) && !empty($_POST['email']) && preg_match($expresion, $_POST['email']) &&
        isset($_POST['password']) && !empty($_POST['password'])) {

        // Asignar valores a variables
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

        // Verificar que el nombre y apellido no contengan números
        if (is_numeric($nombre)) {
            echo json_encode([0,"No puedes agregar números en el input nombre"]);
            exit;
        } else if (is_numeric($apellido)) {
            echo json_encode([0,"No puedes agregar números en el input apellido"]);
            exit;
        }

        // Inserción en la base de datos
        $insercion = $conexion->prepare("INSERT INTO t_usuarios (nombre, apellido, email, password) 
                                          VALUES (:nombre, :apellido, :email, :password)");

        $insercion->bindParam(':nombre', $nombre);
        $insercion->bindParam(':apellido', $apellido);
        $insercion->bindParam(':email', $email);
        $insercion->bindParam(':password', $password);

        if ($insercion->execute()) {
            echo json_encode([1,"Usuario registrado correctamente"]);
        } else {
            echo json_encode([0,"Usuario NO registrado"]);
        }
    } else {
        echo json_encode([0,"Debes llenar todos los campos y asegurarte de que el email sea válido"]);
    }
}

?>