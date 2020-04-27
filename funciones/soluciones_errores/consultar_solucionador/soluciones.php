<font size="5">

<?php
include '../../conexionDB.php';

$conexion = new universo;

$resultado = $conexion->soluciones_por_error($_GET['error']);

$numero = 0;

while ($corrida = mysqli_fetch_array($resultado)) {
    if ($numero != 0) {
        echo "|/_\|";
    }

    $numero++;
    echo "Solución $numero: <a href='informacion.php?solucion=".$corrida['id_solucion']."' target='informacion'>" . $corrida['nombre']."</a>";
}


$conexion->cerrar();
unset($conexion);
