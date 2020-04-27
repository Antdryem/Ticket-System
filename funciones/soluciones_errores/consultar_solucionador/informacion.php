<?php
include '../../conexionDB.php';

$conexion = new universo;

$resultado=$conexion->propiedades_solucion($_GET['solucion']);

if($corrida= mysqli_fetch_array($resultado)){
    
    echo "Creado: ".$corrida['momento_creacion']."<br>";
    echo "Por: ".$conexion->nombre_usuario($corrida['id_usuario'])."<br><br>";
    echo "Información:<br>";
    echo $corrida['comentario'];
}

$conexion->cerrar();
unset($conexion);
