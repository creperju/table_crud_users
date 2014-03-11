
<form method='post' name='<?php echo \core\Array_Datos::contenido("form_name", $datos); ?>' action="?menu=<?php echo \core\Distribuidor::get_controlador_instanciado(); ?>&submenu=form_modificar_validar" >
		
	<input id='rol' name='rol' type='hidden' value='<?php echo \core\Array_Datos::contenido('rol', $datos); ?>' />
	<button id='btn_checked_all' type='button' onclick='chequear_todo();'>Seleccionar todo</button><br />
	<?php 
		$i = 0;
		foreach ($datos["filas"] as $fila) {
			$checked = ($fila["rol"]) ? " checked='checked' " : "";
			echo "<input type='checkbox' $checked name='permiso$i' value='{$fila["controlador"]},{$fila["metodo"]}' /> {$fila["controlador"]}::{$fila["metodo"]}<br />\n";
			$i++;
		}
	?>
	 

	<br />
	
	
	<input type='submit' value='Enviar'/>
	<input type='reset' value='Limpiar'/>
	<button type='button' onclick='location.assign("<?php echo\core\URL::generar("roles/index"); ?>");'>Cancelar</button>
</form>
