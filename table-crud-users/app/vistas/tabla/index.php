<form id='post_request_form' action='' method='post'>
        <input name='id' id='id' type='hidden' />
</form>

<div style="float: left;"><h3>Listado de juegos</h3></div>

<!-- SOLO LOS USUARIOS LOGUEADOS PUEDEN INSERTAR -->
<?php if(\core\Usuario::tiene_permiso("tabla", "form_insertar")): ?>
<div style="float: right; ">
        <h3><?php echo \core\HTML_Tag::a_boton("boton", array("tabla", "form_insertar"), "Añadir juego");?>
</h3>
    </div>
<?php endif; ?>



<table border="0" id="tabla" cellspacing="10">
    <tr>
        <th>T&iacute;tulo</th>
        <th>Plataforma</th>
        <th>Fabricante</th>
        <th>Fecha de lanzamiento</th>
        <th>Precio</th>
        <?php if(\core\Usuario::tiene_permiso("tabla", "*")):?>
            <th>Acciones</th>
        <?php endif; ?>
    </tr>
    <?php
    
        foreach($datos["filas"] as $fila){
            echo
            "<tr>
                <td>{$fila['titulo']}</td>
                <td>{$fila['plataforma']}</td>
                <td>{$fila['fabricante']}</td>
                <td>".\core\Conversiones::fecha_hora_mysql_a_es($fila['fecha_de_lanzamiento'])."</td>
                <td>€  ".\core\Conversiones::decimal_punto_a_coma($fila['precio'])."</td>
            ";
                if(\core\Usuario::tiene_permiso("tabla", "*"))
                    echo "<td>
                            ".\core\HTML_Tag::a_boton("boton", array("tabla", "form_modificar", $fila['id']), "Modificar")."<br/>"
                            .\core\HTML_Tag::a_boton("boton", array("tabla", "form_borrar", $fila['id']), "Borrar")."                    
                         </td>";
            echo "
            </tr>";
        }
        
    ?>
    
</table>
<?php 
    
    if(\core\Usuario::tiene_permiso("tabla", "form_insertar"))
            echo "<div style='text-align: center;'><h3>".\core\HTML_Tag::a_boton("boton", array("tabla", "form_insertar"), "Añadir juego")."</h3></div>";

?>

