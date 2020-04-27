<?php

include "../conexionDB.php";

$conexion = new universo;


$licencia = $conexion->propiedades_ticket($_GET['numero'])['licencia'];

switch($_GET['caso']){
    case 1:
        $titulo="Titulo del caso 1";
        $mensaje="Mensaje del caso 1";
        break;
    case 2:
        $titulo="Titulo del caso 2";
        $mensaje="Mensaje del caso 2";
        break;
    case 3:
        $titulo="Titulo del caso 3";
        $mensaje="Mensaje del caso 3";
        break;
}
if(mail($conexion->enviar_correo($licencia), $titulo, $mensaje)){
    echo "Enviado";
}else{
    echo "No enviado";
}



