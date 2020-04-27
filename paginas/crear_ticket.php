
<?php
error_reporting(0);


if (isset($_GET['todo'])) {
    @session_start();
    include '../funciones/conexionDB.php';
    $conexion = new universo;


    $licencia = $_SESSION['licencia'];
    $asunto = $_SESSION['asunto'];
    $comentario = $_SESSION['comentario'];

    $telefono = $_POST['telefono'];
    $nombre = $_POST['nombre'];
    $nuevo_tel = $_POST['tel'];

    if ($telefono == "krnaza") {
        $resultado = $conexion->meter_telefono($licencia, $nombre, $nuevo_tel);
        if ($resultado != "Telefono guardado") {
            echo "Error al guardar el nuevo telefono";
            exit;
        } else {
            $telefono = "$nombre&_&$nuevo_tel";
        }
    }
    echo "<center>";
    $conexion->crear_ticket($licencia, $asunto, $telefono, $comentario);

    $conexion->cerrar();
    unset($conexion);
} else {
    if (!isset($_GET['licencia'])) {
        if (!isset($_POST['licencia'])) {
            ?>
            <form action="crear_ticket.php" method="post">
                <br>
                <br><br>
                <br>
                <center>
                    Licencia
                    <input type="text" name="licencia" value="">

                    <input type="submit" value="Consultar cliente"></center>
            </form> 

            <?php
        } else {
            include '../funciones/consultar_cliente.php';
        }
    } else {
        @session_start();
        include '../funciones/conexionDB.php';
        $conexion = new universo;

        $conexion->privilegios("1");
        echo "<center>";
        if ($_POST['asunto'] != "" && $_POST['comentario'] != "") {
            include '../funciones/validador_ticket.php';
        } else {
            echo "Debes llenar todos los espacios.";
            unset($_GET['licencia']);
            include 'crear_ticket.php';
        }

        $resultado = $conexion->ver_comentarios_cliente($_GET['licencia']);
        ?>
        Comentarios de otros usuarios:
        <table border="1">
            <?php
            while ($corrida = mysqli_fetch_array($resultado)) {
                echo "<tr>";
                echo "<td>" . $conexion->nombre_usuario($corrida[0]) . "</td><td>$corrida[1]</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <?php
        $conexion->cerrar();
        unset($conexion);
    }
}



