<?php

include 'conexionDB.php';

$conexion = new universo;



$resultado = $conexion->tickets_reprogramados();
echo "<table border=1>";
echo "<tr>"
 . "<td>Número</td>"
 . "<td>Licencia</td>"
 . "<td>Asunto</td>"
 . "<td>Reprogramación</td>"
 . "</tr>";
while ($corrida = mysqli_fetch_array($resultado)) {
    echo "<tr>";

    echo "<td>".$corrida['id_ticket']."</td>";
    echo "<td>".$corrida['licencia']."</td>";
    echo "<td>".$corrida['asunto']."</td>";
    echo "<td>".$corrida['reprogramacion']."</td>";


    echo "</tr>";
}

echo "</table>";
$conexion->cerrar();
unset($conexion);
