<?php
include '../conexionDB.php';
@session_start();
$conexion=new universo;

if ($_POST['categoria'] == "xyz") {
    echo $conexion->registrar_error($_POST['error'], $_POST['nuevo']);
} else {
    echo $conexion->registrar_error($_POST['error'],$_POST['categoria']);
}

$conexion->cerrar();

unset($conexion);