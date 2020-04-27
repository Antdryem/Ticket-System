<?php
if (isset($_GET['comentario'])) {
    echo "<center>" . $_GET['comentario'];
}
?>

<form action="../funciones/validador_cliente.php" method="post">
    <br>
    <br>
    <br>
    <br>
    <center>
        Licencia
        <input type="text" name="licencia" value="">
        <br>
        <br>
        Nombre de empresa
        <input type="text" name="nombre" value="">
        <br>
        <br>
        Correo
        <input type="text" name="correo" value="">
        <br>
        <br>
        <input type="submit" value="Crear cliente"></center>
</form> 
 <?php
 include 'crear_telefono.php';