<?php
namespace modelos;

class usuarios_permisos extends \modelos\Modelo_SQL {


	/* Rescritura de propiedades de validación */
	public static $validaciones_insert = array(
	);
	
	
	public static $validaciones_update = array(
		'login' => 'errores_requerido && errores_identificador && errores_referencia:login/usuarios/login',
	);
	

	public static $validaciones_delete = array(
		
	);
	
	
	public static function recuperar_permisos($login) {
		
		$sql = "
				select
					mt.controlador, mt.metodo, vupr.login, vupr.rol
					from ".self::get_prefix_tabla("metodos")." mt left join ".self::get_prefix_tabla("v_usuarios_permisos_roles")." vupr on mt.controlador=vupr.controlador and mt.metodo = vupr.metodo and vupr.login = '$login'
order by mt.controlador,mt.metodo
					";
		return(\modelos\Datos_SQL::execute($sql));
		
	}


	public static function modificar_permisos($login, $permisos = array()) {

		$validacion = true;
		
		foreach ($permisos as $key => $value) {
			if (preg_match("/^permiso/i", $key)) {
				$partes = explode(",", trim($value));
				$validacion = self::insert(array("login" => $login, "controlador" => $partes[0], "metodo" => $partes[1]), "usuarios_permisos");	
			}
			if ( ! $validacion) {
				break;
			}
		}
		
		
		return $validacion;
		
	}
	
}