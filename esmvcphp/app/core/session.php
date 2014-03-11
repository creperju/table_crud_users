<?php
namespace core;

/**
 * Contiene los métodos para iniciar el array $_SESSION, destruirlo,
 * regenerar la id de sesión.
 * Si se detecta un cambio de ip genera un error y destruye la sessión.
 * 
 * @author Jesús Mª de Quebedo Tomé <jequeto@gmail.com>
 */
class SESSION {
	
	/**
	 * Inicia o recupera el array $_SESSION y controla que no se realize un
	 * cambio de ip durante la sesión.
	 */
	public static function iniciar() {
		session_set_cookie_params ( 
				\core\Configuracion::$session_lifetime
				,\core\Configuracion::$session_cookie_path
				,\core\Configuracion::$session_cookie_domain
				,\core\Configuracion::$session_cookie_secure
				,\core\Configuracion::$session_cookie_httponly
		);

		if (isset($_GET["administrator"])) {
			session_name(\core\Configuracion::$session_name."_ADMINISTRATOR" );
			\core\Configuracion::$session_lifetime = 0; // Cookiee de session
		}
		else {
			session_name(\core\Configuracion::$session_name );
		}
		session_start(); // Se crea el arry $_SESSION o se recupera si fue creado en una ejecución anterior del script.
		if ( ! isset($_SESSION["REMOTE_ADDR"])) {
			$_SESSION["REMOTE_ADDR"] = $_SERVER["REMOTE_ADDR"];
		}
		else {
			if ($_SESSION["REMOTE_ADDR"] != $_SERVER["REMOTE_ADDR"]) {
				$datos["mensaje"] = "Error fatal: La IP de sesión se ha cambiado dentro de la misma sesión de trabajo.";
				self::destruir();
				\core\Distribuidor::cargar_controlador("errores", "mensaje", $datos);
				exit(0);
			}
		}
		
	}
	
	
	/**
	 *  Borra la cookie de sesión y destruye la sesión.
	 */
	public static function destruir() {
		
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			\core\HTTP_Respuesta::setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		
		session_destroy();
		
	}
	
	
	/**
	 * Regenera la id de la cookie de sesión.
	 */
	public static function regenerar_id() {
		
		session_regenerate_id(true);
		
	}
	
}