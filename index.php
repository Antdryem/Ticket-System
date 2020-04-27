<?php
ob_start();
@session_start();

error_reporting(0);
?>

<html>
    <head>

        <meta charset="UTF-8">
        <script src="externos/jquery-3.3.1.min.js" type="text/javascript"></script>   

        <title>Tickets</title>

    </head>
    <?php
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: formulario.php");
    }
    ?>
    <frameset cols="*,40%" border=0>
        <frame src="paginas/menu_principal.php" name="superior">

            
                
                    <frame src="paginas/tickets.php" name="derecha">
                        
                        </frameset>
   
                        </html>