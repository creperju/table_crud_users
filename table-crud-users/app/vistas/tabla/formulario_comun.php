
<?php 
   
    $controlador = \core\Distribuidor::get_controlador_instanciado();
    $metodo = \core\Distribuidor::get_metodo_invocado();

    if(preg_match("/^form_modificar$/i", $metodo) || preg_match("/^form_borrar$/i", $metodo)){
            if( ! isset($_REQUEST['id']) ){
                                
                \core\HTTP_Respuesta::set_header_line("location", \core\URL::generar("errores"));
                \core\HTTP_Respuesta::enviar();
                
            }

    }
    
    if(preg_match("/^form_borrar$/i", $metodo))
        $lectura = "readonly='readonly'";  
    


?>

<form method='post' name='<?php echo $datos['form_name']; ?>' onsubmit="return validar();" action="<?php echo URL_ROOT.$controlador."/".$metodo; ?>_validar"  >

	
    
	<?php echo \core\HTML_Tag::form_registrar("formulario", "post"); ?>
	 
	<input id='id' name='id' type='hidden' value='<?php echo \core\Array_Datos::values('id', $datos); ?>' />	
	<br />
        
        
        T&iacute;tulo:
        <input  id='titulo' 
                name='titulo' 
                type='text' 
                size='20'  
                maxlength='30' 
                value='<?php echo \core\Array_Datos::values('titulo', $datos); ?>'            
                <?php if(isset($lectura))echo $lectura; ?> />
        
        <span class="error" id="error_titulo">
            <?php echo isset($datos['errores']['titulo'])?$datos['errores']['titulo']:""; ?>
        </span>       
        <br/>
        
        
        Plataforma:
        <input  id='plataforma' 
                name='plataforma' 
                type='text' 
                size='20'  
                maxlength='20' 
                value='<?php echo \core\Array_Datos::values('plataforma', $datos); ?>'                
                <?php if(isset($lectura))echo $lectura; ?> />
        
        <span class="error" id="error_plataforma">
            <?php echo isset($datos['errores']['plataforma'])?$datos['errores']['plataforma']:""; ?>
        </span>     
        <br/>
        
        
        Fabricante:
        <input  id='fabricante' 
                name='fabricante' 
                type='text' 
                size='20'  
                maxlength='20' 
                value='<?php echo \core\Array_Datos::values('fabricante', $datos); ?>'                
                <?php if(isset($lectura))echo $lectura; ?> />        
        
        <span class="error" id="error_fabricante">
            <?php echo isset($datos['errores']['fabricante'])?$datos['errores']['fabricante']:""; ?>
        </span>        
        <br/>
        
        
        Fecha de lanzamiento:
        <input id='fecha_de_lanzamiento' 
               name='fecha_de_lanzamiento' 
               type='text' 
               size='10' 
               maxlength='10' 
               value='<?php echo \core\Array_Datos::values('fecha_de_lanzamiento', $datos); ?>'              
               <?php if(isset($lectura))echo $lectura; ?> />
        
        <span class="error" id="error_fecha">
            <?php echo isset($datos['errores']['fecha_de_lanzamiento'])?$datos['errores']['fecha_de_lanzamiento']:""; ?>
        </span>          
        <br/>
        
        
        Precio:
        <input  id='precio' 
                name='precio' 
                type='text' 
                size='10'  
                maxlength='10' 
                value='<?php echo \core\Array_Datos::values('precio', $datos); ?>'               
                <?php if(isset($lectura))echo $lectura; ?> />&euro;
        
        <span class="error" id="error_precio">
            <?php echo isset($datos['errores']['precio'])?$datos['errores']['precio']:""; ?>
        </span>
        
        
        
        <p>  
	
            
            <input type='submit' value='Enviar' />
            <?php if(preg_match("/^form_insertar$/i", $metodo)): ?>
                <input type='reset' value='Reiniciar' />
            <?php endif; ?>
            <input type="button" value="Cancelar" onclick='window.location.assign("<?php echo \core\URL::generar("tabla"); ?>");' />
            
            
        </p>
        
</form>



<?php if(preg_match("/^form_insertar$/i", $metodo) || preg_match("/^form_modificar$/i", $metodo)): ?>
    <script type="text/javascript">
	
       
	function validar(){
            var c = 0;
            
            if( ! v_vacio('titulo') ) c++;
            if( ! v_vacio('plataforma') ) c++;
            if( ! v_vacio('fabricante') ) c++;
            if( ! v_fecha() ) c++;
            if( ! v_precio() ) c++;
            
            if( c == 0 )
                return true;
            else{
                alert("Corrige los errores en el formulario ("+c+")");c=0;
                return false;               
            }
        }
          
        
        
        
        function v_vacio(dato){
            
            //id = "error_"+dato;
            
            document.getElementById("error_"+dato).innerHTML = "";
            
            valor = document.getElementById(dato).value;
            //alert("El "+dato+" es: "+valor);
            patron = /^\w+$/i;
            
            if(patron.test(valor) && valor.length > 0)
                return true;                      
            else{              
                document.getElementById("error_"+dato).innerHTML = "El campo '"+dato+"' no debe estar vac&iacute;o.";
                return false;
            }
                
        }
        
        function v_fecha(){
            
            document.getElementById("error_fecha").innerHTML = "";          
            fecha = document.getElementById("fecha_de_lanzamiento").value;
            //alert("La fecha es: "+fecha);
            patron = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
            
            if(patron.test(fecha))
                return true;
            else{          
                document.getElementById("error_fecha").innerHTML = "Fecha no v&aacute;lida. Formato: dd/mm/aaaa";
                return false;
            }
            
        }
        
        
        
        function v_precio(){
            
            document.getElementById("error_precio").innerHTML = "";                      
            precio = document.getElementById("precio").value;
            //alert("El precio es: "+precio);
            patron = /^\d{1,3}(,\d{1,2}){0,1}$/;
            
            if(patron.test(precio))
                return true;
            else{                
                document.getElementById("error_precio").innerHTML = "Precio no v&aacute;lido, máximo tres cifras con dos decimales. Formato: xxx,xx";
                return false;
            }
            
            
            
        }
        
    </script>	
<?php endif; ?>