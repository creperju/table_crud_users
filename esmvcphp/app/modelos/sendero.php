<?php

namespace modelos;

class sendero  {
	
	public static function iniciar($etiqueta, $url) {
		
		unset($_SESSION["sendero"]);
		$_SESSION["sendero"][1] = array("etiqueta" => $etiqueta, "url" => $url);
		
	}
	
	
	public static function set_nivel_2($etiqueta, $url) {
		
		unset($_SESSION["sendero"][3]);
		$_SESSION["sendero"][2] = array("etiqueta" => $etiqueta, "url" => $url);
		
	}
	
	
	public static function set_nivel_3($etiqueta, $url) {
		
		$_SESSION["sendero"][3] = array("etiqueta" => $etiqueta, "url" => $url);
		
	}
	
	
	public static function get_nivel($nivel) {
		
		return (isset($_SESSION["sendero"]) && array_key_exists($nivel, $_SESSION["sendero"])) ? $_SESSION["sendero"][$nivel] : null;
		
	}


	
	public static function recuperar() {
		
		return (isset($_SESSION["sendero"]) ? $_SESSION["sendero"] : array());		
		
	}
	
	
}