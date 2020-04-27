<?php
include "../conexionDB.php";
@session_start();
$conexion = new universo;


if(!isset($_POST['error'])){
    echo "Elige el error al que pertenece la solución";
    exit;
}

echo $conexion->meter_solucion($_POST['nombre'], $_POST['comentario'], $_POST['error']);


$conexion->cerrar();
unset($conexion);