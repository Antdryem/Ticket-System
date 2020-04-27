<?php


if ($_POST['licencia']!="" && $_POST['nombre']!="" && $_POST['telefono']!="")
{
@session_start();

include 'conexionDB.php';

$conexion = new universo;

$resultado = $conexion->meter_telefono($_POST['licencia'], $_POST['nombre'], $_POST['telefono']);

header("Location: ../paginas/crear_cliente.php?comentario=$resultado");

$conexion->cerrar();

unset($conexion);
}
else
{
    header("Location: ../paginas/crear_cliente.php?comentario=Todos los campos deben ser llenados.");
}