<?php
namespace core;

/**
 * Esta clase define un autocargador que cargará correctamente clases que se instancien así new \nombre_namespace\nombre_clase(), donde nombre_namespace será el nombre del namespace del fichero que contiene la clase, y también será el nombre de la carpeta contenida en ...\app y que contiene el fichero php con la clase (...\app\nombre_namespace\nombre_clase.php)
 * 
 * Exige que el nombre de todas las carpetas y de todos los ficheros estén escritos en minúsculas.
 *  
 * @author Jesús María de Quevedo Tomé <jequeto@gmail.com>
 * @since 2013-01-30
 * @updated 2014-01-27
 */
class Autoloader {
	
	static $depuracion = false;
	
	/**
	 *
	 * @var array Array con los nombres de las aplicaciones en las que se buscará 
	 */
	private static $applications = array ("esmvcphp" => true);
	
	
	/**
	 * Lanza el autocargador de clases que buscará en las carpetas que se le pasen
	 * en el array y además en la carpeta .../esmvcphp/ que es la carpeta común a
	 * todas las aplicaciones y que contiene el core del framework
	 * 
	 * @param array $applications array("folder" => true, "folder2" => "true", ...);
	 */
	function __construct(array $applications = array()) {
		
		// Las nuevas aplicaciones deben ser las primeras en las que se busque
		self::$applications = array_merge($applications, self::$applications);
	
		if (self::$depuracion) {
			echo "<hr />";
			echo __METHOD__." -> Arrancando el autoloader<br />";
			print("apps en las que se buscará");
			print_r(self::$applications);
		}
		
		
		spl_autoload_register(array($this, 'autoload')); // Esta es la función que registra la función que se activará cada vez que se intente instanciar una clase o se usar una clase estáticamente.
	}
	
	
	/**
	 * Esta es la función que tiene la "inteligencia" para buscar los ficheros por las carpetas del disco del servidor
	 * @param string $class_name
	 * @return boolean
	 * @throws \Exception
	 */
	function autoload($class_name) {
		
		if (self::$depuracion) {
			echo "<br /><hr />";
			echo __METHOD__." -> \$class_name= $class_name"."<br />";
		}
		if (class_exists($class_name)) {
			// Si la clase existe es que ya está cargada
			if (self::$depuracion) { echo __METHOD__." -> EXISTE \$class_name= $class_name"."<br />";}
			return;
		}
		
		if (isset($_SESSION["clases_cargadas"]) && isset($_SESSION["clases_cargadas"][$class_name]))
			return (require_once($_SESSION["clases_cargadas"][$class_name]));
		
		// Sustituir las \ que separan el namespaces del nombre de la clase por DS que separa carpetas
		$class_name = str_replace(array("\\", ), array(DS , ), $class_name);
		
		$carpetas = "";
		foreach (self::$applications as $application => $valid) {
			$carpetas .= $application."  "; 
			if ( $fichero_encontrado = self::buscar($application, $class_name))
				break;
		}
		
		if ( ! $fichero_encontrado) {
			
			throw new \Exception(__METHOD__." -> No se ha encontrado la clase $class_name el la/s carpeta/s <b>$carpetas</b>");
		}
			
		
	}
	
	
	private static function buscar($application, $class_name ) {
		
		$path_busqueda = PATH_ROOT.$application.DS."app".DS; 
		$fichero_clase = strtolower($path_busqueda.$class_name.".php");
		
		if ( ! file_exists($fichero_clase)) {
			if (self::$depuracion) {
				echo __METHOD__.": NO EXISTE \$fichero_clase= $fichero_clase"."<br />";
			}
			$class_name = str_replace(
				array("controlador"), 
				array("controladores"),
				$class_name
			);
			$fichero_clase = $path_busqueda.$class_name.".php";
		}
		
		if ( ! file_exists($fichero_clase) ) {
			// Buscamos en las clases de la librería de dompdf
			$fichero_clase = strtolower($path_busqueda."lib/php/dompdf/include/$class_name.cls.php");
		}
		
		if ( file_exists($fichero_clase) ) {
			
			if (self::$depuracion) {echo __METHOD__.": EXISTE y CARGANDO ... \$fichero_clase= $fichero_clase"."<br />";}
			if (isset($_SESSION)) {
				$_SESSION["clases_cargadas"][str_replace(DS, "\\",$class_name)] = $fichero_clase;
			}
			return (require_once($fichero_clase));
		}
		else {
			
			return false;
		}
		
		
	}
	
	
	
	public static function get_applications() {
//		var_dump(self::$applications);
		return self::$applications;
		
	}
	
} // Fin de la clase