<?php

@session_start();
include '../conexionDB.php';
$conexion = new universo;
$conexion->privilegios("5");

//echo $_GET['licencia']."<br>".$_POST['nombre']."<br>".$_POST['telefono']."<br>".$_GET['id_telefono'];
if (isset($_GET['id_telefono'])) {
    $conexion->cambiar_telefono($_GET['id_telefono'], $_POST['nombre'], $_POST['telefono'], $_GET['licencia']);
} else {
    if ($_POST['nombre'] == "" || $_POST['correo']=="") {
        echo "Sin espacios vacíos ¬_¬";
    } else {
        if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
            echo "Sintaxis de correo no valida.";
        } else {
            $conexion->cambiar_propiedades_cliente($_GET['licencia'], $_POST['nombre'], $_POST['correo']);
        }
    }
}
$conexion->cerrar();
unset($conexion);
