<?php
namespace modelos;

class usuarios_roles extends \modelos\Modelo_SQL {


	/* Rescritura de propiedades de validación */
	public static $validaciones_insert = array(
	);
	
	
	public static $validaciones_update = array(
		'login' => 'errores_requerido && errores_identificador && errores_referencia:login/usuarios/login',
	);
	

	public static $validaciones_delete = array(
		
	);
	
	
	public static function recuperar($login) {
		
		$sql = "
				select
					rl.rol, ur.login
					from ".self::get_prefix_tabla("roles")." rl left join ".self::get_prefix_tabla("usuarios_roles")." ur on rl.rol=ur.rol and ur.login = '$login'
order by rl.rol
					";
		return(\modelos\Datos_SQL::execute($sql));
		
	}


	public static function modificar($login, $permisos = array()) {

		$validacion = true;
		
		foreach ($permisos as $key => $value) {
			if (preg_match("/^permiso/i", $key)) {
				
				$validacion = self::insert(array("login" => $login, "rol" => $value));	
			}
			if ( ! $validacion) {
				break;
			}
		}
		
		
		return $validacion;
		
	}
	
}