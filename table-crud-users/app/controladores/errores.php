<?php
namespace controladores;


/**
 * Clase usada para mostrar cualquier error ocasionado en la aplicación.
 * 
 * @author Emilio Crespo Perán
 * @since 28/01/2014
 */
class errores extends \core\Controlador {
    
    
    /**
     * Su único contenido es el que se genera y muestra el texto 'Documento no encontrado'
     * 
     * @param array $datos
     */
    public function index(array $datos = array()){
	
	$datos['view_content'] = isset($datos['mensaje'])? $datos['mensaje']: "Documento no encontrado.";
	
        unset ($datos['mensaje']);
        
	$http_enviar_error = \core\Vista_Plantilla::generar("plantilla_principal", $datos, true);
	\core\HTTP_Respuesta::set_http_header_status("404");
	\core\HTTP_Respuesta::enviar($http_enviar_error);
	
    }
    
    public function error_404(array $datos = array()) {
		$this->index($datos);
//		$contenido = \core\Vista_Plantilla::generar("plantilla_errores", $datos);
//		\core\HTTP_Respuesta::set_http_header_status("404");
//		\core\HTTP_Respuesta::enviar($contenido);
				
	}
    
}