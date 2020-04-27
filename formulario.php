<html>
    <body>
        <?php
        ob_start();
        @session_start();
        if (isset($_SESSION['id_usuario'])) {
            header("Location: index.php");
        }
        if (isset($_GET['pene'])) {
            echo "Emilio Andres Yannez Anton<br>";
        }
        ?>

        <form action="funciones/validador_usuario.php" method="post">
            <br>
            <br><br>
            <br>
            <center>
                Usuario
                <input type="text" name="usuario" value="">
                <br>
                <br>
                Contrasena
                <input type="password" name="contrasena" value="">
                <br><br>
                <input type="submit" value="Iniciar sesion">
                <p>Ingresa tu usuario y contrasena para continuar</p>
            </center>
        </form> 



    </body>
</html>


<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

