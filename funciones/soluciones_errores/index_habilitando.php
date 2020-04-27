<?php
@session_start();
include '../conexionDB.php';
$conexion = new universo;

$conexion->aprobar_desaprobar();

$conexion->cerrar();
unset($conexion);