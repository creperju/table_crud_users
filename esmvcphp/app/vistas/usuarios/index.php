<div>
	<!-- formulario  post_reques_form utilizado para enviar peticiones por post al servidor y evitar que el usuario modifique/juegue con los parámetros modificando la URI mostrada  -->
	
	<h3>Listado de usuarios</h3>
	<table class='resultados' border='3' >
		<thead>
			<tr>
				<th>Login</th>
				<th>Email</th>
				<th>Fecha alta</th>
				<th>Fecha confirmación alta</th>
				<th>Clave confirmación</th>
				
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($datos['filas'] as $fila)
			{
				echo "
					<tr>
						<td>{$fila['login']}</td>
						<td>{$fila['email']}</td>
						<td>{$fila['fecha_alta']}</td>	
						<td>{$fila['fecha_confirmacion_alta']}</td>	
						<td>{$fila['clave_confirmacion']}</td>	
						<td><center>"
//							<a class='boton' onclick='submit_post_request_form(\"".\core\URL::generar("usuarios/form_modificar")."\", {$fila['id']});' >modificar</a>
							.\core\HTML_Tag::a_boton("boton", array("usuarios", "form_modificar", $fila['id']), "Modificar")."<br/>"
//							<a class='boton' onclick='submit_post_request_form(\"".\core\URL::generar("usuarios/form_borrar")."\", {$fila['id']});' >borrar</a>
							.\core\HTML_Tag::a_boton("boton", array("usuarios", "form_borrar", $fila['id']), "Borrar")."<br/>".
//							<a class='boton' onclick='submit_post_request_form(\"".\core\URL::generar("usuarios/form_cambiar_password")."\", {$fila['id']});' >modificar password</a>
							\core\HTML_Tag::a_boton("boton", array("usuarios_permisos", "index", $fila['login']), "Permisos&nbsp;asignados")."<br/>".
							\core\HTML_Tag::a_boton("boton", array("usuarios_roles", "index", $fila['login']), "Roles&nbsp;asignados").
						"</center></td>
					</tr>
					";
			}
			echo "
				<tr>
					<td colspan='5'></td>
                                        
						<td>".\core\HTML_Tag::a_boton("boton", array("usuarios", "form_insertar_interno"),"Insertar")."</td>
				</tr>
			";
			?>
		</tbody>
	</table>
	<!--<php print("<a style='text-align: center;' class='boton' href='{$datos["url_volver"]}'  >volver</a>"); 
                
        ?>-->
</div>