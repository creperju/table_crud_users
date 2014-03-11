<?php
namespace modelos;

class roles extends \modelos\Modelo_SQL {


	/* Rescritura de propiedades de validación */
	public static $validaciones_insert = array(
		'rol' => 'errores_requerido && errores_identificador && errores_unicidad_insertar:rol/roles/rol',
		"descripcion" => "errores_texto",
	);
	
	public static $validaciones_update = array(
		"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/roles/id",
		'rol' => 'errores_requerido && errores_identificador && errores_unicidad_modificar:id,rol/roles/id,rol',
		"descripcion" => "errores_texto",
	);
	

	
	public static $validaciones_delete = array(
		"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/roles/id"
	);
	
	
}