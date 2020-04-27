<?php

include '../../conexionDB.php';

$conexion = new universo;
?>
<table border="1">
    <tr>
        <td width="20%">
            <form action="busqueda.php" method="get" target="errores">
                <input type="text" name="busqueda">
                    <input value='Buscar' type="submit">
            </form>
        </td>
        <td width="80%">
            <iframe src="" name="resultados" width="100%" height="40" scrolling="auto"></iframe>
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
