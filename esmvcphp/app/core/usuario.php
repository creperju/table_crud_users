<?php
namespace core;

class Usuario extends \core\Clase_Base {
	
	private static $depuracion = false;
	
	public static $id;
	public static $login = 'anonimo';
	private static $permisos = array();
	
	/**
	 * lmacena la duración de la sesión en segundos desde el login del usuario.
	 * @var integer 
	 */
	public static $sesion_segundos_duracion = 0;
	
	/**
	 * Almacena el tiempo de inactividad desde la anterior petición al servidor.
	 * 
	 * @var integer 
	 */
	public static $sesion_segundos_inactividad = 0;
	
	/**
	 * Reconocer el usuario que ha iniciado la sesión de trabajo o que continúa dentro de una sesión de trabajo.
	 */
	public static function iniciar() {
		// Recuperamos datos desde $_SESSION a las propiedades de la clase
		if (isset($_SESSION['usuario']['login'])) {
			self::$login = $_SESSION['usuario']['login'];
			self::$id = $_SESSION['usuario']['id'];
			self::sesion_control_tiempos();	
		}
		else {
			self::nuevo('anonimo');
		}
		
		if (isset($_SESSION['usuario']['permisos'])) {
			self::$permisos = $_SESSION['usuario']['permisos'];
		}
		else {
			self::recuperar_permisos(self::$login);
		}
			
		if (isset($_SESSION['usuario']['contador_paginas_visitadas']))
			$_SESSION['usuario']['contador_paginas_visitadas']++;
		else 
			$_SESSION['usuario']['contador_paginas_visitadas'] = 1;
		
		if (self::$depuracion) {
			echo(__METHOD__." .self::\$permisos = ");
			print_r(self::$permisos);
		}
	}
	
	
	/**
	 * Si el parámetro $login no es una cadena, es una cadena vacía, o es una cadena que contiene caracteres que no sean letras, numeros y _ lanza una execpción con un mensaje.
	 * Si no salta la excepción el valor del parámetro $login es asignado a la propiedad $login de la clase. Borra la entrada $_SESSION['usuario'] y la vuelve a crear asignándo a la entrada $_SESSION['usuario']['login'] el valor del parámetro $login. Después llama al método de esta misma clase recuperar_permisos($login).
	 * 
	 * @param string $login
	 */
	public static function nuevo($login, $id = null) {
		
		self::$login = $login;
		self::$id = $id;
		
		if (\core\Configuracion::$regenerar_session_id) {
			\core\SESSION::regenerar_id(); // Seguridad
		}
		
		$_SESSION["usuario"]["contador_paginas_visitadas"] = 1;
		$_SESSION["usuario"]["login"] = $login;
		$_SESSION["usuario"]["id"] = $id;
		$_SESSION["usuario"]["sesion_fh_inicio"] = $_SERVER["REQUEST_TIME"];
		
		// Borramos los permisos del usuario anterior y 
		// recuperamos los permisos del nuevo usuario
		unset($_SESSION["usuario"]["permisos"]);
		self::$permisos = array();
		self::recuperar_permisos(self::$login);
		
		self::sesion_control_tiempos();
		
		if (self::$depuracion) {
			echo __METHOD__." ".__LINE__." ".self::$login." ".self::$id;
		}
	}
	
	
	public static function cerrar_sesion() {
		
		//self::$login = 'anonimo';
		unset($_SESSION['usuario']);
		\core\SESSION::destruir();
		self::nuevo('anonimo');

		if (self::$depuracion) {
			echo(__METHOD__); echo "</br>";
		}
	}
	
	
	private static function recuperar_permisos($login) {
		
		$metodo = "recuperar_permisos_".\core\Configuracion::$usuarios_origen;
		self::$metodo($login);
		if (self::$depuracion) {
			echo(__METHOD__); echo "</br>";
		}
		
	}
	
	
	private static function recuperar_permisos_ACL($login) {
		
		foreach (\core\Configuracion::$access_control_list as $controlador => $metodos) {
			
			foreach ($metodos as $metodo => $lista_usuarios) {
				//$usuarios = array();
				$usuarios = explode(",", trim($lista_usuarios));
				
				if (
						($login == "anonimo" 
							and (array_search("todos", $usuarios) !== false
									or array_search($login, $usuarios) !== false
								)
						)
						or
						($login != "anonimo" 
							and (array_search("todos", $usuarios) !== false
									or array_search("logueados", $usuarios) !== false
									or array_search($login, $usuarios) !== false
								)
						)
					) {
					self::$permisos[$controlador][$metodo] = true;
					
				}
				
				
			}
			if (isset(self::$permisos["*"]["*"]))
					break;
			
			}
			if (self::$depuracion) {
				echo(__METHOD__); echo "</br>";
				var_dump(self::$permisos);
			
		}
		
		$_SESSION['usuario']['permisos'] = self::$permisos;
		
	}
	
	
	
	
	private static function recuperar_permisos_bd($login) {
		
		self::$permisos = \modelos\usuarios::permisos_usuario($login);
		$_SESSION['usuario']['permisos'] = self::$permisos;
		
		if (self::$depuracion) {
			echo(__METHOD__); echo "</br>";
			var_dump(self::$permisos);
		}
		
	}
	
	
	/**
	 * Comprueba si un usuario tiene permisos para ejecutar un controlador::método.
	 * Para el caso de metodos de acceso a formularios, como por ejemplo:
	 * form_insertar, form_insertar_validar, validar_form_insertar, que un usuario 
	 * tenga concediod el permiso de form_insertar, implica que tenga permiso 
	 * también para los correspondientes métodos de validación del formulario.
	 * 
	 * @param string $controlador
	 * @param string $metodo
	 * @return boolean
	 */
	public static function tiene_permiso($controlador = "inicio", $metodo = 'index') {
		
		if ( ! \core\Configuracion::$control_acceso_recursos) {
			return true;
		}
		
		$autorizado = false;
		
		// La siguiente línea hace que el usuario que tenga asignado el método
		// form_insertar también pueda acceder al método form_insertar_validar
		// o validar_form_insertar.
		$metodo = preg_replace("/_validar|validar_/", "", $metodo);
				
		// El usuario tiene acceo a todos los recursos
		if (isset(self::$permisos['*']['*']))
			$autorizado = true;
		// El usuario o todos los usuarios tienen acceso a todos los métodos del controlador
		elseif (isset(self::$permisos[$controlador]['*']))
			$autorizado = true;
		// El usuario o todos los usuarios tienen acceso al controlador y método determinado
		elseif (isset(self::$permisos[$controlador][$metodo]))
			$autorizado = true;	
		
		if (self::$depuracion) {
			echo(__METHOD__); echo "</br>";
			var_dump($autorizado);
		}
		
		return $autorizado;
		
	}
	
	
	
	
	private static function sesion_control_tiempos() {
		
		// Tiempo de inactividad
		if (isset($_SESSION['usuario']['sesion_request_time']))
			self::$sesion_segundos_inactividad = $_SERVER['REQUEST_TIME'] - $_SESSION['usuario']['sesion_request_time'];
		else
			self::$sesion_segundos_inactividad = 0;
		
		// Duración de la sesión
		if (isset($_SESSION['usuario']['sesion_fh_inicio']))
			self::$sesion_segundos_duracion = $_SERVER['REQUEST_TIME'] - $_SESSION['usuario']['sesion_fh_inicio'];
		else
			self::$sesion_segundos_duracion = 0;
		
		// Memorizamos la hora de la petición actual para tenerlo en cuenta en la siguiente petición que realice el usuario.
		$_SESSION['usuario']['sesion_request_time'] = $_SERVER['REQUEST_TIME'];
		
	}
	
	/**
	 * Autentica un usario (login, password) contra la lista de usuarios definida
	 * en \core\Configuracion::$usuarios_lista
	 * 
	 * @param string $login
	 * @param string $password
	 * @return boolean
	 */
	public static function autenticar_en_ACL($login, $password) {
		
		if (self::$depuracion) {
			echo(__METHOD__); echo "</br>";
		}
		
		return((isset(\core\Configuracion::$usuarios_lista[$login]) and \core\Configuracion::$usuarios_lista[$login] == $password) ? "autenticado_en_ACL" : false);
		
	}
	
	
} // Fin de la clase