<style>
    .dropbtn {
        background-color: #ff9900;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {background-color: #ddd}

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    }
</style>
<body bgcolor="#d9d9d9">
<center>
    <div class="dropdown">
        <button class="dropbtn">Tickets</button>
        <div class="dropdown-content">
            <a href="historial_tickets.php" target="izquierda">Historial tickets.</a>
            <a href="crear_ticket.php" target="izquierda">Crear ticket.</a>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropbtn">Usuarios</button>
        <div class="dropdown-content">
            <a href="crear_usuario.php" target="izquierda">Crear usuario.</a>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropbtn">Clientes</button>
        <div class="dropdown-content">
            <a href="meter_comentario.php" target="izquierda">Comentar cliente.</a>
            <a href="crear_cliente.php" target="izquierda">Crear cliente.</a>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropbtn">Reportes</button>
        <div class="dropdown-content">
            <a href="reportes/reporte_rango.php" target="izquierda">Ver reportes.</a>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropbtn">Soluciones y errores</button>
        <div class="dropdown-content">
            <a href="../funciones/soluciones_errores/registrar_error.php" target="izquierda">Registrar Error.</a>
            <a href="../funciones/soluciones_errores/registrar_solucion.php" target="izquierda">Registrar Solución.</a>
            <a href="../funciones/soluciones_errores/consultar_solucionador/index.php" target="izquierda">Ayuda/Consultar.</a>
            <a href="../Manual de usuario Tickets.docx" download>Manual de usuario.</a>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropbtn">Tu perfil</button>
        <div class="dropdown-content">
            <a href="../funciones/validador_usuario.php" target="_top">Cerrar Sesión</a>
        </div>
    </div>
    <?php include '../funciones/tu_nombre.php'; ?>
</center>

<iframe style="border:none;" width="100%" height="90%" src="../imagenes/logo-dicom.jpg" name="izquierda">pene</iframe>

</body>