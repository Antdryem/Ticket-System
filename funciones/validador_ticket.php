<script>
    function accion(acciones) {
        if (acciones == 1) {
            document.getElementById('agregar').checked = true;
            document.getElementById('1').required = true;
            document.getElementById('2').required = true;
        } else {
            document.getElementById('1').required = false;
            document.getElementById('2').required = false;
        }
    }
</script>
<a href="../paginas/crear_ticket.php"><=Atras<=</a><br>
<form action="crear_ticket.php?todo=hecho" method="post">
    <input id="agregar" type="radio" name="telefono" onclick="accion(1)" value="krnaza" checked>Nombre
    <input id="1" type="text" name="nombre" value="" onclick="accion(1)">Telefono
    <input id="2" type="text" name="tel" value="" onclick="accion(1)"><br>
    <?php
    /*
     * $_GET['licencia']
     * $_post['asunto']
     * $_post['comentario']
     */

    /*
      @session_start();
      include 'conexionDB.php';
      $conexion = new universo;

     */
    $resultado = $conexion->imprimir_telefonos($_GET['licencia']);

    while ($corrida = mysqli_fetch_array($resultado)) {
        echo '<input onclick="accion(0)" type="radio" name="telefono" value="' . $corrida[2] . '&_&' . $corrida[3] . '" checked> ' . $corrida[2] . ", tel. " . $corrida[3] . '<br>';
    }

    $_SESSION['licencia'] = $_GET['licencia'];
    $_SESSION['asunto'] = $_POST['asunto'];
    $_SESSION['comentario'] = $_POST['comentario'];

    $conexion->cerrar();
    unset($conexion);
    ?>

    <br>
    <input onclick="crear_ticket()" type="submit" value="Crear ticket">
</form>
