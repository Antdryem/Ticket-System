<form action="../funciones/lista_tickets.php?paginacion=1" method="get" target="historial">
    Búsqueda:
    <input type="text" name="busqueda" value="" placeholder="busqueda">
    <br>    
    Buscar por: 
    <input type="radio" value="0" name="tipo_busqueda">=>Nombre empresa
    <input type="radio" value="1" name="tipo_busqueda">=>Licencia
    <input type="radio" value="2" name="tipo_busqueda" checked="">=>Asunto
    <br>
    Ordenar por:
    <input type="radio" value="0" name="tipo_orden">=>Alphabético
    <input type="radio" value="1" name="tipo_orden">=>Alphabético inverso
    <input type="radio" value="2" name="tipo_orden" checked="">=>Más nuevo
    <input type="radio" value="3" name="tipo_orden">=>Más antiguo
    <br>
    Ver:
    <input type="checkbox" value="1" name="resueltos" checked="">=>Resueltos
    <input type="checkbox" value="1" name="abiertos" checked="">=>Abiertos
    <input type="checkbox" value="1" name="cerrados" checked="">=>Cerrados
    <br>
    Después de:<input type="date" name="despues">
    Antes de:<input type="date" name="antes">
    <br>
    Creado por:<input type="text" name="usuario">
    
    
    <br><input type="submit" value="Buscar/filtrar">
</form> 
<iframe style="border:none;" src="../funciones/lista_tickets.php?paginacion=1" height="100%" width="100%" name="historial"></iframe> 