<?php
namespace core;
//require_once PATH_APP."core/clase_base.php";
//require_once PATH_APP."core/respuesta.php";


/**
 * Aplicación principal
 *
 * @author Jesús María de Quevedo Tomé <jequeto@gmail.com>
 * @since 20130130
 */
class Aplicacion extends \core\Clase_Base {
	
	/**
	 * Almacenará el objeto resultado de instanciar la clase Controlador que se encargará
	 * de atender la petición HTTP recibida.
	 * 
	 * @var \core\Controlador 
	 */
	public static $controlador;

	
	public function __construct() {
//	public static function iniciar() {

		
		if (\core\Configuracion::$display_errors) 
			ini_set("display_errors", "on");
		else
			ini_set("display_errors", "off");
		
		// Activamos o recuperamos el array $_SESSION
		// Debe estar siempre activo porque se usa para presentar mensajes al cliente
		// cuando carga una página.
		// También se usa para la gestión de usuarios (\core\Usuario) 
		// y para memorizar URL/URI (\core\URL) 
		\core\SESSION::iniciar();

		// Interpretar url amigable, pasa parmametros /dato1/dato2/dato3/ 
		// a parámetros $_GET[p1]=dato1 $_GET[p2]=dato2  $_GET[p3]=dato3 ....
		if (\core\Configuracion::$url_amigable) \core\Rutas::interpretar_url_amigable();
		
		if (\core\Configuracion::$use_db) \core\sgbd\bd::connect();
		
		
		
		
		if ( \core\Configuracion::$url_registrar_anterior) \core\URL::registrar();
		
			
		// Reconocer el usuario que ha iniciado la sesión de trabajo o que continúa dentro de una sesión de trabajo.
		if (\core\Configuracion::$usuarios) \core\Usuario::iniciar();
				
		// Los permisos los usamos si trabajamos con la ACL (Access Control List) para definir los permisos de los usuarios
		// \core\Permisos::iniciar();
		

		
		// Estudio del idioma, después de que la url amigable se pase a parámetros GET
		//if (\core\Configuracion::$idioma_sensibilidad) \core\Idioma::init();
                
                
		// Distribuidor
		\core\Distribuidor::estudiar_query_string();
                
                
		// Cerrar conexión a la base de datos
		if (\core\Configuracion::$use_db) \core\sgbd\bd::disconnect();	
		
	}
	
} // Fin de la clase