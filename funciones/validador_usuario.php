<?php

ob_start();
@session_start();
include 'conexionDB.php';
$conexion = new universo;
//iniciar sesion
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $resultado = $conexion->inicio_usuario($_POST['usuario'], $_POST['contrasena']);

    echo $resultado;

    if (is_numeric($resultado) && session_start()) {
        $_SESSION['id_usuario'] = $resultado;
        echo "<br>" . $_SESSION['id_usuario'];
        header("Location: ../index.php");
    } else {
        header("Location: ../formulario.php");
    }
} else
//crear nuevo usuario
if (isset($_POST['usuario_creado'])) {
    if ($_POST['contrasena'] != "" && trim($_POST['usuario_creado'], " ") !== "") {

        //habilitar privilegios
        $privilegios = "";
        if (!isset($_POST['dios'])) {
            for ($pene = 0; $pene < 9; $pene++) {
                if (isset($_POST[$pene])) {
                    $privilegios .= "1";
                } else {
                    $privilegios .= "0";
                }
            }
        } else {
            $privilegios = "111111111";
        }

        header("Location: ../paginas/crear_usuario.php?comentario=" . $resultado = $conexion->crear_usuario($_POST['usuario_creado'], $_POST['contrasena'], $privilegios));
    } else {
        //si no se ingreso contrasena
        header("Location: ../paginas/crear_usuario.php?comentario=Debes ingresar una contraseña y un usuario");
    }
} else {
//cerrar sesion
    unset($_SESSION['id_usuario']);
    session_destroy();
    //echo ($_SESSION['id_usuario']);
    header("Location: ../formulario.php");
}



$conexion->cerrar();
unset($conexion);
