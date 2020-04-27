<?php
if (isset($_GET['accion'])) {
    switch ($_GET['accion']) {
        case "propiedades":
            echo "Cambiando propiedades";
            @session_start();
            include '../conexionDB.php';
            $conexion = new universo;


            $resultado = $conexion->propiedades_cliente($_GET['licencia']);
            ?>
            <form action="modificando_cliente.php?licencia=<?php echo $_GET['licencia'] ?>" method="post" target="izquierda">
                Nombre de empresa
                <input type="text" name="nombre" value="<?php echo $resultado[1] ?>">
                <br>
                Correo
                <input type="text" name="correo" value="<?php echo $resultado[2] ?>">
                <br>
                <input type="submit" value="Modificar cliente">
                <br>
                No deje ningun campo en blanco y respete el formato de los correos.
            </form> 
            <?php
            $conexion->cerrar();
            unset($conexion);

            break;
        case "telefono":
            //echo "Cambiando telefono";
            //echo "<br>" . $_GET['id_telefono'] . " " . $_GET['telefono'] . " " . $_GET['nombre'];
            ?>
            Cambiando telefono
            <form action="modificando_cliente.php?licencia=<?php echo $_GET['licencia'] ?>&id_telefono=<?php echo $_GET['id_telefono']; ?>" method="post" target="izquierda">
                Nombre
                <input type="text" name="nombre" value="<?php echo $_GET['nombre'] ?>">
                <br>
                Tel.
                <input type="text" name="telefono" value="<?php echo $_GET['telefono'] ?>">
                <br>
                <input type="submit" value="Modificar telefono">
            </form> 
            <br>
            Si desea eliminar ell telefono deje el espacio en blanco.
            <?php
            break;
    }
}