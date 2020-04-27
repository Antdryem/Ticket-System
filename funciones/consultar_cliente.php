<?php

@session_start();
include 'conexionDB.php';
$conexion = new universo;

$resultado = $conexion->consultar_cliente($_POST['licencia']);
echo "<center>" . "La licencia " . $_POST['licencia'] . " esta: " . $resultado;

switch ($resultado) {
    case "vigente":
        echo '<form action="crear_ticket.php?licencia='.$_POST['licencia'].'" method="post">
        <br>
        <br>
        <br>
        <center>
            Asunto
            <input maxlength="40" placeholder="Max. 40 caracteres." type="text" name="asunto" value="">
            <br> 
            Comentario
             <textarea maxlength="250" name="comentario" placeholder="Max. 250 caracteres."></textarea><br>
            <input type="submit" value="Crear ticket"></center>
    </form><br> Ningun campo debe quedar vacio.';
        break;
    case "no vigente":
        include '../paginas/crear_ticket.php';
        break;
    case "no existente":
        include '../paginas/crear_cliente.php';
        break;
}

$conexion->cerrar();
unset($conexion);
