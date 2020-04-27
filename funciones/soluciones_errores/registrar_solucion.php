<?php
include "../conexionDB.php";
@session_start();
$conexion = new universo;
$conexion->privilegios("7");
?>

<form method="post" action="registrando_solucion.php">

    Nombre de solución <input type="text" name="nombre" maxlength="50"><br>
    Descripción <textarea type="text" name="comentario"></textarea><br>
    <br>
    Selecciona a que error pertenece la solución:
    <br>
    <?php
    $resultado = $conexion->sacar_errores();
    while ($corrida = mysqli_fetch_array($resultado)) {
        
        echo '<input id="'.$corrida['id_error'].'" type="radio" name="error" value="'.$corrida['id_error'].'">'.$corrida['nombre']."<br>";
    }
    ?>
    
    <br>
    <input type="submit" value="Registrar">
</form>


<?php
$conexion->cerrar();
unset($conexion);
