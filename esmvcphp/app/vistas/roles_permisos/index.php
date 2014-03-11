<div >
	<h3>Listado de permisos del rol <?php echo $datos["rol"]; ?></h3>
	<?php include "form_and_inputs.php"; ?>
	<script type='text/javascript'>
		$(" [type=checkbox] ").attr("disabled", "disabled");
		$(" [type=submit], [type=reset], [type=button] ").css("display", "none");
		
		function modificar_permisos() {
			$(" [type=checkbox] ").removeAttr("disabled");
			$(" [type=submit], [type=reset], [type=button], button#btn_checked_all ").css("display", "inline");
			$(" button#btn_modificar, button#btn_cancelar ").css("display", "none");
		}
		
		function chequear_todo() {
			$(" [type=checkbox] ").attr("checked", "checked");
			
		}
		
	</script>
	<button id='btn_cancelar'type='button' onclick='location.assign("<?php echo\core\URL::generar("roles/index"); ?>");'>Cancelar</button>
	<button id='btn_modificar' type='button' onclick='modificar_permisos();'>Modificar Permisos</button>
</div>