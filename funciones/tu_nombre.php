<?php

include 'conexionDB.php';

$conexion= new universo;
@session_start();
//error_reporting(0);

/*$frase=[ 
    "Buenos dias, ",
    "",
    "",
    "Tú puedes, ",
    "Buen día, ", 
    "", 
    "", 
    "", 
    "Hola, ", 
    "", 
    ""];*/
?>
<a href="../index.php" target="_top">
<?php
echo $conexion->usuario();
$conexion->cerrar();

unset($conexion);