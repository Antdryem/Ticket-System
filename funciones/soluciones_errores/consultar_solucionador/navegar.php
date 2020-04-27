<?php

include '../../conexionDB.php';

$conexion = new universo;
?>
<table border="1">
    <tr>
        <td width="20%">
            <form action="errores.php" method="get" target="errores">
                <select name="categoria"> 
                    <?php

                    $resultado = $conexion->categorias_errores();
                    while ($corrida = mysqli_fetch_array($resultado)) {
                        echo "<option value='$corrida[0]'>$corrida[0]</option>";
                    }
                    ?>
                    <input value='Categoria' type="submit">
                </select>
            </form>
        </td>
        <td width="80%">
            <iframe src="" name="soluciones" width="100%" height="40" scrolling="auto"></iframe>
        </td>
    </tr>
    <tr>
        <td><iframe src="" name="errores" width="100%" height="100%"></iframe></td>
        <td><iframe src="" name="informacion" width="100%" height="100%"></iframe></td>
        <td><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
    </tr>
</table>


<?php

$conexion->cerrar();
unset($conexion);
