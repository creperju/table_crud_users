<?php
namespace core;

/**
 * Clase en la que se estudia el requerimiento y se carga el controlador que lo atenderá.
 * 
 * @author Jesús María de Quevedo Tomé <jequeto@gmail.com>
 * @since 2013-01-30
 * @updated 2014/01/17
 */
class Distribuidor {

	private static $depuracion = false;

	private static $controlador_instanciado = null;
	private static $metodo_invocado = null;
	
	
	/**
	 * Realiza el estudio del requerimiento http recibido y elige el 
	 * controlador y método que se ejecutará para atenderla.
	 * Solo debe invocarse desde la clase aplicación.
	 * Para ejecutar un controlador desde otro controlador (forwarding) debe
	 * usarse el método cargar_controlador() de esta clase.
	 * 
	 * @author Jesús Mª de Quevedo
	 */
	public static function estudiar_query_string() {
		
		if (self::control_tiempos_sesion()) {
			
			$controlador = isset($_GET['menu']) ? \core\HTTP_Requerimiento::get('menu') : \core\HTTP_Requerimiento::get('p1');
			$metodo = isset($_GET['submenu']) ? \core\HTTP_Requerimiento::get('submenu'): \core\HTTP_Requerimiento::get('p2');		

			if ( $controlador  == null || (boolean)\core\Validaciones::errores_identificador($controlador) )
				$controlador = strtolower(\core\Configuracion::$controlador_por_defecto);
			if ( ! $metodo || (boolean)\core\Validaciones::errores_identificador($metodo) )
				$metodo = strtolower(\core\Configuracion::$metodo_por_defecto);

			self::cargar_controlador($controlador, $metodo);
		}
		
	}
	
	
	
	
	
	/**
	 * 
	 * @return boolean True si el usuario está dentro de los límites de tiempos para la sesión definidos en la configuración.
	 */
	private static function control_tiempos_sesion() {
		
		// Comprobamos si está inactivo
		if (\core\Usuario::$login != "anonimo" && \core\Configuracion::$sesion_minutos_inactividad) {
			if (\core\Usuario::$sesion_segundos_inactividad > \core\Configuracion::$sesion_minutos_inactividad * 60) {
				$datos["mensaje"] = "Has superado el tiempo de inactividad que es de <b>".\core\Configuracion::$sesion_minutos_inactividad."</b> minutos.<br/>"
						. "Para continuar debes volver a loguearte.";
				$_SESSION["alerta"] = $datos["mensaje"];
				$datos["url_continuar"] = \core\URL::generar("usuarios/form_login");
				\core\Usuario::nuevo("anonimo");
				self::cargar_controlador("mensajes", "mensaje", $datos);
				return false;
			}
		}
		
		// Comprobamos el tiempo de duración de la sesión
		if (\core\Usuario::$login != "anonimo" && \core\Configuracion::$sesion_minutos_maxima_duracion) {
			if (\core\Usuario::$sesion_segundos_duracion > \core\Configuracion::$sesion_minutos_maxima_duracion * 60) {
				$datos["mensaje"] = "Has superado el tiempo máximo de duración de la sesión que es de <b>".\core\Configuracion::$sesion_minutos_maxima_duracion."</b> minutos.<br/>"
						. "Para continuar debes volver a loguearte.";
				$_SESSION["alerta"] = $datos["mensaje"];
				$datos["url_continuar"] = \core\URL::generar("usuarios/form_login");
				\core\Usuario::nuevo("anonimo");
				self::cargar_controlador("mensajes", "mensaje", $datos);
				return false;
			}
		}
		
		return true;
		
	}

	
	
	/**
	 * Carga la clase controladora indicada en los parámetros y ejecuta el método de esa clase pasado en los parámetros. Al método se le pasa el array
	 * de datos pasado como parámetro.
	 * 
	 * @param string $controlador Clase controladora a instanciar
	 * @param string $metodo Método a ejecutar
	 * @param array $datos Datos para el método
	 */
	public static function cargar_controlador($controlador, $metodo="index", array $datos = array()) {
		
		$metodo = ($metodo ? $metodo : "index"); // Asignamos el método por defecto

		// Comprobamos que el usuario tiene permisos. Si no los tiene se redirige hacia otro controlador.
		if (\core\Configuracion::$usuarios
				and \core\Configuracion::$control_acceso_recursos
				and \core\Usuario::tiene_permiso($controlador, $metodo) === false ) {
			if (\core\Usuario::$login == 'anonimo') {
				if (self::$depuracion) {
					echo "usuario anónimo sin permisos para ($controlador, $metodo)";
				}
				$controlador = 'usuarios';
				$metodo = 'form_login';
			}
			else {
				$datos['mensaje'] = "No tienes permisos para esta opción [$controlador][$metodo].";
				$controlador = 'mensajes';
				$metodo = 'index';
			}
		}
		
		return self::cargar_controlador_sin_chequear($controlador, $metodo, $datos);
		
	}
	
	
	/**
	 * Carga un controlador sin chequear los permisos del usuario.
	 * 
	 * @param type $controlador
	 * @param type $metodo
	 * @param array $datos
	 * @return type
	 */
	public static function cargar_controlador_sin_chequear($controlador, $metodo="index", array $datos = array()) {
		if (self::$depuracion) {
			echo("($controlador,$metodo) "); echo(self::$controlador_instanciado); echo(self::$metodo_invocado);echo(__METHOD__.__LINE__."<br />");
		}
		
		$metodo = ($metodo ? $metodo : "index"); // Asignamos el método por defecto
		
		$fichero_controlador = strtolower(PATH_APP."controladores".DS."$controlador.php");
		$controlador_clase = strtolower("\\controladores\\$controlador");

		// Buscamos que el controlador exista en la aplicación o en el framework esmvcphp
		$existe_fichero = false;
		foreach (\core\Autoloader::get_applications() as $application => $activated) {
			if ( $existe_fichero = file_exists(strtolower(PATH_ROOT.$application.DS."app".DS."controladores".DS."$controlador.php"))) {
				break;
			}
		}
		
		
		if ($existe_fichero) {		
			\core\Aplicacion::$controlador = new $controlador_clase();
			// Memorizamos el nombre del controlador para reutilizarlo en formularios
			self::$controlador_instanciado = strtolower($controlador);		
			\core\Aplicacion::$controlador->datos['controlador_clase'] = self::$controlador_instanciado;
		
			if (method_exists(\core\Aplicacion::$controlador, $metodo)) {
				// Memorizamos el nombre del método para reutilizarlo en formularios
				self::$metodo_invocado = strtolower($metodo);
				\core\Aplicacion::$controlador->datos['controlador_metodo'] = self::$metodo_invocado;

				// Ejecutamos el método y le pasamos los datos que vendrían de un forwarding
				\controladores\sendero::insert($controlador, $metodo, \core\URL::actual());
				return \core\Aplicacion::$controlador->$metodo($datos);
				
			}
			else {
				$datos['mensaje'] = "El método <b>$metodo</b> no está definido en la clase <b>$controlador_clase</b> (.php).";
				return self::ejecutar("errores", "error_404", $datos);
			}
		}
		else {
			
			
			$datos['mensaje'] = "<h2>Error</h2>La clase <b>$controlador_clase</b> no existe.";
			return self::ejecutar("errores", "error_404", $datos);
		}
	}
	
	
	
	/**
	 * Ejecuta una clase y un método de la clase.
	 * Si en $clase no se aporta namespace, se entenderá que es un controlador,
	 * es decir, una clase de la carpeta controladores.
	 * 
	 * El distribuidor no registra la ejecución de este controlador y método
	 * 
	 * @param string $clase
	 * @param string $metodo
	 * @param array $datos
	 * @return mixed El retorno del método ejecutado
	 */
	public static function ejecutar($clase, $metodo = "index", array $datos = array()) {
		$clase_instanciada = $clase;
		if ( ! preg_match("/((\\\)\w+)+/i", $clase)) {
			$clase_instanciada = "\\controladores\\$clase";
		}
		$objeto = new $clase_instanciada();
		$objeto->datos["controlador_clase"] = $clase;
		$objeto->datos["controlador_metodo"] =$metodo;
		return $objeto->$metodo($datos);
//		return ((new $clase())->$metodo($datos)); // Equivale a las dos lineas anteriores.
		
	}
	
	/**
	 * Es equivalente al método ejecutar.
	 * 
	 * @help ejecutar
	 */
	public static function incluir($clase, $metodo = "index", array $datos = array()) {
		
		return self::ejecutar($clase, $metodo, $datos);
		
	}
	
	
	/**
	 * Es equivalente al método ejecutar.
	 * 
	 * @help ejecutar
	 */
	public static function forward($clase, $metodo = "index", array $datos = array()) {
		
		return self::ejecutar($clase, $metodo, $datos);
		
	}
	
	
	public static function get_controlador_instanciado() {
		
		return self::$controlador_instanciado;
		
	}
	
	
	public static function get_metodo_invocado() {
		
		return self::$metodo_invocado;
		
	}
	
	
} // Fin de la clase