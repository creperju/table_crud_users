
<form method='post' name='<?php echo \core\Array_Datos::contenido("form_name", $datos); ?>' action="?menu=<?php echo \core\Distribuidor::get_controlador_instanciado(); ?>&submenu=<?php echo \core\Distribuidor::get_metodo_invocado(); ?>_validar" >
	
	<?php echo \core\HTML_Tag::form_registrar($datos["form_name"], "post"); ?>
	
	<input id='id' name='id' type='hidden' value='<?php echo \core\Array_Datos::values('id', $datos); ?>' />
	Rol: <input id='rol' name='rol' type='text' size='30'  maxlength='30' value='<?php echo \core\Array_Datos::values('rol', $datos); ?>'/>
	<?php echo \core\HTML_Tag::span_error('rol', $datos); ?>
	<br />
	Descripcion:<br />
	<textarea id='descripcion' name='descripcion' type='textarea' cols='100'  rows='10' ><?php echo \core\Array_Datos::values('descripcion', $datos); ?></textarea>
	<?php echo \core\HTML_Tag::span_error('descripcion', $datos); ?>

	<br />
	<?php echo \core\HTML_Tag::span_error('errores_validacion', $datos); ?>
	
	<input type='submit' value='Enviar'/>
	<input type='reset' value='Limpiar'/>
	<button type='button' onclick='location.assign("<?php echo\core\URL::generar("roles/index"); ?>");'>Cancelar</button>
</form>
