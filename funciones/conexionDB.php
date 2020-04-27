<?php

/*
 * Usuario dios-> disponible si tienes todos los privilegios, unico que puede crear y modificar usuarios
 * 
 * 0.-Consultar el historial de tickets +
 * 1.-Crear tickets                     +
 * 2.-Trabajar con tickets              +
 * 3.-Visualizar tickets                +
 * 4.-Ver reportes                      +
 * 5.-Crear y modificar clietes         +
 * 6.-Comentar clientes                 +
 * 7.-Registrar errores y soluciones    +
 * 8.-Aprobar errores y soluciones      +
 * 
 * 0-1-2-3-4-5-6-7-8
 * 1 1 1 1 1 1 1 1 1
 *   
 */

class universo {

    protected $conexion;

// Procedimiento para conectar
    public function conectar() {
        $username = "puntodev_Anton";
        $password = "55221199";
        $this->conexion = mysqli_connect("69.73.141.47", $username, $password, "puntodev_nuevos_tickets");
        /* Conectar a BD Local */
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
//mysqli_close($this->conexion);
        $this->conexion = NULL;
    }

    public function privilegios($numero) {
        $sql = "select privilegios from usuario where id_usuario='" . $_SESSION['id_usuario'] . "'";
        $resultado = mysqli_fetch_array($this->conexion->query($sql));
        //echo $sql."<br>";
        if ($resultado['privilegios'][$numero] !== "1") {
            echo "No tienes privilegios para hacer esto.";
            exit;
        }
    }

    public function inicio_usuario($usuario, $contrasena) {
//error_reporting(0);
        $sql = "select * from usuario where nombre='" . $usuario . "' and contrasena='" . $contrasena . "'";
        $resultado = $this->conexion->query($sql);

        $corrida = mysqli_fetch_array($resultado);

        return $corrida[0];
    }

    public function formato_fecha() {
        date_default_timezone_set('America/Mexico_city');
        $momento = getdate();
        if ((int) $momento['mon'] < 10) {
            $momento['mon'] = "0" . $momento['mon'];
        }
        if ((int) $momento['mday'] < 10) {
            $momento['mday'] = "0" . $momento['mday'];
        }
        if ((int) $momento['seconds'] < 10) {
            $momento['seconds'] = "0" . $momento['seconds'];
        }
        if ((int) $momento['hours'] < 10) {
            $momento['hours'] = "0" . $momento['hours'];
        }
        if ((int) $momento['minutes'] < 10) {
            $momento['minutes'] = "0" . $momento['minutes'];
        }

        return $momento['year'] . "-" .
                $momento['mon'] . "-" .
                $momento['mday'] . " " .
                $momento['hours'] . ":" .
                $momento['minutes'] . ":" .
                $momento['seconds'];
    }

    public function usuario() {
        $sql = "select nombre from usuario where id_usuario='" . $_SESSION['id_usuario'] . "'";
        $resultado = $this->conexion->query($sql);
        $usuario = mysqli_fetch_array($resultado);
        return $usuario[0];
    }

    public function nombre_usuario($id_usuario) {
        $sql = "select nombre from usuario where id_usuario='$id_usuario'";
        $resultado = $this->conexion->query($sql);
        $usuario = mysqli_fetch_array($resultado);
        return $usuario[0];
    }

    public function id_usuario($nombre) {
        $sql = "select id_usuario from usuario where nombre='$nombre'";
        $resultado = $this->conexion->query($sql);
        if ($corrida = mysqli_fetch_array($resultado)) {
            return $corrida[0];
        } else {
            return 0;
        }
    }

    public function crear_usuario($nombre, $contrasena, $privilegios) {
//sacar nombre del usuario que creo al cliente
        $sql = "select * from usuario where nombre='" . $nombre . "'";
        $resultado = $this->conexion->query($sql);
        $corrida = mysqli_fetch_array($resultado);
//condicion para meter, o no, al usuario
        if ($corrida[0] == "") {

            date_default_timezone_set('America/Mexico_city');
            $momento = getdate();
            $momento = $momento['year'] . "-" . $momento['mon'] . "-" . $momento['mday'] . " " . $momento['hours'] . ":" . $momento['minutes'] . ":" . $momento['seconds'];
            $sql = "INSERT INTO `usuario` (`nombre`, `creador`, `contrasena`, `momento_creacion`, `privilegios`) VALUES ('$nombre','" . $_SESSION['id_usuario'] . "','$contrasena', '$momento', '$privilegios')";

            if ($this->conexion->query($sql)) {
                return "Usuario creado con exito.";
            } else {
                return "Hubo problemas al crear el usuario, favor de intentar de nuevo.";
            }
        } else {
            return "Nombre de usuario ya existente.";
        }
    }

    public function crear_cliente($licencia, $nombre, $correo) {

//verificar que el cliente no exista
        $sql = "select * from clientes where licencia='" . $licencia . "'";
        $resultado = $this->conexion->query($sql);
        $corrida = mysqli_fetch_array($resultado);

//sacar nombre del usuario que creo al cliente
        $usuario = $this->usuario();

//vigencia de la licencia

        include 'conexionDB_licencia.php';

        $vigencia = new licencia;

        $resultado = $vigencia->vigencia($licencia);

        $vigencia->cerrar();

//return $resultado[1];
//condicion para meter, o no, al cliente----------------------------------
//if ($resultado[1] !== "") {
        if ($corrida[0] == "") {
            date_default_timezone_set('America/Mexico_city');
            $momento = getdate();
//licencia vencida-------------------
//return $momento['year']."-----".$resultado[1][0] . $resultado[1][1] . $resultado[1][2] . $resultado[1][3]."<br>".
//        $momento['mon'] ."-----". $resultado[1][5] . $resultado[1][6]."<br>".
//        $momento['mday'] ."-----". $resultado[1][8] . $resultado[1][9];
            if ((int) $momento['year'] < (int) ($resultado[1][0] . $resultado[1][1] . $resultado[1][2] . $resultado[1][3]) ||
                    ((int) $momento['year'] == (int) ($resultado[1][0] . $resultado[1][1] . $resultado[1][2] . $resultado[1][3]) && (int) $momento['mon'] < (int) ($resultado[1][5] . $resultado[1][6])) ||
                    ((int) $momento['year'] == (int) ($resultado[1][0] . $resultado[1][1] . $resultado[1][2] . $resultado[1][3]) && (int) $momento['mon'] == (int) ($resultado[1][5] . $resultado[1][6]) && (int) $momento['mday'] <= (int) ($resultado[1][8] . $resultado[1][9]))) {
                $momento = $momento['year'] . "-" . $momento['mon'] . "-" . $momento['mday'] . " " . $momento['hours'] . ":" . $momento['minutes'] . ":" . $momento['seconds'];
                $sql = "INSERT INTO `clientes` (`licencia`, `nombre_empresa`, `correo`, `id_usuario`, `historial`) VALUES ('" . (int) $licencia . "','" . $nombre . "','$correo', '" . $_SESSION['id_usuario'] . "', 'Creado por $usuario. Con fecha de $momento')";

                if ($this->conexion->query($sql)) {
                    return "Cliente creado con exito.";
                } else {
                    return "Hubo problemas al crear el cliente, favor de intentar de nuevo.";
                }
            } else {
                return "La licencia no se encuentra vigente o no existe :(";
            }
        } else {
            return "Licencia de cliente ya existente.";
        }
        /* }else
          {
          return "La licencia no existe.";
          } */
    }

    public function consultar_cliente($licencia) {
        $sql = "select * from clientes where licencia='$licencia'";
        $resultado = $this->conexion->query($sql);
        $corrida = mysqli_fetch_array($resultado);
        if ($corrida[0] != "") {

//vigencia de la licencia

            include 'conexionDB_licencia.php';

            $vigencia = new licencia;

            $resultado = $vigencia->vigencia($licencia);

            $vigencia->cerrar();

            $momento = getdate();
            echo "<br><center> Vencimiento: " . $resultado['vencimiento'];
            if ((int) $momento['year'] < (int) ($resultado[1][0] . $resultado[1][1] . $resultado[1][2] . $resultado[1][3]) ||
                    ((int) $momento['year'] == (int) ($resultado[1][0] . $resultado[1][1] . $resultado[1][2] . $resultado[1][3]) && $momento['mon'] < (int) ($resultado[1][5] . $resultado[1][6])) ||
                    ((int) $momento['year'] == (int) ($resultado[1][0] . $resultado[1][1] . $resultado[1][2] . $resultado[1][3]) && $momento['mon'] == (int) ($resultado[1][5] . $resultado[1][6]) && $momento['mday'] <= (int) ($resultado[1][8] . $resultado[1][9]))) {

                return "vigente";
            } else {
                return "no vigente";
            }
        } else {
            return "no existente";
        }
    }

    public function meter_telefono($licencia, $nombre, $telefono) {
        $sql = "select * from clientes where licencia='$licencia'";
        $resultado = $this->conexion->query($sql);
        $corrida = mysqli_fetch_array($resultado);
        if ($corrida[0] != "") {
            $sql = "INSERT INTO `telefonos` (`licencia`, `contacto`, `telefono`, `id_usuario`) "
                    . "VALUES ('$licencia','" . $nombre . "','$telefono', '" . $_SESSION['id_usuario'] . "')";
            if ($this->conexion->query($sql)) {
                return "Telefono guardado";
            } else {
                return "Telefono no guardado, intente de nuevo";
            }
        } else {
            return "Cliente no existente";
        }
    }

    public function imprimir_telefonos($licencia) {
        $sql = "select * from telefonos where licencia='$licencia'";
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    public function crear_ticket($licencia, $asunto, $telefono, $comentario) {
        if ($this->consultar_cliente($licencia) != "vigente") {
            echo "Cliente no vigente, debe renovar licencia.";
            exit;
        }
        $momento = $this->formato_fecha();

//sacar nombre del usuario que creo al cliente
        $usuario = $this->usuario();

        /* $sql = "INSERT INTO `ticket` (`licencia`, `asunto`, `comentario`, `id_usuario`, `momento_creacion`, `estado`) "
          . "VALUES ('$licencia','" . $asunto . "','" .
          "Creado por $usuario a las $momento <br> $telefono <br>----------------------------------"
          . "<br> $usuario analizó: <br> $comentario"
          . "<br>---------------', '" . $_SESSION['id_usuario'] . "', '$momento', 'abierto')"; */
        $sql = "INSERT INTO `ticket` (`licencia`, `asunto`, `comentario`, `id_usuario`, `momento_creacion`, `estado`) "
                . " VALUES ('$licencia','" . $asunto . "',' $usuario&_&$momento&_&$telefono&_&$comentario ', '"
                . $_SESSION['id_usuario'] . "', '$momento', 'abierto')";
//echo $sql."<br>";
        if ($this->conexion->query($sql)) {
            echo "Ticket creado con éxito";
        } else {
            echo "Error al crear el ticket, intente de nuevo, por favor.";
        }
    }

    public function mostrar_tickets() {
        $momento = $this->formato_fecha();
        $sql = "select * from ticket where (estado='abierto' or estado='cerrado') and reprogramacion<'" . $momento . "' order by momento_creacion asc";
        return $this->conexion->query($sql);
    }

    public function info_cliente($licencia) {
        $sql = "select * from clientes where licencia='$licencia'";
        return $this->conexion->query($sql);
    }

    /* public function consultar_ticket($id) {
      if (isset($_GET['abrir'])) {
      header("Location: detalles_ticket.php?id=$id&estado=cerrado");
      }

      $corrida = $this->propiedades_ticket($id);
      $salida = "<br>";
      $salida .= $corrida[1] . "<br>";
      $salida .= $corrida[2];
      $aux = $this->abrir_ticket($id, 1);
      while ($corrida = mysqli_fetch_array($aux)) {
      $salida .= "<br>" . $corrida[5];
      }

      return $salida;
      } */

    public function abrir_ticket($id_ticket, $modo) {
        switch ($modo) {
            case 0:
                $sql = "select * from historial_tickets where id_ticket='$id_ticket' and momento_cierre='0000-00-00 00:00:00'";
                break;
            case 1:
                $sql = "select * from historial_tickets where id_ticket='$id_ticket'";
                break;
        }
        $resultado = $this->conexion->query($sql);
//$corrida = mysqli_fetch_array($resultado);
        return $resultado;
    }

    public function tomar_ticket($id_ticket) {
        $corrida = mysqli_fetch_array($this->abrir_ticket($id_ticket, 0));
        if ($corrida[0] == "") {

            $sql = "insert into `historial_tickets` (`momento_apertura`, `id_ticket`, `id_usuario`, `comentario`) values ('" . $this->formato_fecha() . "', '$id_ticket', '" . $_SESSION['id_usuario'] . "', '" . $this->formato_fecha() . ">>>" . $this->usuario() . " ha abierto el ticket')";

            if ($this->conexion->query($sql)) {

                $sql = "UPDATE ticket SET estado='cerrado' WHERE id_ticket='$id_ticket'";
                $this->conexion->query($sql);
                return 1;
            } else {
                return 0;
            }
        } else {
//echo "<center>Alguien mas ya abrio el ticket<br>";
            return 2;
        }
    }

    public function propiedades_ticket($id_ticket) {
        $sql = "select * from ticket where id_ticket='$id_ticket'";
        $resultado = $this->conexion->query($sql);
        $corrida = mysqli_fetch_array($resultado);
        return $corrida;
    }

    public function historial_ticket($id_ticket) {
        $sql = "select * from historial_tickets where id_ticket='$id_ticket' and id_usuario='" . $_SESSION['id_usuario'] . "' and momento_cierre='0000-00-00 00:00:00'";
        $resultado = $this->conexion->query($sql);
        $corrida = mysqli_fetch_array($resultado);
        return $corrida;
    }

//no recuerdo en donde utilizaba esta funcion, en cuyo caso se quedara aqui, uno nunca sabe v:

    public function mostrar_acciones_previas_ticket($id_ticket) {
        $sql = "select * from historial_tickets where id_ticket='$id_ticket'";
        $resultado = $this->conexion->query($sql);
        return $resultado;
    }

    public function resolver_ticket($id_ticket, $nuevo_comentario) {
        $corrida = $this->tomar_comentario_historial_ticket($id_ticket);

//echo $corrida[5];

        $tiempo = $this->formato_fecha();

        $sql = "update historial_tickets  set momento_cierre='" . $tiempo . "', comentario='$corrida[5]<br>" . $nuevo_comentario . "<br>" . $tiempo . ">>>" . $this->usuario() . " ha solucionado el ticket <br> ---------------' where id_ticket=$id_ticket and id_usuario='" . $_SESSION['id_usuario'] . "' and momento_cierre='0000-00-00 00:00:00'";
        $this->conexion->query($sql);

        $sql = "update ticket  set estado='resuelto', momento_solucion='" . $tiempo . "' where id_ticket=$id_ticket";

        if ($this->conexion->query($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function tomar_comentario_historial_ticket($id_ticket) {
        $sql = "select * from historial_tickets where id_ticket=$id_ticket and id_usuario='" . $_SESSION['id_usuario'] . "' and momento_cierre='0000-00-00 00:00:00'";
        $comentario = $this->conexion->query($sql); //.$comentario;

        $corrida = mysqli_fetch_array($comentario);
        return $corrida;
    }

    public function comparar_fechas($fecha_creacion) {
        $fecha_actual = $this->formato_fecha();

        $anos = (int) $fecha_actual[3] - (int) $fecha_creacion[3];

        $meses = (int) ($fecha_actual[5] . $fecha_actual[6]) - (int) ($fecha_creacion[5] . $fecha_creacion[6]);

        $dias = (int) ($fecha_actual[8] . $fecha_actual[9]) - (int) ($fecha_creacion[8] . $fecha_creacion[9]);

        $horas = (int) ($fecha_actual[11] . $fecha_actual[12]) - (int) ($fecha_creacion[11] . $fecha_creacion[12]);
        /*         * ***************************************************** */
//creacion
        $fecha_creacion = preg_split("/-/", $fecha_creacion);

        $hora_creacion = preg_split("/ /", $fecha_creacion[2]);

        $hora_creacion = preg_split("/:/", $hora_creacion[1]);

        $aux = preg_split("/ /", $fecha_creacion[2]);

        $fecha_creacion[2] = $aux[0];

        $fecha_creacion[3] = $hora_creacion[0];

//actual
        $fecha_actual = preg_split("/-/", $fecha_actual);

        $hora_actual = preg_split("/ /", $fecha_actual[2]);

        $hora_actual = preg_split("/:/", $hora_actual[1]);

        $aux = preg_split("/ /", $fecha_actual[2]);

        $fecha_actual[2] = $aux[0];

        $fecha_actual[3] = $hora_actual[0];

//aqui la fecha ya esta con formato :)

        $anos = (int) $fecha_actual[0] - (int) $fecha_creacion[0];

        $meses = (int) $fecha_actual[1] - (int) $fecha_creacion[1];

        $dias = (int) $fecha_actual[2] - (int) $fecha_creacion[2];

        $horas = (int) $fecha_actual[3] - (int) $fecha_creacion[3];


        $horas_totales = $anos * (365 * 24) + $meses * (30 * 24) + $dias * (24) + $horas;

        return $horas_totales;
    }

    public function cerrar_ticket($id_ticket, $observaciones, $extra) {
        $sql = "UPDATE ticket SET estado='abierto', extra='$extra' WHERE id_ticket=$id_ticket";
        $this->conexion->query($sql);

        $corrida = $this->tomar_comentario_historial_ticket($id_ticket);

        $comentario = $corrida[5];

        $sql = "UPDATE historial_tickets SET momento_cierre='" . $this->formato_fecha() . "', "
                . "comentario='$comentario <br><br>"
                . "Dijo: $observaciones"
                . "<br>" .
                $this->formato_fecha() . ">>>" . $this->usuario() . " ha cerrado el ticket."
                . "<br> --------------' WHERE id_ticket=$id_ticket"
                . "and momento_cierre='0000-00-00 00:00:00'";

        $this->conexion->query($sql);
    }

    public function reprogramar_ticket($id_ticket, $reprogramacion, $hora, $observaciones) {
        $sql = "update ticket set estado='abierto', reprogramacion='$reprogramacion $hora' where id_ticket=$id_ticket";
        if ($this->conexion->query($sql)) {

            $corrida = $this->tomar_comentario_historial_ticket($id_ticket);
            $sql = "update historial_tickets  set momento_cierre='" . $this->formato_fecha() .
                    "', comentario='$corrida[5]<br>" . $observaciones . "<br>" . $this->formato_fecha()
                    . ">>>" . $this->usuario() . " ha reprogramado el ticket para $reprogramacion $hora<br>"
                    . " ------------------' where id_ticket=$id_ticket "
                    . "and id_usuario='" . $_SESSION['id_usuario'] . "' and momento_cierre='0000-00-00 00:00:00'";


            /* $sql = "UPDATE historial_tickets SET momento_cierre='" . $this->formato_fecha() . "', "
              . "comentario='$comentario <br>______________________________________<br>" .
              $this->formato_fecha() . ">>>" . $this->usuario() . " ha cerrado el ticket."
              . "<br>Dijo: $observaciones <br>_______________' WHERE id_ticket='$id_ticket' "
              . "and momento_cierre='0000-00-00 00:00:00'"; */

            $this->conexion->query($sql);

            return 1;
        } else {
            return 0;
        }
    }

    public function lista_tickets($busqueda, $tipo, $orden, $ver, $antes_de, $despues_de, $paginacion, $usuario) {
        if ($antes_de !== "")
            $antes_de .= " 23:59:59";
        if ($despues_de !== "")
            $despues_de .= " 00:00:00";
        $sql = "select * from ticket where ";

        switch ($orden) {
            case "0":
                $orden = " ORDER BY asunto asc ";
                break;
            case "1":
                $orden = " ORDER BY asunto desc ";
                break;
            case "2":
                $orden = " ORDER BY momento_creacion desc ";
                break;
            case "3":
                $orden = " ORDER BY momento_creacion asc ";
                break;
        }

        switch ($ver) {
            case "001":
                $ver = " estado='cerrado' ";
                break;
            case "010":
                $ver = " estado='abierto' ";
                break;
            case "011":
                $ver = " (estado='cerrado' or estado='abierto') ";
                break;
            case "100":
                $ver = " estado='resuelto' ";
                break;
            case "101":
                $ver = " (estado='cerrado' or estado='resuelto') ";
                break;
            case "110":
                $ver = " (estado='resuelto' or estado='abierto') ";
                break;
            case "111":
                $ver = "";
                break;
        }

        $fecha = "";

        if ($antes_de != "") {

            $fecha .= " (momento_creacion<'$antes_de' or momento_solucion<'$antes_de') ";
            if ($ver != "") {
                $fecha = " and " . $fecha;
            }
        }
        if ($despues_de != "") {
            if ($ver != "" || strlen($fecha) > 20) {
                $fecha .= " and ";
            }
            $fecha .= " (momento_creacion>'$despues_de' or momento_solucion>'$despues_de') ";
        }


//busqueda
        if ($busqueda != "") {
            switch ($tipo) {
                case "0":
                    $aux_array = preg_split("/ /", $busqueda);
//var_dump($aux_array);
                    $busqueda = " ( ";
                    for ($pene = 0; $pene < count($aux_array); $pene++) {
                        $sql_licencia = "select licencia from clientes where nombre_empresa like '%$aux_array[$pene]%'";
                        $resultado = $this->conexion->query($sql_licencia);
                        while ($corrida = mysqli_fetch_array($resultado)) {
                            if ($busqueda !== " ( ") {
                                $busqueda .= " or ";
                            }
                            $busqueda .= " licencia='$corrida[0]' ";
                        }
                    }
                    $busqueda .= " ) ";

                    break;
                case "1":
                    $busqueda = " licencia like '%$busqueda%' ";
                    break;
                case "2":
                    $busqueda = " asunto like '%$busqueda%' ";
                    break;
            }
        }
        if (($fecha !== "" || $ver !== "") && $busqueda != "") {
            $busqueda = " and " . $busqueda;
        }
//usuario
        $user = "";

        if ($usuario != "") {
            $buscar_id_usuario = "select id_usuario from usuario where nombre='$usuario'";
            $usuario = $this->conexion->query($buscar_id_usuario);
            $usuario = mysqli_fetch_array($usuario);
            if ($usuario[0] != "") {
                $user .= " id_usuario='$usuario[0]' ";
                if ($fecha !== "" || $ver !== "" || $busqueda != "") {
                    $user = " and " . $user;
                }
            } else {
                echo "Usuario no existente";
                $user = "";
            }
        }

        if (!($fecha !== "" || $ver !== "" || $busqueda != "" || $user !== "")) {
            $sql .= " 1";
        }

        $limite = " LIMIT " . 30 * ($paginacion - 1) . "," . 30 * $paginacion;
//echo $sql . $ver . $fecha . $busqueda . $user . $orden . $limite;

        return $this->conexion->query($sql . $ver . $fecha . $busqueda . $user . $orden . $limite);
    }

    public function paginacion_tickets($busqueda, $tipo, $orden, $ver, $antes_de, $despues_de, $paginacion, $usuario) {
        $sql = "select count(*) from ticket where ";

        switch ($orden) {
            case "0":
                $orden = " ORDER BY asunto asc ";
                break;
            case "1":
                $orden = " ORDER BY asunto desc ";
                break;
            case "2":
                $orden = " ORDER BY momento_creacion desc ";
                break;
            case "3":
                $orden = " ORDER BY momento_creacion asc ";
                break;
        }

        switch ($ver) {
            case "001":
                $ver = " estado='cerrado' ";
                break;
            case "010":
                $ver = " estado='abierto' ";
                break;
            case "011":
                $ver = " (estado='cerrado' or estado='abierto') ";
                break;
            case "100":
                $ver = " estado='resuelto' ";
                break;
            case "101":
                $ver = " (estado='cerrado' or estado='resuelto') ";
                break;
            case "110":
                $ver = " (estado='resuelto' or estado='abierto') ";
                break;
            case "111":
                $ver = "";
                break;
        }

        $fecha = "";

        if ($antes_de != "") {

            $fecha .= " (momento_creacion<'$antes_de' or momento_solucion<'$antes_de') ";
            if ($ver != "") {
                $fecha = " and " . $fecha;
            }
        }
        if ($despues_de != "") {
            if ($ver != "" || strlen($fecha) > 20) {
                $fecha .= " and ";
            }
            $fecha .= " (momento_creacion>'$despues_de' or momento_solucion>'$despues_de') ";
        }


//busqueda
        if ($busqueda != "") {
            switch ($tipo) {
                case "0":
                    $aux_array = preg_split("/ /", $busqueda);
//var_dump($aux_array);
                    $busqueda = " ( ";
                    for ($pene = 0; $pene < count($aux_array); $pene++) {
                        $sql_licencia = "select licencia from clientes where nombre_empresa like '%$aux_array[$pene]%'";
                        $resultado = $this->conexion->query($sql_licencia);
                        while ($corrida = mysqli_fetch_array($resultado)) {
                            if ($busqueda !== " ( ") {
                                $busqueda .= " or ";
                            }
                            $busqueda .= " licencia='$corrida[0]' ";
                        }
                    }
                    $busqueda .= " ) ";

                    break;
                case "1":
                    $busqueda = " licencia like '%$busqueda%' ";
                    break;
                case "2":
                    $busqueda = " asunto like '%$busqueda%' ";
                    break;
            }
        }
        if (($fecha !== "" || $ver !== "") && $busqueda != "") {
            $busqueda = " and " . $busqueda;
        }
//usuario
        $user = "";

        if ($usuario != "") {
            $buscar_id_usuario = "select id_usuario from usuario where nombre='$usuario'";
            $usuario = $this->conexion->query($buscar_id_usuario);
            $usuario = mysqli_fetch_array($usuario);
            if ($usuario[0] != "") {
                $user .= " id_usuario='$usuario[0]' ";
                if ($fecha !== "" || $ver !== "" || $busqueda != "") {
                    $user = " and " . $user;
                }
            } else {
                echo "Usuario no existente";
                $user = "";
            }
        }

        if (!($fecha !== "" || $ver !== "" || $busqueda != "" || $user !== "")) {
            $sql .= " 1";
        }

//echo $sql . $ver . $fecha . $busqueda . $user . $orden . $limite;
        return $this->conexion->query($sql . $ver . $fecha . $busqueda . $user . $orden);
    }

    public function pendientes_totales() {
        $sql = "SELECT count( * ) FROM `ticket` WHERE NOT estado = 'resuelto' and reprogramacion<'" . $this->formato_fecha() . "'";
        return mysqli_fetch_array($this->conexion->query($sql));
    }

    public function atendidos_dia() {
        $hoy = $this->formato_fecha();
        $hoy = preg_split("/ /", $hoy);

        $sql = "select count(*) from ticket where momento_solucion like '$hoy[0]%'";

        return mysqli_fetch_array($this->conexion->query($sql));
    }

    public function cantidad_reprogramados() {
        $sql = "select count(*) from ticket where not estado='resuelto' and reprogramacion>'" . $this->formato_fecha() . "'";

        return mysqli_fetch_array($this->conexion->query($sql));
    }

    public function tus_antendidos() {
        $hoy = $this->formato_fecha();
        $hoy = preg_split("/ /", $hoy);
        $sql = "select * from historial_tickets where momento_apertura like '" . $hoy[0] . "%' and id_usuario='" . $_SESSION['id_usuario'] . "'  order by momento_cierre desc";

        $resultado = $this->conexion->query($sql);
        $cantidad = 0;

        while ($corrida = mysqli_fetch_array($resultado)) {
            $sql = "select id_usuario from ticket where id_ticket='" . $corrida['id_ticket'] . "' and momento_solucion='" . $corrida['momento_cierre'] . "' and not momento_solucion='0000-00-00 00:00:00'";
            //echo "<br>$sql<br>";
            $resultado1 = $this->conexion->query($sql);
            if (mysqli_fetch_array($resultado1)) {
                $cantidad++;
            }
        }
        return $cantidad;
    }

    public function restar_fechas($fecha_creacion, $fecha_solucion) {
        $fecha_actual = $fecha_solucion;

        $anos = (int) $fecha_actual[3] - (int) $fecha_creacion[3];

        $meses = (int) ($fecha_actual[5] . $fecha_actual[6]) - (int) ($fecha_creacion[5] . $fecha_creacion[6]);

        $dias = (int) ($fecha_actual[8] . $fecha_actual[9]) - (int) ($fecha_creacion[8] . $fecha_creacion[9]);

        $horas = (int) ($fecha_actual[11] . $fecha_actual[12]) - (int) ($fecha_creacion[11] . $fecha_creacion[12]);
        /*         * ***************************************************** */
//creacion
        $fecha_creacion = preg_split("/-/", $fecha_creacion);

        $hora_creacion = preg_split("/ /", $fecha_creacion[2]);

        $hora_creacion = preg_split("/:/", $hora_creacion[1]);

        $aux = preg_split("/ /", $fecha_creacion[2]);

        $fecha_creacion[2] = $aux[0];

        $fecha_creacion[3] = $hora_creacion[0];

        $minuto_creacion = $hora_creacion[1];

//actual
        $fecha_actual = preg_split("/-/", $fecha_actual);

        $hora_actual = preg_split("/ /", $fecha_actual[2]);

        $hora_actual = preg_split("/:/", $hora_actual[1]);

        $aux = preg_split("/ /", $fecha_actual[2]);

        $fecha_actual[2] = $aux[0];

        $fecha_actual[3] = $hora_actual[0];

        $minuto_actual = $hora_actual[1];

//aqui la fecha ya esta con formato :)

        $anos = (int) $fecha_actual[0] - (int) $fecha_creacion[0];

        $meses = (int) $fecha_actual[1] - (int) $fecha_creacion[1];

        $dias = (int) $fecha_actual[2] - (int) $fecha_creacion[2];

        $horas = (int) $fecha_actual[3] - (int) $fecha_creacion[3];

        $minutos = (int) $minuto_actual - (int) $minuto_creacion;

        $horas_totales = $anos * (365 * 24) + $meses * (30 * 24) + $dias * (24) + $horas + $minutos / 60;

        return $horas_totales;
    }

    public function propiedades_cliente($licencia) {
        $sql = "select * from clientes where licencia='$licencia'";
        $resultado = $this->conexion->query($sql);

        $corrida = mysqli_fetch_array($resultado);

        return $corrida;
    }

    public function cambiar_telefono($id_telefono, $nombre, $telefono, $licencia) {
        if ($nombre == "" || $telefono == "") {
            $sql = "delete from telefonos where id_telefono='$id_telefono'";
            if ($this->conexion->query($sql)) {
                echo "Telefono borrado con exito";
//include "detalles_cliente.php";
            } else
                echo "Error al borrar el ticket";
        }
        else {
            $sql = "update telefonos set contacto='$nombre', id_usuario='" . $_SESSION['id_usuario'] . "', telefono='$telefono' where id_telefono='$id_telefono'";
            if ($this->conexion->query($sql)) {
                header("Location: detalles_cliente.php?licencia=$licencia");
            } else {
                echo "No se ha podido cambiar el telefono";
            }
        }
    }

    public function cambiar_propiedades_cliente($licencia, $nombre, $correo) {
        $sql = "select historial from clientes where licencia='$licencia'"; //sacar el historial anterior, para volverlo a usar

        $corrida = mysqli_fetch_array($this->conexion->query($sql))[0];

        $sql = "update clientes set id_usuario='" . $_SESSION['id_usuario'] . "', nombre_empresa='$nombre', correo='$correo', historial='$corrida <br> "
                . "<br> El usuario " . $this->usuario() . " ha modificado el cliente a las " . $this->formato_fecha()
                . "' where licencia='$licencia'";
        if ($this->conexion->query($sql)) {


            header("Location: detalles_cliente.php?licencia=$licencia");
        } else {
            echo "No se ha podido cambiar el cliente";
        }
//te quedaste en guardar en el historial el modificar el cliente, por nada Emilio del futuro ;)
//modificar historial y cambiar el campo id_usuario de la tabla clientes,
    }

    public function meter_comentario_cliente($licencia, $comentario) {
        $sql = "select licencia from clientes where licencia='$licencia'";
        if (mysqli_fetch_array($this->conexion->query($sql))[0] == $licencia && $licencia !== "") {
            $sql = "insert into comentario_cliente ( `id_usuario`, `licencia`, `comentario`) values ('" . $_SESSION['id_usuario'] . "', '$licencia', '$comentario')";
            if ($this->conexion->query($sql)) {
                return 1;
            } else
                return 0;
        }
        else {
            echo "Licencia no registrada <br>";
            exit;
        }
    }

    public function ver_comentarios_cliente($licencia) {
        $sql = "select id_usuario, comentario from comentario_cliente where licencia='$licencia'";
        return $this->conexion->query($sql);
    }

    public function historial_tickets_por_usuario($id_usuario, $despues, $antes) {
        $sql = "select * from historial_tickets where id_usuario='$id_usuario' and momento_apertura>'$despues' and momento_cierre<'$antes'";
        return $this->conexion->query($sql);
    }

    public function todos_los_usuarios() {
        $sql = "select * from usuario where 1";
        return $this->conexion->query($sql);
    }

    public function tiempo_libre_todos_usuarios($despues, $antes) {
        $usuarios = $this->todos_los_usuarios();
        $dias = ceil($this->restar_fechas($despues, $antes) / 24);
        $salida = array();
        while ($corrida_usuarios = mysqli_fetch_array($usuarios)) {
            array_push($salida, $corrida_usuarios['nombre']);
            for ($dias_recorridos = 0, $cantidad = 0, $horas = 0; $dias_recorridos <= $dias; $dias_recorridos++) {

                $dia_analizado = $this->tiempo_libre_usuario($corrida_usuarios['id_usuario'], preg_split("/ /", $this->restar_dias_a_fecha($antes, $dias_recorridos))[0]);
                $dias_recorridos++;
                if (count($dia_analizado) > 0) {
                    for ($pene = 0; $pene < count($dia_analizado); $pene++) {
                        if ($pene + 1 < count($dia_analizado)) {
                            $descanzo = $this->restar_fechas($dia_analizado[$pene][2], $dia_analizado[$pene + 1][1]);

                            if ($descanzo < 0) {
                                $descanzo = 0;
                            }
                            $horas += $descanzo;
                            $cantidad++;
                        }
                    }
                }
            }
            if ($cantidad == 0)
                $cantidad = .0001;
            array_push($salida, $horas / $cantidad);
        }
        return ($salida);
    }

    public function promedios_globales_usuarios($despues, $antes) {
        $usuarios_DB = $this->todos_los_usuarios();
        $datos = array();
        echo "<table><tr><td>Usuario</td><td>Promedio</td></tr>";
        while ($corrida_usuarios = mysqli_fetch_array($usuarios_DB)) {
            $tiempo = $this->promedio_usuario($corrida_usuarios['id_usuario'], $despues, $antes);
            echo "<tr><td>" . $corrida_usuarios['nombre'] . "</td><td>" . $tiempo . " </td></tr>";
            array_push($datos, $corrida_usuarios['nombre'], 60 * (int) preg_split("/:/", $tiempo)[0] + (int) preg_split("/:/", $tiempo)[1]);
        }
        echo "</table>";
        return $datos;
    }

    public function promedio_usuario($id_usuario, $despues_de, $antes_de) {
        $sql = "select * from historial_tickets where momento_cierre>'$despues_de' and momento_cierre<'$antes_de' and id_usuario='$id_usuario'";
        $tickets_atendidos = $this->conexion->query($sql);
        $cantidad = 0;
        $horas = 0;
        while ($corrida_tickets_atendidos = mysqli_fetch_array($tickets_atendidos)) {
            $sql = "select * from ticket where id_ticket='" . $corrida_tickets_atendidos['id_ticket'] . "'";
            if (mysqli_fetch_array($this->conexion->query($sql))['momento_solucion'] == $corrida_tickets_atendidos['momento_cierre']) {
                $horas += $this->restar_fechas($corrida_tickets_atendidos['momento_apertura'], $corrida_tickets_atendidos['momento_cierre']);
                $cantidad++;
            }
        }
        if ($cantidad !== 0) {
            return floor($horas / $cantidad) . ":" . floor((($horas / $cantidad) - floor($horas / $cantidad)) * 60);
        } else {
            return "0:00";
        }
    }

    public function promedio_global($antes, $despues) {

        $sql = "select momento_creacion, momento_solucion from ticket where momento_solucion>'$despues' and momento_solucion<'$antes'";

        $resultado = $this->conexion->query($sql);

        $horas = 0;

        $cantidad = 0;

        while ($corrida = mysqli_fetch_array($resultado)) {
            $cantidad++;
            $horas += $this->restar_fechas($corrida[0], $corrida[1]);
        }
        if ($cantidad !== 0) {
            $minutos = floor(($horas / $cantidad - floor($horas / $cantidad)) * 60);
            $horas = floor($horas / $cantidad);

            return $horas . ":" . $minutos;
        } else
            return "No hay tickets.";
    }

    public function eficiencia_usuarios($antes, $despues) {
        set_time_limit(0);

        $sql = "select nombre, id_usuario from usuario usuario where 1";
        $usuarios = $this->conexion->query($sql);
        $datos = array();
        echo "<table border=1>";
        while ($corrida_usuarios = mysqli_fetch_array($usuarios)) {
            $atentidos = 0;
            $resueltos = 0;
            $sql = "select momento_cierre, id_ticket from historial_tickets where id_usuario='" . $corrida_usuarios['id_usuario'] . "' and momento_cierre>'$despues' and momento_cierre<'$antes'";
            $orden = $this->conexion->query($sql);
            while ($corrida_tickets = mysqli_fetch_array($orden)) {
                $sql = "select momento_solucion from ticket where id_ticket='" . $corrida_tickets['id_ticket'] . "'";
                $ticket = $this->conexion->query($sql);
                if ($ticket = mysqli_fetch_array($ticket)) {
                    $atentidos++;
                    if ($corrida_tickets['momento_cierre'] == $ticket['momento_solucion']) {
                        $resueltos++;
                    }
                }
            }
            if ($atentidos == 0)
                $atentidos = 1;
            array_push($datos, $corrida_usuarios['nombre'], 100 * $resueltos / $atentidos);
            if ($atentidos !== 0) {
                echo "<tr>";
                echo "<td>" . $corrida_usuarios['nombre'] . "</td><td>" . floor($resueltos * 100 / $atentidos) . "%</td> <td> $resueltos de $atentidos</td>";
                echo "</tr>";
            } else {
                echo $corrida_usuarios['nombre'] . " no ha atendido tickets<br>";
            }
        }
        echo "</table>";

        return ($datos);
    }

    public function sacar_mes($el_mes) {
        switch ((int) $el_mes) {//$fecha[1]) {
            case 2:
                return 31;
                break;
            case 3:
                return 28;
                break;
            case 4:
                return 31;
                break;
            case 5:
                return 30;
                break;
            case 6:
                return 31;
                break;
            case 7:
                return 30;
                break;
            case 8:
                return 31;
                break;
            case 9:
                return 31;
                break;
            case 10:
                return 30;
                break;
            case 11:
                return 31;
                break;
            case 12:
                return 30;
                break;
            case 1:
                return 31;
                break;
        }
    }

    public function restar_dias_a_fecha($fecha, $dias) {
        $fecha = preg_split("/-/", $fecha);




        $ano = (int) $fecha[0];

        $mes = (int) $fecha[1];

        $dia = (int) preg_split("/ /", $fecha[2])[0];

        $horas_minutos_segundos = preg_split("/ /", $fecha[2])[1];

        $dia -= $dias;

        while ($dia <= 0) {

            $dia += $this->sacar_mes($fecha[1]);
            $mes--;
            if ($mes == 0) {
                $mes = 12;
                $ano--;
            }
            $fecha[1] = (string) $mes;
        }


        if ($mes < 10) {
            $mes = "0" . $mes;
        }
        if ($dia < 10) {
            $dia = "0" . $dia;
        }

        return $ano . "-" . $mes . "-" . $dia . " " . $horas_minutos_segundos;
    }

    public function restar_7_dias($fecha) {
        $fecha = preg_split("/-/", $fecha);

        switch ((int) $fecha[1]) {
            case 2:
                $dias_mes_anterior = 31;
                break;
            case 3:
                $dias_mes_anterior = 28;
                break;
            case 4:
                $dias_mes_anterior = 31;
                break;
            case 5:
                $dias_mes_anterior = 30;
                break;
            case 6:
                $dias_mes_anterior = 31;
                break;
            case 7:
                $dias_mes_anterior = 30;
                break;
            case 8:
                $dias_mes_anterior = 31;
                break;
            case 9:
                $dias_mes_anterior = 31;
                break;
            case 10:
                $dias_mes_anterior = 30;
                break;
            case 11:
                $dias_mes_anterior = 31;
                break;
            case 12:
                $dias_mes_anterior = 30;
                break;
            case 1:
                $dias_mes_anterior = 31;
                break;
        }
        $ano = (int) $fecha[0];

        $mes = (int) $fecha[1];

        $dia = (int) preg_split("/ /", $fecha[2])[0];

        $horas_minutos_segundos = preg_split("/ /", $fecha[2])[1];

        $dia -= 7;

        if ($dia <= 0) {
            $dia += $dias_mes_anterior;
            $mes--;
            if ($mes == 0) {
                $mes = 12;
                $ano--;
            }
        }
        return $ano . "-" . $mes . "-" . $dia . " " . $horas_minutos_segundos;
    }

    public function tiempo_libre_usuario($id_usuario, $dia) {
        /* $sql = "SELECT *
          FROM ticket
          INNER JOIN (
          SELECT max( momento_cierre ) AS maxmomento_solucion
          FROM historial_tickets
          WHERE id_usuario = '$id_usuario'
          AND momento_cierre LIKE '$dia%'
          ) AS pene ON pene.maxmomento_solucion = ticket.momento_solucion";

          $salida['maximo'] = mysqli_fetch_array($this->conexion->query($sql))['momento_solucion'];

          $sql = "SELECT *
          FROM ticket
          INNER JOIN (
          SELECT min( momento_cierre ) AS maxmomento_solucion
          FROM historial_tickets
          WHERE id_usuario = '$id_usuario'
          AND momento_cierre LIKE '$dia%'
          ) AS pene ON pene.maxmomento_solucion = ticket.momento_solucion";

          $salida['minimo'] = mysqli_fetch_array($this->conexion->query($sql))['momento_solucion'];
         */
        $tickets = $this->historial_tickets_por_usuario($id_usuario, $dia . " 00:00:00", $dia . " 23:59:59");
//echo "<table border=1><tr><td><center>Asunto</td><td><center>Apertura</td><td><center>Cierre</td></tr>";
        $cantidad = 0;
        $salida = array();
        while ($corrida_tickets = mysqli_fetch_array($tickets)) {
            $propiedades_ticket = $this->propiedades_ticket($corrida_tickets['id_ticket']); //ya esta liberado
            if ($propiedades_ticket['momento_solucion'] == $corrida_tickets['momento_cierre']) {
//echo "<tr><td>" . $propiedades_ticket['asunto'] . "</td><td>" . $corrida_tickets['momento_apertura'] . "</td><td>".$corrida_tickets['momento_cierre']."</td></tr>";
                $salida[$cantidad][0] = $propiedades_ticket['licencia'];
                $salida[$cantidad][1] = $corrida_tickets['momento_apertura'];
                $salida[$cantidad][2] = $corrida_tickets['momento_cierre'];
                $cantidad++;
            }
        }
//echo "</table>";
        return ($salida);
    }

    public function imprimir_categorias() {
        $sql = "select distinct(categoria) from errores where estado='1'";
        $resultado = $this->conexion->query($sql);
        while ($corrida = mysqli_fetch_array($resultado)) {
            echo "<input type='radio' name='categoria' value='$corrida[0]' checked>" . $corrida[0] . "<br>";
        }
    }

    public function sacar_errores() {
        $sql = "select id_error, nombre from errores where estado='1'";
        return $this->conexion->query($sql);
    }

    public function registrar_error($nombre, $categoria) {
        $sql = "insert into errores ( estado, id_usuario, momento_creacion, nombre, categoria) values ( '0', '" .
                $_SESSION['id_usuario'] . "', '" . $this->formato_fecha() . "', '$nombre', '$categoria')";
        if ($this->conexion->query($sql)) {
            return "Guardado, solo falta que se apruebe.";
        } else
            return "No guardado, intente de nuevo en unos momentos.";
    }

    public function meter_solucion($nombre, $comentario, $id_error) {
        $sql = "insert into soluciones (nombre, id_error, id_usuario, comentario, estado, momento_creacion) values"
                . " ('$nombre','$id_error','" . $_SESSION['id_usuario'] . "','$comentario','0','" . $this->formato_fecha() . "')";

        if ($this->conexion->query($sql)) {
            return "Guardado, solo falta que se apruebe.";
        } else
            return "No guardado, intente de nuevo en unos momentos.";
    }

    public function pendientes_confirmar() {
        $sql = "select count(*) from errores where estado='0'";
        $numero = mysqli_fetch_array($this->conexion->query($sql))[0];
        $sql = "select count(*) from soluciones where estado='0'";
        $numero += mysqli_fetch_array($this->conexion->query($sql))[0];


//ver si tiene privilegio
        $sql = "select privilegios from usuario where id_usuario='" . $_SESSION['id_usuario'] . "'";
        $resultado = mysqli_fetch_array($this->conexion->query($sql));
        //echo $sql."<br>";
        if ($resultado['privilegios'][8] !== "1") {
            return "";
        }

        return $numero;
    }

    public function consulta_por_aprobar() {
        $salida = array();
        $sql = "select id_solucion, nombre, comentario, id_usuario from soluciones where estado='0'";
        $resultado = $this->conexion->query($sql);
        while ($corrida = mysqli_fetch_array($resultado)) {
            array_push($salida, $corrida);
        }
        array_push($salida, "pene");
        $sql = "select id_error, nombre, categoria, id_usuario from errores where estado='0'";
        $resultado = $this->conexion->query($sql);
        while ($corrida = mysqli_fetch_array($resultado)) {
            array_push($salida, $corrida);
        }

        return $salida;
    }

    public function categorias_errores() {
        $sql = "select distinct(categoria) from errores where estado='1'";
        return $this->conexion->query($sql);
    }

    public function aprobar_desaprobar() {
        $_GET = array_reverse($_GET);
        //var_dump($_GET);
        $accion = (string) key($_GET);
        foreach ($_GET as $aux) {

            switch ($accion[0]) {
                case "a"://accion
                    if ($_GET['accion'] == "Aprobar") {
                        echo "Se aprobaron.";
                        $aprobar = 1;
                    } else {
                        echo "No se aprobaron.";
                        $aprobar = 2;
                    }
                    echo "<br>";
                    break;
                case "c"://categoria
                    $categoria = $_GET[$accion];
                    break;
                case "s"://solucion
                    echo "Modificar solución $_GET[$accion]<br>";
                    $sql = "update soluciones set estado='$aprobar' where id_solucion='" . $_GET[$accion] . "'";
                    $this->conexion->query($sql);
                    break;
                case "e"://error
                    echo "Modificar error $_GET[$accion]<br>";
                    $sql = "update errores set estado='$aprobar', categoria='$categoria' where id_error='" . $_GET[$accion] . "'";
                    $this->conexion->query($sql);
                    break;
            }




            //echo key($_GET)."______".$aux . "<br>";
            $accion = (string) key($_GET);
            next($_GET);
        }
    }

    public function errrores_por_categoria($categoria) {
        $sql = "select id_error, nombre from errores where estado='1' and categoria='$categoria'";
        return $this->conexion->query($sql);
    }

    public function soluciones_por_error($error) {
        $sql = "select id_solucion, nombre from soluciones where estado='1' and id_error='$error'";
        return $this->conexion->query($sql);
    }

    public function propiedades_solucion($id_solucion) {
        $sql = "select * from soluciones where id_solucion='$id_solucion'";
        return $this->conexion->query($sql);
    }

    public function buscar_errores_soluciones($buscar) {
        $busqueda = preg_split("/ /", $buscar);
        //var_dump($busqueda);
        $primero = 0;
        $sintaxis = "";
        foreach ($busqueda as $aux) {
            if (strlen($aux) > 3) {
                if ($primero == 0) {
                    $primero++;
                } else {
                    $sintaxis .= " and ";
                }
                $sintaxis .= " nombre like '%$aux%' ";
            }
        }
        if ($sintaxis == "") {
            echo "No hay resultados";
            exit;
        }
        $sql = "select id_error, nombre from errores where " . $sintaxis;
        return $this->conexion->query($sql);
    }

    public function ultima_conexion() {
        $sql = "update usuario set ultima_conexion='" . $this->formato_fecha() . "' where id_usuario='" . $_SESSION['id_usuario'] . "'";
        $this->conexion->query($sql);
    }

    public function cerrado_tickets_automatico() {
        $momento = $this->formato_fecha();
        $momento = preg_split("/ /", $momento)[0] . " " . ((int) preg_split("/:/", preg_split("/ /", $momento)[1])[0] - 2) . ":" . preg_split("/:/", preg_split("/ /", $momento)[1])[1] . ":" . preg_split("/:/", preg_split("/ /", $momento)[1])[2];
        $sql = "select id_usuario from usuario where ultima_conexion<'$momento'";

        $usuarios = $this->conexion->query($sql);

        while ($corrida_usuarios = mysqli_fetch_array($usuarios)) {
            $sql = "select id_ticket from historial_tickets where momento_cierre='0000-00-00 00:00:00' and id_usuario='" . $corrida_usuarios['id_usuario'] . "'";
            $tickets = $this->conexion->query($sql);


            while ($corrida_tickets = mysqli_fetch_array($tickets)) {
                $sql = "select id_historial_ticket, comentario from historial_tickets where id_ticket='" . $corrida_tickets['id_ticket'] . "' and momento_cierre='0000-00-00 00:00:00'";

                $historial = $this->conexion->query($sql);
                $corrida_historial = mysqli_fetch_array($historial);

                $comentario = $corrida_historial['comentario'] . "<br>" . $this->formato_fecha() . ">>>El sistema ha cerrado el ticket<br>---------------";

                $sql = "update ticket set estado='abierto' where id_ticket='" . $corrida_tickets['id_ticket'] . "'";

                if ($this->conexion->query($sql)) {
                    $sql = "update historial_tickets set momento_cierre='" . $this->formato_fecha() . "', comentario='$comentario' where id_historial_ticket='" . $corrida_historial['id_historial_ticket'] . "'";

                    $this->conexion->query($sql);
                }
            }
        }
    }

    public function tickets_reprogramados() {
        $sql = "select * from ticket where reprogramacion>'" . $this->formato_fecha() . "'";

        return $this->conexion->query($sql);
    }

    public function enviar_correo($licencia) {
        return mysqli_fetch_array($this->conexion->query("select correo from clientes where licencia='$licencia'"))['correo'];
    }

}
