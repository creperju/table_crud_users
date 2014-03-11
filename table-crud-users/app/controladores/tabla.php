<?php
namespace controladores;


 /**
 * Clase usada para altas, bajas y modificaciones de la tabla 'tc_juegos'
 * 
 * @author Emilio Crespo Perán
 * @since 28/01/2014
 */
class tabla extends \core\Controlador {

    
    
    /**
     * Muestra una tabla con los datos aportados por la tabla 'tc_juegos'
     * 
     * @param array $datos
     */
    function index(array $datos = array()) {
        
        $obj = new \modelos\Datos_SQL();
        $obj::table('juegos');
        

        $clausulas['order_by'] = 'titulo';

        $datos["filas"] = $obj->select($clausulas);
        
        $datos["view_content"] = \core\Vista::generar(__FUNCTION__, $datos, true);
        
        $html = \core\Vista_Plantilla::generar("plantilla_principal", $datos);
        //print_r($html);exit(0);
        \core\HTTP_Respuesta::enviar($html);
    }

    
    
    
    
    
    /**
     * Formulario para insertar una nueva fila en la tabla.
     * 
     * @param array $datos
     */
    function form_insertar(array $datos = array()) {

        $datos['form_name'] = __FUNCTION__;
        $datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
        $http_body = \core\Vista_Plantilla::generar('plantilla_principal', $datos);
        \core\HTTP_Respuesta::enviar($http_body);
    }

    
    
    
    
    
    
    /**
     * Modifica los datos de una fila.
     * 
     * @param array $datos
     * @return array $datos Aporta los datos de una fila a modificar
     */
    function form_modificar(array $datos = array()) {
		
	
        if ( ! count($datos)) { // Si no es un reenvío desde una validación fallida
                $validaciones=array(
                    "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/juegos/id"
                );
                // Coge el id de la fila a modificar en Validaciones
                if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos))
                        
                        return $this->cargar_controlador('errores', 'index');
                
                else {
                        // Seleccionara el id de la fila
                        $clausulas['where'] = $datos['values']['id'];
                       //var_dump($clausulas);
                        if ( ! $filas = \modelos\Datos_SQL::table("juegos")->select($clausulas)) {
                                return $this->cargar_controlador('errores', 'index');
                        }
                        else {
                                $datos['values'] = $filas[0];
                                
                                // Mostramos los datos que necesitan conversiones
                                $datos['values']['fecha_de_lanzamiento'] = \core\Conversiones::fecha_hora_mysql_a_es($datos['values']['fecha_de_lanzamiento']);
			$datos['values']['precio'] = \core\Conversiones::decimal_punto_a_coma($datos['values']['precio']);

                                $clausulas = array('order_by' => " titulo ");
                                $datos['categorias'] = \modelos\Datos_SQL::table("juegos")->select( $clausulas);
                        }
                }
        
                
                /*
        // Equivalente al código anterior, lo que hace es coger el ID directamente
        // y es un resumen, el anterio coge el id de la fila por Validaciones que también
        // lo recoge por $_POST/$_REQUEST
        $id = \core\HTTP_Requerimiento::post("id");
                 
	if ( ! $id )
		return $this->cargar_controlador('errores', 'index');
	else{
	    
		$clausulas['where'] = $id;
	    
	    if ( ! $filas = \modelos\Datos_SQL::table("juegos")->select($clausulas) )
			return $this->cargar_controlador('errores', 'index');
	    else{
		
			$datos['values'] = $filas[0];
			$datos['values']['fecha_de_lanzamiento'] = \core\Conversiones::fecha_hora_mysql_a_es($datos['values']['precio']);
			$datos['values']['precio'] = \core\Conversiones::decimal_punto_a_coma($datos['values']['precio']);
							
	    }*/
	    
	    
	}		
			
        // Envía el nombre del formulario
        $datos['form_name'] = __FUNCTION__;
        
        // Envía la respuesta con los datos aportados
        $datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
        $http_body = \core\Vista_Plantilla::generar('plantilla_principal', $datos);
        \core\HTTP_Respuesta::enviar($http_body);
        
    }
    
    
    
    

    
    /**
     * Carga los datos en el formulario para después borrarlos.
     * 
     * @param array $datos
     * @return array $datos Devuelve los datos que serán borrados.
     */
    function form_borrar(array $datos = array()) {

        
        
        if ( ! count($datos)) { // Si no es un reenvío desde una validación fallida
                $validaciones=array(
                    "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/juegos/id"
                );
                // Coge el id de la fila a modificar en Validaciones
                if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos))
                        
                        return $this->cargar_controlador('errores', 'index');
                
                else {
                        // Seleccionara el id de la fila
                        $clausulas['where'] = $datos['values']['id'];
                       //var_dump($clausulas);
                        if ( ! $filas = \modelos\Datos_SQL::table("juegos")->select($clausulas)) {
                                return $this->cargar_controlador('errores', 'index');
                        }
                        else {
                                $datos['values'] = $filas[0];
                                
                                // Mostramos los datos que necesitan conversiones
                                $datos['values']['fecha_de_lanzamiento'] = \core\Conversiones::fecha_hora_mysql_a_es($datos['values']['fecha_de_lanzamiento']);
			$datos['values']['precio'] = \core\Conversiones::decimal_punto_a_coma($datos['values']['precio']);

                                
                        }
                }
        }
        
        
        
        
        $datos['form_name'] = __FUNCTION__;
        $datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
        $http_body = \core\Vista_Plantilla::generar('plantilla_principal', $datos);
        \core\HTTP_Respuesta::enviar($http_body);
        
    }
    
    
    
    
    

    /**
     * Valida los datos aportados por form_insertar y los graba en la bd.
     * 
     * @param array $datos Trae los datos insertados del formulario y los valida.
     * @return array $datos Devuelve los datos del formulario si no han sido validados.
     */
    function form_insertar_validar(array $datos = array()) {



        $validaciones = array(
            "titulo" => "errores_requerido",
            "plataforma" => "errores_requerido",
            "fabricante" => "errores_requerido",
            "fecha_de_lanzamiento" => "errores_fecha_hora && errores_requerido",
            "precio" => "errores_precio && errores_requerido"
        );



        $validacion = !\core\Validaciones::errores_validacion_request($validaciones, $datos);

        if (!$validacion) {
            // print "-- Depuración: \$datos= "; print_r($datos);
            // Entra cuando hay errores y devuelve el formulario con los datos
            \core\Distribuidor::cargar_controlador("tabla", "form_insertar", $datos);
        } else {

            // Hacemos la conversión de la fecha a mysql y del precio
            $datos['values']['fecha_de_lanzamiento'] = \core\Conversiones::fecha_hora_es_a_mysql($datos['values']['fecha_de_lanzamiento']);
            $datos['values']['precio'] = \core\Conversiones::decimal_coma_a_punto($datos['values']['precio']);

            
            // Graba los datos en la tabla
            \modelos\Modelo_SQL::insert($datos['values'], 'juegos');


            \core\HTTP_Respuesta::set_header_line("location", \core\URL::generar("tabla"));
            \core\HTTP_Respuesta::enviar();
        }
    }
    
    
    
    

    /**
     * Formulario que valida los datos aportados por form_modificar.
     * 
     * @param array $datos
     * @return array $datos Devuelve los datos del formulario si no han sido validados.
     */
    function form_modificar_validar(array $datos = array()) {
        
        $validaciones = array(
            "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/juegos/id",
            "titulo" => "errores_requerido",
            "plataforma" => "errores_requerido",
            "fabricante" => "errores_requerido",
            "fecha_de_lanzamiento" => "errores_fecha_hora && errores_requerido",
            "precio" => "errores_precio && errores_requerido"
        );
        
        
        $validacion = !\core\Validaciones::errores_validacion_request($validaciones, $datos);

        if (!$validacion) {
            // print "-- Depuración: \$datos= "; print_r($datos);
            // Entra cuando hay errores y devuelve el formulario con los datos
            \core\Distribuidor::cargar_controlador("tabla", "form_modificar", $datos);
        } else {

            // Hacemos la conversión de la fecha a mysql y del precio
            $datos['values']['fecha_de_lanzamiento'] = \core\Conversiones::fecha_hora_es_a_mysql($datos['values']['fecha_de_lanzamiento']);
            $datos['values']['precio'] = \core\Conversiones::decimal_coma_a_punto($datos['values']['precio']);

            
            // Actualiza los datos
            \modelos\Datos_SQL::update($datos['values'], "juegos");

            // Redirige el formulario a la página tabla para evitar el reenvío del formulario
            \core\HTTP_Respuesta::set_header_line("location", \core\URL::generar("tabla"));
            \core\HTTP_Respuesta::enviar();
            
        }
        
    }

    
    
    
    
    
    
    /**
     * Borra los datos recogidos por el form_borrar.
     * 
     * @param array $datos
     */
    function form_borrar_validar(array $datos = array()) {

        // Recoge el ID de la fila a borrar, es el resumen de la validación
        // próxima en el que se recoge el ID de la fila por $_POST/$_REQUEST
        
//        $id_borrar = array("id" => $_POST['id']);
        
        
        
        $validaciones = array(
                "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/juegos/id"
        );
        
        
        if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
                
                return $this->cargar_controlador('errores', 'index', $datos);
              
        } else {
            
                // Borra los datos de la fila
                \modelos\Datos_SQL::delete($datos['values'], 'juegos');
            
           
                // Redirige el formulario a la página tabla para evitar el reenvío del formulario
                \core\HTTP_Respuesta::set_header_line("location", \core\URL::generar("tabla"));
                \core\HTTP_Respuesta::enviar();	
            
        }
        

    }
    
    
    
    
    

}
