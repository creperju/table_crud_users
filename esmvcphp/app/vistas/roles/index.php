<div>
	<h3>Listado de roles</h3>
	
	<table border='1'>
		<thead>
			<tr>
				<th>Rol</th>
				<th>Descripcion</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($datos['filas'] as $fila)
			{
				echo "
					<tr>
						<td>{$fila['rol']}</td>
						<td>{$fila['descripcion']}</td>
						<td>
					".\core\HTML_Tag::a_boton("boton", array("roles", "form_modificar", $fila['id']), "Modificar")
//							<a class='boton' href='?menu={$datos['controlador_clase']}&submenu=form_modificar&id={$fila['id']}' >modificar</a>
					.\core\HTML_Tag::a_boton("boton", array("roles", "form_borrar", $fila['id']), "Borrar").
					\core\HTML_Tag::a_boton("boton", array("roles_permisos", "index", $fila['rol']), "Permisos&nbsp;asignados").
						"</td>
					</tr>
					";
			}
			echo "
				<tr>
					<td colspan='2'></td>
						<td>"
			.\core\HTML_Tag::a_boton("boton", array("roles", "form_insertar"), "Insertar").
					"</td>
				</tr>
			";
			?>
		</tbody>
	</table>
</div>