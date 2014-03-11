<?php
namespace core {

	class Configuracion {

		// Visualización de errores
		public static $display_errors = true;

		// Respuesta por defecto
		public static $controlador_por_defecto = 'inicio';
		public static $metodo_por_defecto = 'index';
		public static $plantilla_por_defecto = 'plantilla_principal';
		public static $plantilla_administrator = 'plantilla_administrator';

		// Respuesta HTTP
		public static $tipo_mime_por_defecto = 'text/html';
		public static $tipos_mime_servidos = array(
			'text/html', 'text/xml', 'text/json', 'application/excel', 
		);

		// Usar sesiones de trabajo (activar array $_SESSION)
		public static $session_name = "PHPSESSID";
		public static $session_activate = true;
		public static $session_lifetime = 0; // Segundos de duración de la cookie de sessionsession.cookie_lifetime
		public static $session_cookie_path = "/";
		public static $session_cookie_domain = "";
		public static $session_cookie_secure = false;
		public static $session_cookie_httponly = false;

		// URL amigables
		public static $url_amigable = true;

		// URL registrar url_anterior btn_volver
		public static $url_registrar_anterior = true;


		// Gestión de usuarios si hay usuarios distintos
		public static $usuarios = true; // True => hay usuarios, false => no hay usuarios.
		public static $usuarios_origen = "bd"; // Valores válidos "bd" o "ACL" que es interna La lista de usuarios se define al final de esta clase
		// Regeneración de id de cookie de session al cambiar de usuario
		public static $regenerar_session_id = true;
		// Control acceso a recursos
		public static $control_acceso_recursos = true;

		// Gestión de inactividad para usuario logueados
		public static $sesion_minutos_inactividad = 20; // num >= 0. 0 Implica sin control
		public static $sesion_minutos_maxima_duracion = 120; // Duración máxima de una conexión. 0 Implica sin control.


		// Gestión de idiomas
		public static $idioma_sensibilidad = true;
		public static $idioma_por_defecto = "es";
		public static $idioma_seleccionado;
		// Idiomas reconocidos en los que puede respondeer la aplicación
		public static $idiomas_reconocidos = "es|en|fr";

		// Formularios de login
		public static $https_login = false;
		public static $form_login_catcha = false;
		public static $form_insertar_externo_catcha = false;

		// Contactos
		public static $email_info = "info@esmvcphp.es";
		public static $email_noreply = "noreply@esmvcphp.es";


		// Base de datos
		// Debe estar activa si se utilizan usuarios y control de acceso a los recursos
		public static $use_db = true;
		// localhost
		public static $db = array(
			'server'   => 'localhost',
			'user'     => 'daw2_user',
			'password' => 'daw2_user',
			'db_name'  => 'daw2',
			'prefix_'  => 'daw2_'
		);

		// hostinger
	//	public static $db = array(
	//		'server'   => 'mysql.hostinger.es',
	//		'user'     => 'u452950836_daw2',
	//		'password' => 'u452950836_daw2',
	//		'db_name'   => 'u452950836_daw2',
	//		'prefix_'  => 'daw2_'
	//	);



		// Acceso estático de usuarios
		// Cuando el conjunto de usuarios previsto no vaya a cambiar durante la vida de la aplicación y sea reducido.
		public static $usuarios_lista = array(
			// "login" => "contraseña"
			"anonimo" => "",
			"admin" => "admin00",
			"juan" => "juan00",
			"anais" => "anais00",
			"anabel" => "anabel00",
		);
		/**
		 * Define array llamado recursos_y_usuarios con la definición de todos los permisos de acceso a los recursos de la aplicación.
		 * 
		 * * Recursos:
		 *  [*][*] define todos los recursos
		 *  [controlador][*] define todos los métodos de un controlador
		 * Usuarios:
		 *  "todos" define todos los usuarios (anonimo más logueados)
		 *  "logueados" define todos los usuarios logueados (anonimo no está incluido)
		 * 
		 * @var array =('controlador' => array('metodo' => ' nombres usuarios rodeados por espacios
		 */
		public static $access_control_list = array(
			'*' => array(	'*' => ' admin '),
			'inicio' => array (
							'*' => ' logueados ',
							'index' => ' todos ',
						),

			'mensajes' => array(
								'*' => ' todos ',
								),
			'usuarios' => array(
								'*' => ' juan ',
								'index' => ' anais, anabel ',
								'desconectar' => ' logueados ',
								'form_login_email' => ' anonimo ',
								'form_login' => ' anonimo ',
								),
			'usuarios_permisos' => array(
								"index" => "logueados",
			),

		);
	} // Fin de la clase 
	
} // Fin namespace \core


