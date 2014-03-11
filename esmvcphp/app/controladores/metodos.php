<?php
namespace controladores;

class metodos extends \core\Controlador {

	
	
	/**
	 * Presenta una <table> con las filas de la tabla con igual nombre que la clase.
	 * @param array $datos
	 */
	public function index(array $datos=array()) {
		
		$clausulas['order_by'] = 'controlador, metodo';
		// Recupar todas las filas ordenadas según el orden definido
		$datos["filas"] = \modelos\Modelo_SQL::table("metodos")->select($clausulas); 
		
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}
	
	
	public function form_insertar(array $datos=array()) {
		
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}

	
	
	
	public function form_insertar_validar(array $datos=array()) {
		
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request(\modelos\metodos::$validaciones_insert, $datos))
            $datos["errores"]["errores_validacion"]="Corrige los errores.";
		else {
			
			if ( ! $validacion = \modelos\Modelo_SQL::insert($datos["values"], 'metodos')) // Devuelve true o false
				$datos["errores"]["errores_validacion"]="No se han podido grabar los datos en la bd.";
		}
		if ( ! $validacion) //Devolvemos el formulario para que lo intente corregir de nuevo
			\core\Distribuidor::cargar_controlador('metodos', 'form_insertar', $datos);
		else
		{
			// Se ha grabado la modificación. Devolvemos el control al la situacion anterior a la petición del form_modificar
			//$datos = array("alerta" => "Se han grabado correctamente los detalles");
			// Definir el controlador que responderá después de la inserción
			//\core\Distribuidor::cargar_controlador('metodos', 'index', $datos);
			$_SESSION["alerta"] = "Se ha realizado la inserción correctamente";
			//header("Location: ".\core\URL::generar("metodos/index"));
			\core\HTTP_Respuesta::set_header_line("location", \core\URL::generar("metodos/index"));
			\core\HTTP_Respuesta::enviar();
		}
	}

	
	
	public function form_modificar(array $datos = array()) {
		
		
		if ( ! isset($datos["errores"])) { // Si no es un reenvío desde una validación fallida
			$validaciones=array(
				"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/metodos/id"
			);
			if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
				$datos['mensaje'] = 'Datos erróneos para la el objeto.';
				\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else {
				$clausulas['where'] = " id = {$datos['values']['id']} ";
				if ( ! $filas = \modelos\Datos_SQL::select( $clausulas, 'metodos')) {
					$datos['mensaje'] = 'Error al recuperar la fila de la base de datos';
					\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
					return;
				}
				else {
					$datos['values'] = $filas[0];
					
				}
			}
		}
		
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
	}

	
	
	
	
	public function form_modificar_validar(array $datos=array()) {	
		
		
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request(\modelos \metodos::$validaciones_update, $datos)) {
			
            $datos["errores"]["errores_validacion"] = "Corrige los errores.";
		}
		else {
			
			if ( ! $validacion = \modelos\Datos_SQL::update($datos["values"], 'metodos')) // Devuelve true o false
					
				$datos["errores"]["errores_validacion"] = "No se han podido grabar los datos en la bd.";
				
		}
		if ( ! $validacion) //Devolvemos el formulario para que lo intente corregir de nuevo
			\core\Distribuidor::cargar_controlador('metodos', 'form_modificar', $datos);
		else {
			$_SESSION["alerta"] = "Se ha modificado correctamente el objeto.";
			\core\HTTP_Respuesta::set_header_line("location", \core\URL::generar("metodos/index"));
			\core\HTTP_Respuesta::enviar();
		}
		
	}

	
	
	public function form_borrar(array $datos=array()) {
		
		$validaciones=array(
			"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/metodos/id"
		);
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			$datos['mensaje'] = 'Datos erróneos para identificar el objeto a borrar';
			
			\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
			return;
		}
		else {
			$clausulas['where'] = " id = {$datos['values']['id']} ";
			if ( ! $filas = \modelos\Datos_SQL::select( $clausulas, 'metodos')) {
				$datos['mensaje'] = 'Error al recuperar la fila de la base de datos';
				\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else {
				$datos['values'] = $filas[0];
			}
		}
		
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar("DEFAULT", $datos);
		\core\HTTP_Respuesta::enviar($http_body);
	}

	
	
	
	
	
	public function form_borrar_validar(array $datos=array()) {	
		
		$validaciones=array(
			 "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/metodos/id"
		);
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			$datos['mensaje'] = 'Datos erróneos para identificar el objeto a borrar';
			\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
			return;
		}
		else
		{
			if ( ! $validacion = \modelos\Datos_SQL::delete($datos["values"], 'metodos')) {// Devuelve true o false
				$datos['mensaje'] = 'Error al borrar el objeto en la bd';
				\core\Distribuidor::cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else {
				$_SESSION["alerta"] = "Se ha borrado correctamente el objeto.";
				//header("Location: ".\core\URL::generar("metodos/index"));
				\core\HTTP_Respuesta::set_header_line("location", \core\URL::generar("metodos/index"));
				\core\HTTP_Respuesta::enviar();
			}
		}
		
	}
	
	
	
	
	
	
	
	
} // End of the class