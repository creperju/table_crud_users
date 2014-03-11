
<form method='post' name='<?php echo \core\Array_Datos::contenido("form_name", $datos); ?>' action="?menu=<?php echo \core\Distribuidor::get_controlador_instanciado(); ?>&submenu=form_modificar_validar" >
	
	<input id='login' name='login' type='hidden' value='<?php echo \core\Array_Datos::contenido('login', $datos); ?>' />
	<table class='resultados'>
		<tr>
			<th>Otorgado</th><th>Rol</th>
		</tr>
	<?php 
		$i = 0;
		
		foreach ($datos["filas"] as $fila) {
			$class = "";
			if ($fila["login"] && $fila["rol"]) {
				$checked = " checked='checked' disabled='disabled' ";
				$class = " ' ";
			}
			else {
				$checked = "";
			}
			echo "<tr $class ><td><input type='checkbox' $checked name='permiso$i' value='{$fila["rol"]}' /></td><td>{$fila["rol"]}</td></tr>";
			$i++;
		}
	?>
	</table> 

	<br />
	
	
	<input type='submit' value='Enviar'/>
	<input type='reset' value='Limpiar'/>
	<button type='button' onclick='location.assign("<?php echo\core\URL::generar("usuarios/index"); ?>");'>Cancelar</button>
</form>
