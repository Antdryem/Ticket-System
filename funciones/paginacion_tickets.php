<center>
<?php
$paginas = ceil(mysqli_fetch_array($conexion->paginacion_tickets(
                        $_GET['busqueda'], //
                        $_GET['tipo_busqueda'], //
                        $_GET['tipo_orden'], //
                        $ver, //estado de los tickets que se mostraran
                        $antes, //antes de fecha
                        $despues, //despues de fecha
                        $_GET['paginacion'], //
                        $usuario))[0] / 30);

$url = "lista_tickets.php?busqueda=" . $_GET['busqueda']
        . "&tipo_busqueda=" . $_GET['tipo_busqueda']
        . "&tipo_orden=" . $_GET['tipo_orden']
        . "&resueltos=" . $_GET['resueltos']
        . "&abiertos=" . $_GET['abiertos']
        . "&cerrados=" . $_GET['cerrados']
        . "&antes=" . $antes
        . "&despues=" . $despues
        . "&usuario=" . $usuario
        . "&paginacion=";

for ($pene = 1; $pene <= $paginas; $pene++) {
    if($pene==$_GET['paginacion'])
    {
        echo "<b><font size=5>";
    }
    ?>
    <a href="<?php echo $url . $pene; ?>"><?php echo $pene; ?></a>
    <?php
    if($pene==$_GET['paginacion'])
    {
        echo "</font></b>";
    }
}