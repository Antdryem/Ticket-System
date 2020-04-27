
<font size="6">
<?php
include '../../conexionDB.php';

$conexion = new universo;

$resultado = $conexion->buscar_errores_soluciones($_GET['busqueda']);

while ($corrida = mysqli_fetch_array($resultado)) {
    echo "+<a href='soluciones.php?error=" . $corrida['id_error'] . "' target='resultados'>" . $corrida['nombre'] . "</a><br>";
}

$conexion->cerrar();
unset($conexion);
