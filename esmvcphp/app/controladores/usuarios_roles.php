<?php
namespace controladores;

class usuarios_roles extends \core\Controlador {

	
	
	/**
	 * Presenta una <table> con las filas de la tabla con igual nombre que la clase.
	 * @param array $datos
	 */
	public function index(array $datos=array()) {
		
		$validaciones=array(
			"id" => "errores_requerido && errores_identificador && errores_referencia:id/usuarios/login"
		);
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			$datos['mensaje'] = 'Datos erróneos para identificar el usuario a consultar';
//			 var_dump($_REQUEST); var_dump($datos); exit();
			\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
			return;
		}
		else {
			
	
			if ( ! $filas = \modelos\usuarios_roles::recuperar($datos["values"]["id"])) {
				$datos['mensaje'] = 'Error al recuperar la fila de la base de datos';
				\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else {
				$datos["login"] = $datos["values"]["id"];
				$datos['filas'] = $filas;
			}
		}
		
		$datos['view_content'] = \core\Vista::generar("index", $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}
	
	
	

	
	
	
	/**
	 * Recibe un formulario con múltiples input tipo checkbox
	 * 
	 * @param array $datos
	 */
	public function form_modificar_validar(array $datos=array()) {	
		
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request(\modelos\usuarios_roles::$validaciones_update, $datos)) {
			
            $datos["mensaje"] = "Imposible identificar el rol al que modificar los permios.";
			
		}
		else {

			\modelos\Modelo_SQL::start_transaction();
			$clausulas["where"] = " login = '{$datos["values"]["login"]}' ";
			if ( ! $validacion = \modelos\Modelo_SQL::table("usuarios_roles")->delete($clausulas)) {
					
				$datos["mensaje"] = "No se han podido grabar la modificaciones en la bd.";				
				
			}
			else {
				$enrolamientos = \core\HTTP_Requerimiento::post();
				if ( ! $validacion = \modelos\usuarios_roles::modificar($datos["values"]["login"], $enrolamientos)) {
					$datos["mensaje"] = "No se han podido grabar la modificaciones en la bd.";
				}

			}
			if ($validacion) {
				\modelos\Modelo_SQL::commit_transaction();
			}
			else {
				\modelos\Modelo_SQL::rollback_transaction();
			}
		}

		if ( ! $validacion) //Devolvemos el formulario para que lo intente corregir de nuevo
			$this->cargar_controlador("mensajes", "mensaje", $datos);
		
		else {
			$_SESSION["alerta"] = "Se ha modificado correctamente los permisos del usuario";
			//header("Location: ".\core\URL::generar("roles/index"));
			\core\HTTP_Respuesta::set_header_line("location", \core\URL::generar("usuarios_roles/index/{$datos["values"]["login"]}"));
			\core\HTTP_Respuesta::enviar();
		}
		
	}

	
} // End of the class