<?php

class licencia {

    protected $conexion;

// Procedimiento para conectar
    public function conectar() {
        $username = "puntodev_dicom";
        $password = "41jalufo41";
        $this->conexion = mysqli_connect("69.73.141.47", $username, $password, "puntodev_liberapzp");
        /* Conectar a BD de licencia */
        if (mysqli_connect_errno($this->conexion)) {
            echo "Error al conectar con MySQL: " . mysqli_connect_error();
        } else {
            //echo "todo verde krnaza";
        }
    }

    function __construct() {
        $this->conectar();
    }

    public function cerrar() {
        $this->conexion = NULL;
    }
    
    public function vigencia($licencia){
        $sql="select licencia, vencimiento from licenciasv6 where licencia='".$licencia."'";
        $resultado = $this->conexion->query($sql);
        $corrida = mysqli_fetch_array($resultado);
        return $corrida;
    }
}
