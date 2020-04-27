
<font size="6">
<?php
include '../../conexionDB.php';

$conexion = new universo;

$resultado=$conexion->errrores_por_categoria($_GET['categoria']);

while($corrida= mysqli_fetch_array($resultado)){
    echo "+<a href='soluciones.php?error=".$corrida['id_error']."' target='soluciones'>".$corrida['nombre']."</a><br>";
}

$conexion->cerrar();
unset($conexion);
