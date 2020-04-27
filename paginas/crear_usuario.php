<?php
include '../funciones/conexionDB.php';
$conexion = new universo;
@session_start();
for ($numero = 0; $numero < 9; $numero++)
    $conexion->privilegios((string) $numero);
$conexion->cerrar();
unset($conexion);
if (isset($_GET['comentario'])) {
    echo "<center>" . $_GET['comentario'];
}
?>

<form action="../funciones/validador_usuario.php" method="post">
    <br>
    <br><br>
    <br>
    <center>
        Nombre de usuario
        <input type="text" name="usuario_creado" value="">
        <br>
        <br>
        Contrasena de usuario
        <input type="password" name="contrasena" value="">
        <br>
        Privilegios:
        <input type="checkbox" name="dios">Usuario Administrador
        <br>
        <input type="checkbox" name="0">Consultar historial tickets.
        <br>
        <input type="checkbox" name="1">Crear tickets
        <br>
        <input type="checkbox" name="2">Trabajar con tickets
        <br>
        <input type="checkbox" name="3">Consutlar Tickets
        <br>
        <input type="checkbox" name="4">Ver reportes y graficos
        <br>
        <input type="checkbox" name="5">Crear clientes
        <br>
        <input type="checkbox" name="6">Comentar clietnes
        <br>
        <input type="checkbox" name="7">Registrar errores y soluciones
        <br>
        <input type="checkbox" name="8">Aprobar errores y soluciones
        <br>
        <input type="submit" value="Crear usuario"></center>
</form> 
