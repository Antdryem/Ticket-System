

<form action="../../funciones/reportes/reporte_rango.php" method="post" target="abajo">


    <table border="1">
        <tr><td><center>Reportes</center></td></tr>
        <tr>
            <td><input name="accion" type="radio" value="1"> Tiempos, por usuario, entre cada ticket</td>
            <td>Día: <input name="fecha" type="date" ></td>
            <td rowspan="2">
                Usuario 
                <select name="usuario">
                    <?php
                    include'../../funciones/conexionDB.php';
                    $conexion = new universo;
                    
                    $usuarios = $conexion->todos_los_usuarios();

                    while ($corrida_usuario = mysqli_fetch_array($usuarios)) {
                        echo "<option value='" . $corrida_usuario['nombre'] . "'>" . $corrida_usuario['nombre'] . "</option> ";
                    }

                    $conexion->cerrar();
                    unset($conexion);
                    ?>
                </select>
            </td></tr>
        <tr>
            <td><input name="accion" type="radio" value="2"> Actividad en los tickets.</td>
            <td rowspan="5">Despues de:<br> 
                <input name="fecha2" type="date" >
                <br>
                Antes de:<br>
                <input name="fecha1" type="date" >
            </td>
        </tr>
        <tr>
            <td><input name="accion" type="radio" value="3"> Promedio global de inactividad entre cada ticket</td>
        </tr>
        <tr>
            <td><input name="accion" type="radio" value="4"> Promedio de todos los usuarios.</td>
        </tr>
        <tr>
            <td><input name="accion" type="radio" value="5"> Eficiencia de los usuarios.</td>
        </tr>
        <tr>
            <td><input name="accion" type="radio" value="6"> Promedio global.</td>
        </tr>
    </table>
    <input type="submit" value="Consultar reportes" onclick="alert('Procesando, esto puede tardar unos minutos');">
</form> 

<iframe style="border:none;" src="" width="100%" height="70%" name="abajo"></iframe>