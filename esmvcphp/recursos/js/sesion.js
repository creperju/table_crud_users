/* f_sesion.js */

			
function dos_digitos(numero) {
	if (numero<10) {
	  numero="0" + numero;
	}
	return numero;
}

function actualizar_tiempos() {
	
	// alert('actualizar_tiempos');
	var fecha = new Date();
	document.getElementById('fecha').innerHTML = fecha.toLocaleDateString()+" "+fecha.toLocaleTimeString();

	var hora = new Date(sesion_ms_inactivo);
	document.getElementById('tiempo_inactivo').innerHTML = dos_digitos(hora.getUTCHours())+":"+dos_digitos(hora.getMinutes())+":"+dos_digitos(hora.getSeconds());
	sesion_ms_inactivo += 1000;
		
	objeto = document.getElementById('tiempo_desde_conexion');
	hora = new Date(sesion_ms_desde_conexion);
	objeto.innerHTML = dos_digitos(hora.getUTCHours())+":"+ dos_digitos(hora.getMinutes())+":"+dos_digitos(hora.getSeconds());
	sesion_ms_desde_conexion += 1000;
	
}


// window.setInterval("actualizar_tiempos" , 1000);
			