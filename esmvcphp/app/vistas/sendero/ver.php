<?php

$i = 1;
foreach ($datos["sendero"] as $key => $pisada) {
	$href = ($key < count($datos["sendero"])) ? "href='{$pisada["url"]}'" : "";
	echo "<a class='sendero_paso' $href >{$pisada["etiqueta"]}</a>";
	if ($key < count($datos["sendero"]))
		echo " &gt; ";
	$i++;
	
}