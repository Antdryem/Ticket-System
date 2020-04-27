<?php
@session_start();

include 'conexionDB.php';

$conexion = new universo;



$conexion->ultima_conexion();
$conexion->cerrado_tickets_automatico();

$resultado = $conexion->mostrar_tickets();
?>
<left>
    <table border="0" >
        <tr>
            <td><img title="Pendientes" src="../imagenes/Pendientes.jpg"  height="53" width="53"></td>
            <td><img title="Atendidos del día" src="../imagenes/Atendidos_del_dia.jpg"  height="53" width="53"></td>
            <td><a target="izquierda" href="../funciones/tickets_reprogramados.php"><img title="Reprogramados" src="../imagenes/Reprogramados.jpg"  height="53" width="53"></a></td>
            <td><img title="Promedio global" src="../imagenes/Promedio_global.jpg"  height="53" width="53"></td>
            <td><img title="Tus atendidos del día" src="../imagenes/Tickets_atendiendo_actualmente.jpg"  height="53" width="53"></td>
            <td><img title="Promedio personal" src="../imagenes/promedio_personal.jpg"  height="53" width="53"></td>
        </tr>
        <tr>
            <td  background="../imagenes/ticket_rojo.png"><center><font size="12"><?php echo $conexion->pendientes_totales()[0]; ?></td>
            <td background="../imagenes/ticket_azul.png"><center><font size="12"><?php echo $conexion->atendidos_dia()[0]; ?></td>
                <td background="../imagenes/ticket_gris.png"><center><font size="12"><?php echo $conexion->cantidad_reprogramados()[0]; ?></td>
                    <td background="../imagenes/ticket_gris.png"><center><font size="5"><?php echo $conexion->promedio_global($conexion->formato_fecha(), $conexion->restar_7_dias($conexion->formato_fecha())); ?></td>
                        <td background="../imagenes/ticket_azul.png"><center><font size="12"><?php echo $conexion->tus_antendidos(); ?></td>
                            <td background="../imagenes/ticket_gris.png"><center><font size="5"><?php echo $conexion->promedio_usuario($_SESSION['id_usuario'], $conexion->restar_7_dias($conexion->formato_fecha()), $conexion->formato_fecha()); ?></td>
                                <td width="53"><center><a target="izquierda" href="../funciones/soluciones_errores/index.php"><font size="12"><?php echo $conexion->pendientes_confirmar(); ?></td>
                                        </tr>
                                        </table>
                                        <br><br>

                                        <table border="0">
                                            <tr>
                                                <td bgcolor="#4d4d4d"><font color="white">N°<br> ticket</td>
                                                <td bgcolor="#4d4d4d"></td>
                                                <td bgcolor="#4d4d4d"><font color="white">Nombre cliente</td>
                                                <td bgcolor="#4d4d4d"><font color="white">Asunto</td>
                                                <td bgcolor="#4d4d4d"><font color="white">Estado</td>
                                                <td bgcolor="#4d4d4d"><font color="white">Momento creación</td>
                                            </tr>
                                            <?php
                                            while ($corrida = mysqli_fetch_array($resultado)) {
                                                $nombre = mysqli_fetch_array($conexion->info_cliente($corrida[5]));

                                                if ($corrida[8] == "0000-00-00 00:00:00") {
                                                    $aux = "";
                                                } else {
                                                    $aux = "<br>Reprogramación: " . $corrida[8];
                                                }


                                                $antiguedad = $conexion->comparar_fechas($corrida[3]);
                                                if ($antiguedad <= 48) {
                                                    $color = "931B1E";
                                                }
                                                if ($antiguedad <= 24) {
                                                    $color = "ED2024";
                                                }
                                                if ($antiguedad <= 12) {
                                                    $color = "F89420";
                                                    $letra = "000000";
                                                } else {
                                                    $letra = "FFFFFF";
                                                }
                                                if ($antiguedad <= 4) {
                                                    $color = "FFE378";
                                                }
                                                if ($antiguedad <= 2) {
                                                    $color = "FFFFFF";
                                                }
                                                if ($antiguedad > 48) {
                                                    $color = "000000";
                                                }
                                                echo "<tr><td bgcolor='$color'>";

                                                $estado = $corrida[4];
                                                if ($corrida[4] == "abierto") {
                                                    $imagen = "../imagenes/ENTRAR.png";
                                                } else {
                                                    $imagen = "../imagenes/CERRAR.png";
                                                    $corrida[4] = "En proceso";
                                                }
                                                if ($corrida['extra'] !== "" && $corrida[4] == "abierto") {
                                                    $corrida[4] = $corrida['extra'];
                                                }
                                                echo "<font color='$letra'>" . $corrida[0] . "</td>"
                                                . "<td bgcolor='$color'><font color='$letra'>"
                                                . "<a href='../funciones/detalles_ticket.php?id=$corrida[0]&estado=$estado' target='izquierda'> "
                                                . "<img src='$imagen' alt='$corrida[4]' style='width:25px;height:25px;'>"
                                                . "</a>  "
                                                . "</td>"
                                                . "<td bgcolor='$color'><font color='$letra'>"
                                                . $nombre[1] . "</td>"
                                                . "<td bgcolor='$color'><font color='$letra'> " . $corrida[1] . $aux . "</td><td bgcolor='$color'><font color='$letra'>" .
                                                $corrida[4] . "</td><td bgcolor='$color'><font color='$letra'>"
                                                . $corrida[3] . "</font><br>";
                                                echo "</td></tr>";
                                            }

                                            $conexion->cerrar();

                                            unset($conexion);
                                            ?>
                                        </table>
                                        <table>


                                            <td bgcolor='FFFFFF'>
                                                <2 horas
                                            </td>
                                            <td bgcolor='FFE378'>
                                                <4 horas
                                            </td>
                                            <td bgcolor='F89420'>
                                                <12 horas
                                            </td>
                                            <td bgcolor='ED2024'>
                                                <font color='FFFFFF'><24 horas
                                            </td>
                                            <td bgcolor='931B1E'>
                                                <font color='FFFFFF'><48 horas
                                            </td>
                                            <td bgcolor='000000'>
                                                <font color='FFFFFF'>>48 horas
                                            </td>

                                        </table>
                                        </left>