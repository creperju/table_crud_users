<?php
namespace controladores;


/**
 * Muestra la vista 'Inicio' de la aplicación web.
 * 
 * @author Emilio Crespo Perán
 * @since 28/01/2014
 */
class inicio extends \core\Controlador {
	
    
        /**
         * Carga el archivo 'index.php' contenido en la carpeta vista/inicio
         * con una breve descripción del ejercicio.
         * 
         * @param array $datos
         */
	public function index(array $datos = array()) {
		
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos, true);
	    
		$http_body = \core\Vista_Plantilla::generar('plantilla_principal',$datos);
                
             
                
		\core\HTTP_Respuesta::enviar($http_body);
		
	}
	
	
} // Fin de la clase