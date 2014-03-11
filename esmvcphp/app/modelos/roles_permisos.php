<?php
namespace modelos;

class roles_permisos extends \modelos\Modelo_SQL {


	/* Rescritura de propiedades de validación */
	public static $validaciones_insert = array(
	);
	
	
	public static $validaciones_update = array(
		'rol' => 'errores_requerido && errores_identificador && errores_referencia:rol/roles/rol',
	);
	

	public static $validaciones_delete = array(
		
	);
	
	
	public static function recuperar_permisos($rol) {
		
		$sql = "
				select
					mt.controlador, mt.metodo, rp.rol
					from ".self::get_prefix_tabla("metodos")." mt left join ".self::get_prefix_tabla("roles_permisos")." rp on mt.controlador=rp.controlador and mt.metodo = rp.metodo and rp.rol = '$rol'
order by mt.controlador,mt.metodo
					";
		return(\modelos\Datos_SQL::execute($sql));
		
	}


	public static function modificar_permisos($rol, $permisos = array()) {

		$validacion = true;
		
		foreach ($permisos as $key => $value) {
			if (preg_match("/^permiso/i", $key)) {
				$partes = explode(",", trim($value));
				$validacion = self::insert(array("rol" => $rol, "controlador" => $partes[0], "metodo" => $partes[1]), "roles_permisos");	
			}
			if ( ! $validacion) {
				break;
			}
		}
		
		return $validacion;
		
	}
	
}