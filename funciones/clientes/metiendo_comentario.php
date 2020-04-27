<?php

@session_start();
include '../conexionDB.php';
$conexion = new universo;
$conexion->privilegios("6");

if($_GET['comentario']==""){
    echo "No deje el comentario vacío.";
    exit;
}

//echo "pene :D";
if ($conexion->meter_comentario_cliente($_GET['licencia'], $_GET['comentario'])) {
    echo "Guardado";
    header("Location: detalles_cliente.php?licencia=".$_GET['licencia']);
} else {
    echo "No se ha podido guardar el comentario, intente de nuevo.";
}

$conexion->cerrar();
unset($conexion);
