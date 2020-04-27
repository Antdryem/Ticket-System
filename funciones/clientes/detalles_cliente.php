<?php
@session_start();
include '../conexionDB.php';
$conexion = new universo;

if (!isset($_GET['licencia'])) {
    exit;
} else {
    $resultado = $conexion->propiedades_cliente($_GET['licencia']);

    echo "<font size=5><a href='reconfigurar_cliente.php?accion=propiedades&licencia=" . $_GET['licencia'] . "' target='cambiar'>IMAGEN</a>|____|" . $resultado[0] . "|___|" . $resultado[1] . "|___|" . $resultado[2] . "|</font><br>" . $resultado[4] . "<br><br><br>";

    $resultado = $conexion->imprimir_telefonos($_GET['licencia']);

    echo "<table><tr><td><table border=1><tr><th>Contacto</th><th>Telefono</th></tr>";

    while ($corrida = mysqli_fetch_array($resultado)) {
        echo "<tr><th><a href='reconfigurar_cliente.php?accion=telefono&id_telefono=$corrida[0]&nombre=$corrida[2]&telefono=$corrida[3]&licencia=" . $_GET['licencia'] . "' target='cambiar'>" . $corrida[2] . "</a></th><th>" . $corrida[3] . "</th></tr>";
    }
    ?>
    </table></td><td>
        <iframe style="border:none;" src="reconfigurar_cliente.php" height="100%" width="150%" name="cambiar"></iframe> 
    </td></tr></table>

    <?php
}


?>
<a href="../../paginas/meter_comentario.php?licencia=<?php echo $_GET['licencia']; ?>" target="izquierda">
    Imagensota
</a>
<br>

<?php
$resultado = $conexion->ver_comentarios_cliente($_GET['licencia']);
?>
<table border="1">
<?php
while ($corrida = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo "<td>".$conexion->nombre_usuario($corrida[0])."</td><td>$corrida[1]</td>";
    echo "</tr>";
}
?>
</table>
<iframe style="border:none;" src="../lista_tickets.php?paginacion=1&busqueda=<?php echo $_GET['licencia']; ?>&tipo_busqueda=1" height="100%" width="100%" name="historial"></iframe> 


<?php

$conexion->cerrar();
unset($conexion);