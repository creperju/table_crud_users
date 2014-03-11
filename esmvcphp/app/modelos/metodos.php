<?php
namespace modelos;

class metodos extends \modelos\Modelo_SQL {


	/* Rescritura de propiedades de validación */
	public static $validaciones_insert = array(
		'controlador' => 'errores_requerido && errores_identificador && errores_unicidad_insertar:controlador,metodo/metodos/controlador,metodo',
		'método' => 'errores_requerido && errores_identificador',
	);
	
	public static $validaciones_update = array(
		"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/metodos/id",
		'controlador' => 'errores_requerido && errores_identificador && errores_unicidad_insertar:controlador,metodo/metodos/controlador,metodo',
		'método' => 'errores_requerido && errores_identificador',
	);
	

	
	public static $validaciones_delete = array(
		"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/metodos/id"
	);
	
	
}