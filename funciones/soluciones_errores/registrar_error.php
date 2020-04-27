<?php
include "../conexionDB.php";
@session_start();
$conexion = new universo;
$conexion->privilegios("7");
?>

<form method="post" action="registrando_error.php">
    Nombre del error <input name="error" type="text" maxlength="50"><br>
    Categoria <br>
    <input type="radio" name="categoria" value="xyz"><input type="text" name="nuevo" ><br>
    <?php $conexion->imprimir_categorias(); ?>
    <input type="submit" value="Registrar">
</form>


<?php
$conexion->cerrar();
unset($conexion);
