<?php
@session_start();
include '../conexionDB.php';
set_time_limit(0);
$conexion = new universo;

$conexion->privilegios("4");
$datos = array();

/*
 * 1.-Mostrar tiempos, de un usuario, entre cada ticket
 * 2.-(1)Mostrar actividad de tickets de usuario entre las fechas seleccionadas
 * 3.-Promedio de inactividad entre cada ticket
 * 4.-(2)Promedio de usuario entre las fechas seleccionadas
 * 5.-(3)Porcentaje de los tickets resueltos entre las fechas seleccionadas
 * 6.-(4)Promedio global de la empresa en resolver tickets entre las fechas seleccionadas
 */

function fechas($conexion) {

    if ($_POST['fecha1'] == "" || $_POST['fecha2'] == "") {
        echo "No deje la fecha vacía.";
        exit;
    }

    $_POST['fecha1'] .= " 23:59:59"; //Antes de
    $_POST['fecha2'] .= " 00:00:00"; //Despues de

    if ((0 < (int) $conexion->restar_fechas($_POST['fecha1'], $_POST['fecha2']))) {
        echo "No se quiera pasar de listo";
        exit;
    }
}

if (!isset($_POST['accion'])) {
    echo "Por favor, seleccione un reporte";
    exit;
}

switch ($_POST['accion']) {
    case "1":
        echo "Tiempos de trabajo de " . $_POST['usuario'] . "<br>";
        if ($_POST['fecha'] == "") {
            echo "Introduzca una fecha";
            exit;
        }
        array_push($datos, "Horas", "Gráfica, tiempo descanzo entre cada ticket.", "Horas");
        $aux = array();
        $resultado = $conexion->tiempo_libre_usuario($conexion->id_usuario($_POST['usuario']), $_POST['fecha']);
        echo "<table>";
        for ($pene = 0; $pene < count($resultado); $pene++) {
            ?>
            <tr>
                <td>
                    <?php
                    if ($pene + 1 < count($resultado)) {
                        $descanzo = number_format($conexion->restar_fechas($resultado[$pene][2], $resultado[$pene + 1][1]), 2);

                        if ($descanzo < 0) {
                            $descanzo = 0;
                        }

                        array_push($aux, $resultado[$pene][0], $descanzo);

                        $descanzo .= " horas";

                        if ($descanzo < 0) {
                            $descanzo = 0;
                        }
                    } else {
                        $descanzo = " fue ultimo del día a las " . preg_split("/ /", $resultado[$pene][2])[1];
                    }


                    echo $resultado[$pene][0] . " descanzo " . $descanzo;
                    ?>
                </td>
            </tr>
            <?php
        }
        echo "</table>";
        array_push($datos, $aux);
        include 'grafico.php';

        break;
    case "2":
        fechas($conexion);

        echo "Historial de " . $_POST['usuario'] . "<br>";
        $resultado = $conexion->historial_tickets_por_usuario($conexion->id_usuario($_POST['usuario']), $_POST['fecha2'], $_POST['fecha1']);
        ?>

        <table border="1">
            <tr>
                <td>Licencia</td><td>Asunto</td><td>Actividad</td><td>¿Lo soluciono?</td><td>Momento solución</td>
            </tr>
            <?php
            while ($corrida = mysqli_fetch_array($resultado)) {
                ?>
                <tr>
                    <?php
                    $datos_ticket = $conexion->propiedades_ticket($corrida['id_ticket']);
                    //te quedaste en imprimir la tabla, una vez teniendo los valores

                    echo "<td><a href='../clientes/detalles_cliente.php?licencia=" . $datos_ticket['licencia'] . "' target='izquierda'>" . $datos_ticket['licencia'] . "</td>";
                    echo "<td>" . "<a href='../detalles_ticket.php?id=" . $corrida['id_ticket'] . "&estado=" . $datos_ticket['estado'] . "' target='izquierda'> " . $datos_ticket['asunto'] . "</td>";
                    echo "<td>" . $corrida['comentario'] . "</td>";
                    if ($datos_ticket['momento_solucion'] === $corrida['momento_cierre']) {
                        echo "<td>Si</td>";
                    } else
                        echo "<td>NO</td>";
                    echo "<td>" . $datos_ticket['momento_solucion'] . "</td>";
                    //} else {
                    //    echo "<td>No</td>";
                    //}
                    ?>
                </tr>>
                <?php
            }
            ?>

        </table>

        <?php
        break;
    case "3":
        fechas($conexion);
        array_push($datos, "Horas", "Gráfica, promedio de horas entre ticket por usuario", " Horas promedio", $conexion->tiempo_libre_todos_usuarios($_POST['fecha2'], $_POST['fecha1']));
        include 'grafico.php';
        break;
    case "4":
        fechas($conexion);
        echo "Promedio de todos los usuarios.<br>";
        array_push($datos, "Minutos", "Gráfica, promedio de tiempo por usuario.", " Min. promedio"
                , $conexion->promedios_globales_usuarios($_POST['fecha2'], $_POST['fecha1']));

        include 'grafico.php';
        break;

    case "5":
        fechas($conexion);
        echo "Porcentaje de eficiencia<br>";
//                 unidades,       título,                                            texto del dato,                  nombre y datos
        array_push($datos, "Porcentaje %", "Gráfica, porcentaje de eficiencia de los usuarios.", "%"
                , $conexion->eficiencia_usuarios($_POST['fecha1'], $_POST['fecha2']));

        include 'grafico.php';
        break;
    case "6":
        fechas($conexion);
        echo "Promedio de la empresa.<br>";
        echo $conexion->promedio_global($_POST['fecha1'], $_POST['fecha2']);
        break;
}
$conexion->cerrar();
unset($conexion);
?>

<script>
    alert('Carga finalizada');
</script>