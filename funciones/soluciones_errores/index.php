<?php
@session_start();

include '../conexionDB.php';

$conexion = new universo;
$conexion->privilegios("8");
$tipo = 0;

$datos = ($conexion->consulta_por_aprobar());
?>
<form method="get" action="index_habilitando.php">
    <table border="1">
        <?php
        echo "<tr><td>Soluciones por aprobar</td><td>Información</td><td>Creado por</td></tr>";
        foreach ($datos as $dato) {
            echo "<tr>";
            if ($dato == "pene") {
                $tipo++;
                echo "<tr><td>Errores por aprobar</td><td>Categoria</td><td>Creado por</td></tr>";
            } else {
                if ($tipo == 0) {
                    //var_dump($dato);
                    echo "<td>"
                    . "<input type='checkbox' name='solucion" . $dato['id_solucion'] . "' value='" . $dato['id_solucion'] . "'>" . $dato['nombre'] . ""
                    . "</td>";
                    echo "<td>"
                    . $dato['comentario']
                    . "</td>";
                    echo "<td>" . $conexion->nombre_usuario($dato['id_usuario']) . "</td>";
                } else {
                    //var_dump($dato);
                    echo "<td>"
                    . "<input type='checkbox' name='error" . $dato['id_error'] . "' value='" . $dato['id_error'] . "'>" . $dato['nombre'] . ""
                    . "</td>";
                    echo "<td>";
                    //. $dato['categoria'];
                    ?>
                    <select name="categoria<?php echo $dato['id_error'] ?>">
                        <option value="<?php echo $dato['categoria']; ?>"><?php echo $dato['categoria']; ?></option>
                        <?php
                        $resultado = $conexion->categorias_errores();
                        while ($corrida = mysqli_fetch_array($resultado)) {
                            echo "<option value='$corrida[0]'> $corrida[0] </option>";
                        }
                        ?>
                    </select>
                    <?php
                    echo "<td>" . $conexion->nombre_usuario($dato['id_usuario']) . "</td>";
                }
            }

            echo "</tr>";
        }
        ?>
    </table>
    <br>

    <input name="accion" type="submit" value="Aprobar"><br><br><br><br><br><br>
    <input name="accion" type="submit" value="No aprobar">
</form>
<?php
$conexion->cerrar();

unset($conexion);
