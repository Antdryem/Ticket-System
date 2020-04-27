<?php
@session_start();
include 'conexionDB.php';
$conexion = new universo;
error_reporting(0);
$conexion->privilegios("0");
//echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
?>
<table border="1">
    <tr>
        <td></td>
        <!td><!ID Ticket</td>
    <td>Asunto</td>
    <td>Comentario inicial</td>
    <!td><!Momento de creación</td>
    <td>Estado de ticket</td>
    <td>Licencia del cliente</td>
    <td>Momento de solución</td>
    <!td><!ID Usuario</td>
    <!td><!Momento de reprogramación</td>
</tr>
<?php
if (!isset($_GET['busqueda'])) {
    $_GET['busqueda'] = "";
}

if (!isset($_GET['tipo_orden'])) {
    $_GET['tipo_orden'] = "2";
}

$ver = "";
{
    if (isset($_GET['resueltos']) && $_GET['resueltos'] == "1") {
        $ver .= "1";
    } else {
        $ver .= "0";
        $_GET['resueltos'] = "0";
    }
    if (isset($_GET['abiertos']) && $_GET['abiertos'] == "1") {
        $ver .= "1";
    } else {
        $ver .= "0";
        $_GET['abiertos'] = "0";
    }
    if (isset($_GET['cerrados']) && $_GET['cerrados'] == "1") {
        $ver .= "1";
    } else {
        $ver .= "0";
        $_GET['cerrados'] = "0";
    }
}

if ($ver == "000") {
    
}
if ($ver == "000") {
    $ver = "111";
}

//fechas

if (isset($_GET['antes']) && $_GET['antes'] != "") {
    $antes = $_GET['antes'];
} else {
    $antes = "";
}
if (isset($_GET['despues']) && $_GET['despues'] != "") {
    $despues = $_GET['despues'];
} else {
    $despues = "";
}

//usuario

if (isset($_GET['usuario']) && $_GET['usuario'] != "") {
    $usuario = $_GET['usuario'];
} else
    $usuario = "";

//busqueda
if (!isset($_GET['busqueda'])) {
    $_GET['busqueda'] = "";
}

//tipo busqueda
if (!isset($_GET['tipo_busqueda'])) {
    $_GET['tipo_busqueda'] = "0";
}
//paginacion
if (!isset($_GET['paginacion'])) {
    $_GET['paginacion'] = "1";
}
$resultado = $conexion->lista_tickets(
        $_GET['busqueda'], //
        $_GET['tipo_busqueda'], //
        $_GET['tipo_orden'], //
        $ver, //estado de los tickets que se mostraran
        $antes, //antes de fecha
        $despues, //despues de fecha
        $_GET['paginacion'], $usuario);
while ($corrida = mysqli_fetch_array($resultado)) {
    ?>
    <tr><td>
            <?php
            $estado = $corrida[4];
            switch ($corrida[4]) {
                case "abierto":
                    $imagen = "../imagenes/ENTRAR.png";
                    break;
                case "cerrado":
                    $imagen = "../imagenes/CERRAR.png";
                    $corrida[4] = "En proceso";
                    break;
                case "resuelto":
                    $imagen = "../imagenes/listo.png";
                    break;
            }
            echo ""
            . "<a href='../funciones/detalles_ticket.php?id=$corrida[0]&estado=$estado' target='izquierda'> "
            . "<img src='$imagen' alt='$corrida[4]' style='width:50px;height:50px;'>"
            . "</a>  "
            . "</td>";


            //echo $corrida[1] . "<br>";
            $imprimo = 0;
            $cuenta = 0;
            foreach ($corrida as $imprimir) {
                if ($imprimo) {
                    if ($cuenta !== 0 && $cuenta !== 3 && $cuenta !== 7 && $cuenta !== 8) {
                        ?>
                    <th>
                        <?php
                        if ($cuenta !== 2) {
                            if ($cuenta !== 5) {
                                echo $imprimir;
                            } else {
                                echo "<a href='clientes/detalles_cliente.php?licencia=$imprimir' target='izquierda'>" . $imprimir . "</a>";
                            }
                        } else {
                            $propiedades = $conexion->propiedades_ticket($corrida[0]);

                            $aux = preg_split("/&_&/", $propiedades[2]);
                            echo "Creado a las " . $propiedades[3] . "<br>";
                            echo "<b>" . $aux[0] . "</b> analizó:<br> ";
                            echo $aux[4] . "<br>";
                            echo "Llamar a " . $aux[2] . " al tel. " . $aux[3];
                          
                        }
                        ?>
                    </th>
                    <?php
                }
                $cuenta++;
                $imprimo = 0;
            } else {
                $imprimo = 1;
            }
        }
        ?>
    </tr>
    <?php
}
?>

</table>
<?php
include 'paginacion_tickets.php';

/*
  $los_get = "?";

  $key = key($_GET); // $key="Name" now

  foreach ($_GET as $key => $value) {  // another way to get keys and values.
  if ($los_get != "?") {
  $los_get .= "&";
  }
  $los_get .= $key . '=' . $value;
  }
  $keys = array_keys($_GET);

  $direccion = 'paginacion_tickets.php' . $los_get;

  include $direccion;

 */
$conexion->cerrar();
unset($conexion);
?>
</table>