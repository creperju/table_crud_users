<div>
	<h1>Listado de métodos (controlador, método)</h1>
	
	<table border='1'>
		<thead>
			<tr>
				<th>controlador</th>
				<th>metodo</th>
				<th>acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($datos['filas'] as $fila)
			{
				echo "
					<tr>
						<td>{$fila["controlador"]}</td>
						<td>{$fila["metodo"]}</td>
						<td>
					".\core\HTML_Tag::a_boton("boton", array("metodos", "form_modificar", $fila['id']), "modificar")
					.\core\HTML_Tag::a_boton("boton", array("metodos", "form_borrar", $fila['id']), "borrar").
					\core\HTML_Tag::a_boton("boton", array("usuarios_permisos", "poseedores", $fila["controlador"], $fila["metodo"]), "usuarios otorgados").
						"</td>
					</tr>
					";
			}
			echo "
				<tr>
					<td colspan='2'></td>
						<td>"
			.\core\HTML_Tag::a_boton("boton", array("metodos", "form_insertar"), "insertar").
					"</td>
				</tr>
			";
			?>
		</tbody>
	</table>
</div>