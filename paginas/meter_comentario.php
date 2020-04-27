
<form action="../funciones/clientes/metiendo_comentario.php" target="izquierda" method="GET">
    Licencia<br>
    <input name="licencia" type="text" value= "<?php
    if (isset($_GET['licencia'])) {
        echo $_GET['licencia'];
    } else {
        echo "";
    }
    ?>" >
    <br>
    Comentario
    <br>
    <textarea name="comentario" maxlength="250" placeholder="Max. 250 caracteres."></textarea>
    <br>
    <input type="submit" value="Comentar cliente">
</form>

