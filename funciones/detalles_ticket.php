<?php
@session_start();

include 'conexionDB.php';

$conexion = new universo;

if (!isset($_POST['accion'])) {
    $_POST['accion'] = "0";
}

switch ($_GET['estado']) {
    case "abierto":
        $conexion->privilegios("2"); /*         * ****************************************************** */
        if (isset($_GET['abrir'])) {

            $aux = $conexion->tomar_ticket($_GET['id']);

            if ($aux) {
                if ($aux != 2) {
                    //echo $conexion->consultar_ticket($_GET['id']);
                    header("Location: detalles_ticket.php?id=" . $_GET['id'] . "&estado=cerrado");
                } else {
                    echo "<center>Alguien mas ya abrio el ticket<br>";
                }
            } else {
                echo "Error de conexion, intente de nuevo en unos momentos.";
            }
        } else {
            echo "<center><form action='detalles_ticket.php?id=" . $_GET['id'] . "&estado=abierto&abrir=" . "' method='post'>" .
            '<input type="submit" value="Abrir ticket">';
        }
        break;
    case "cerrado":
        $conexion->privilegios("3"); /*         * ****************************************************** */
        $propietario[3] = imprimir_propiedades_ticket($conexion);

        imprimir_historial($conexion);

        if ($propietario[3] != "") {
            ?>
            <script src="../externos/jquery-3.3.1.min.js" type="text/javascript"></script>   
            <script>
                function validador() {

                    if ((document.getElementById("caja").value.replace(" ", "")).length > 3) {
                        document.getElementsByName("boton")[0].disabled = false;
                    } else {
                        document.getElementsByName("boton")[0].disabled = true;
                    }
                }
                function enviar_correo(licencia, caso) {
                    $.ajax({
                        url: "clientes/enviar_correo.php",
                        type: "GET",
                        data: {
                            numero: licencia,
                            caso: caso
                        },
                        success(salida) {
                            alert(salida);
                        }
                    });
                }
            </script>
            <center><form onkeyup="validador()" action='detalles_ticket.php?estado=resolver&id="<?php echo $_GET['id']; ?>"' method='post'>
                    Observaciones <textarea id='caja' maxlength="800" name="comentario" placeholder="Max. 800 caracteres."></textarea><br>
                    <input type="radio" name="accion" value="resolver" > Finalizar<br>
                    <input onclick="document.getElementsByClassName('fechayhora')[0].disabled = false; document.getElementsByClassName('fechayhora')[1].disabled = false;" type="radio" name="accion" value="reprogramar"> Reprogramar <input class="fechayhora" type="date" name="fecha" disabled><input class="fechayhora" type="time" name="hora" disabled><br>
                    <input type="radio" name="accion" value="cerrar" checked> Guardar <input type="text" maxlength="10" placeholder="Max. 10 caracteres." name="extra"> Area a asignar
                    <br><input name="boton" type="submit" value="Realizar acción." disabled></form>
                <br>
                --------------------------------------
                <br>
                Enviar correo:
                <br>
                <button type="submit" value="Caso 1" onclick="enviar_correo(<?php echo $_GET['id']; ?>, 1);">Caso 1</button>
                <br>
                <button type="submit" value="Caso 2" onclick="enviar_correo(<?php echo $_GET['id']; ?>, 2);">Caso 2</button>
                <br>
                <button type="submit" value="Caso 3" onclick="enviar_correo(<?php echo $_GET['id']; ?>, 3);">Caso 3</button>
                <br>

                <?php
            } else {
                echo ""; //el no abrio el ticket
            }
            break;
        case "resuelto":
            //echo $conexion->consultar_ticket($_GET['id']);
            $conexion->privilegios("3"); /*             * ****************************************************** */
            imprimir_propiedades_ticket($conexion);

            imprimir_historial($conexion);

            break;

        case "resolver":
            switch ($_POST['accion']) {
                case "resolver":
                    if ($conexion->resolver_ticket($_GET['id'], str_replace("\n", "<br>", $_POST['comentario']))) {
                        echo "<center> Ticket resuelto con exito ;)";
                    } else {
                        echo "<center> Error detectado, favor de volver a intentarlo.";
                    }
                    break;
                case "reprogramar":
                    if ($_POST['fecha'] == "" || $_POST['hora'] == "") {
                        echo "<center> No puede dejar la fecha o la hora vacia";
                    } else {
                        if ($conexion->reprogramar_ticket($_GET['id'], $_POST['fecha'], $_POST['hora'], $_POST['comentario'])) {
                            echo "<center> Reprogramación exitosa.";
                        } else {
                            echo "<center> No se pudo reprogramar";
                        }
                    }
                    break;
                case "cerrar":
                    $conexion->cerrar_ticket($_GET['id'], $_POST['comentario'], $_POST['extra']);
                    echo "Ticket cerrado";
                    break;
                case "0":
                    echo "Debe seleccionar una acción a realizar ¬¬";
                    break;
            }

            break;
    }

    $conexion->cerrar();

    unset($conexion);

    function imprimir_historial($conexion) {
        $resultado = $conexion->mostrar_acciones_previas_ticket($_GET['id']);

        //mostrar el historial del ticket

        while ($corrida = mysqli_fetch_array($resultado)) {

            echo $corrida[5] . "<br><br>";
        }
    }

    function imprimir_propiedades_ticket($conexion) {

        $propiedades = $conexion->propiedades_ticket($_GET['id']);

        $aux = preg_split("/&_&/", $propiedades[2]);

        //var_dump($aux);
        ?>
        <table border="1" width="100%">
            <tr>
                <td>Asunto</td>
                <td><?php echo "N°$propiedades[0] " . $propiedades[1]; ?></td>
                <td>Licencia</td>
                <td><?php echo $propiedades[5]; ?></td>
            </tr>
            <tr>
                <td>Llamar a</td>
                <td>
                    <table border="1" width="100%">
                        <tr>
                            <td><?php echo $aux[2]; ?></td>
                            <td>Telefono</td>
                            <td><?php echo $aux[3]; ?></td>
                        </tr>
                    </table>
                </td>
                <td>Fecha</td>
                <td><?php echo $aux[1]; ?></td>
            </tr>
        </table>
        <?php
        echo "<font size=6><b>" . $aux[0] . "</b> analizó:<br></font> ";
        //var_dump($aux);
        echo $aux[4] . "<br>";

        $propietario = $conexion->historial_ticket($_GET['id']);
        echo "<br>------------------<br>";

        return $propietario[3];
    }
    