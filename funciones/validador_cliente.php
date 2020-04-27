<?php

@session_start();
include 'conexionDB.php';
$conexion = new universo;
$conexion->privilegios("5");
if (isset($_POST['licencia']) && isset($_POST['nombre']) && isset($_POST['correo'])) {

    if (trim($_POST['nombre'], " ") !== "" && trim($_POST['correo'], " ") !== "") {
        if (filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
            $resultado = $conexion->crear_cliente($_POST['licencia'], $_POST['nombre'], $_POST['correo']);
            header("Location: ../paginas/crear_cliente.php?comentario=$resultado");
        } else {
            header("Location: ../paginas/crear_cliente.php?comentario=Sintaxis de correo no valida.");
        }
    } else {
        header("Location: ../paginas/crear_cliente.php?comentario=Todos los campos deben ser llenados.");
    }
}


$conexion->cerrar();
unset($conexion);
