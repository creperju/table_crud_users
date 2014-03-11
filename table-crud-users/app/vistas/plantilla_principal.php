<!DOCTYPE HTML>
<html lang="es">
	<head>
            <title><?php echo TITULO; ?></title>
		<meta name="Description" content="Explicaci�n de la p�gina" /> 
		<meta name="Keywords" content="palabras en castellano e ingles separadas por comas" /> 
		<meta name="Generator" content="con qu� se ha hecho" /> 
	 	<meta name="Origen" content="Qu�en lo ha hecho" />
                <meta name="Lang" content="es" /> 
		<meta name="Author" content="nombre del autor" /> 
		<meta name="Locality" content="Madrid, Espa�a" /> 
		<meta name="Viewport" content="maximum-scale=10.0" /> 
		<meta name="revisit-after" content="1 days" /> 
		<meta name="robots" content="INDEX,FOLLOW,NOODP" /> 
		<meta http-equiv="Content-Type" content="text/html;charset=utf8" />
                <meta http-equiv="Content-Language" content="es"/>
		
		<link href="<?php echo URL_ROOT; ?>favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<link href="<?php echo URL_ROOT; ?>favicon.ico" rel="icon" type="image/x-icon" /> 
		
				
		<!-- Importo los CSS que tendrá la plantilla_principal y el que cargará con cada sección -->
		<link rel="stylesheet" type="text/css" href="<?php echo URL_ROOT; ?>recursos/css/principal.css" />
		<script type='text/javascript' src="<?php echo URL_ROOT."recursos/js/jquery/jquery-1.10.2.min.js"; ?>" ></script>
                
		<script type="text/javascript">
		
		    function cambiar_btn_menu(menu,tipo){
                            var enlace = "<?php echo URL_ROOT; ?>recursos/imagenes/btn_"+menu;

                            switch(tipo){
                                case 'in':
                                    if( menu == 'conectar' || menu == 'registrar' || menu == 'desconectar' )
                                        document.getElementById("btn_"+menu).style.backgroundColor = '#555555';
                                    else
                                    {
                                        document.getElementById("btn_"+menu).style.backgroundColor = "#188DB8";
                                        document.getElementById("img_"+menu).src = enlace+"_activo.gif";
                                    }                                    
                                    break;
                                case 'out':
                                    if( menu == 'conectar' || menu == 'registrar' || menu == 'desconectar' )
                                        document.getElementById("btn_"+menu).style.backgroundColor = '#444';
                                    else
                                    {
                                        document.getElementById("btn_"+menu).style.backgroundColor = '#3299BB';
                                        document.getElementById("img_"+menu).src = enlace+"_inactivo.gif";
                                    }
                                    break;
                            }
	
		    }
		
                    
                    function submit_post_request_form(action, id) {
                        
                            $("#post_request_form").attr("action",action);
                            $("#id").attr("value", id);
                            $("#post_request_form").submit();
					
                    }
                
                
		</script>
		
	</head>

	<body>
            
            
            <!----------------------------------------------------------------------
               BOTÓNES DE FORMULARIO PARA CONECTARSE, DESCONECTARSE O REGISTRARSE
            ------------------------------------------------------------------------>
               
            <div id="btns_accion">  
               
            <!------------------------------------------
                 APARECE EL BOTÓN DE DESCONECTAR USUARIO
            -------------------------------------------->
            <?php if( \core\Usuario::$login != "anonimo" ): ?>
                <div id="btn_desconectar"
                     onclick="window.location.assign('<?php echo \core\URL::generar('usuarios/desconectar'); ?>')"
                     onmouseover="cambiar_btn_menu('desconectar','in');"
                     onmouseout="cambiar_btn_menu('desconectar','out');">Desconectar</div>
                
                
                
                
            <?php else: ?>
                
                <!------------------------------------------
                    APARECE EL BOTÓN DE REGISTRAR USUARIO
                -------------------------------------------->
                <?php if ((\core\Usuario::$login == "anonimo") && ! (\core\Distribuidor::get_controlador_instanciado() == "usuarios" && \core\Distribuidor::get_metodo_invocado() == "form_insertar_externo")): ?>
                
                <div id="btn_registrar"
                     onclick="window.location.assign('<?php echo \core\URL::generar('usuarios/form_insertar_externo'); ?>')"
                     onmouseover="cambiar_btn_menu('registrar','in');"
                     onmouseout="cambiar_btn_menu('registrar','out');">Reg&iacute;strate</div>
                
                <?php endif; ?>
                
                
                <!------------------------------------------
                    APARECE EL BOTÓN DE CONECTAR USUARIO
                -------------------------------------------->
                <?php if ((\core\Usuario::$login == "anonimo") && ! (\core\Distribuidor::get_controlador_instanciado() == "usuarios" && \core\Distribuidor::get_metodo_invocado() == "form_login")) : ?> 
               
                <div id="btn_conectar"
                     onclick="window.location.assign('<?php echo \core\URL::generar('usuarios/form_login'); ?>')"
                     onmouseover="cambiar_btn_menu('conectar','in');"
                     onmouseout="cambiar_btn_menu('conectar','out');">Conectar</div>
                
                <?php endif; ?>
                
                
                
                
                
                
                
            <?php endif; ?>
            
            </div>
                
                
                
            <!-------------------------------------------------------
                            ENCABEZADO DE LA PÁGINA
            --------------------------------------------------------->
	    <div id="encabezado">
                <h1>Table Crud Users Emilio Crespo Perán</h1>	
                    
		    <?php echo \core\HTML_Tag::div_menu("btn_menu", array("inicio"), "Inicio"); ?>
                    <?php echo \core\HTML_Tag::div_menu("btn_menu", array("tabla"), "Tabla"); ?>               
                    <?php echo \core\HTML_Tag::div_menu("btn_menu", array("usuarios"), "Usuarios"); ?>
                    <?php echo \core\HTML_Tag::div_menu("btn_menu", array("roles"), "Roles"); ?>
                
	    </div>
	    
                            
                            
                            
            <!-------------------------------------------------------
                            CUERPO DE LA PÁGINA
            --------------------------------------------------------->               
	    <div id="cuerpo">
		<div id="contenido">
		    <?php 
			echo $datos['view_content'];
		    ?>
		</div>
	    </div>
	    
                            
                            
                            
            <!-------------------------------------------------------
                            PIE DE LA PÁGINA
            --------------------------------------------------------->
	    <div id="pie">
		
		Sitio Web desarrollado por Emilio Crespo Perán &copy;</br>
		Última modificación: 06/02/2014</br>
                <a class="contacto" href="mailto:emilio_nfs@hotmail.es">Contacto</a>
		
	    </div>
	    
	</body>

</html>