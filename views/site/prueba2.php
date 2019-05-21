<?php
	use app\models\TwPcOrganigrama;
	
	$model = new TwPcOrganigrama;
	$resultado = $model->procedimiento(0);
	
	var_dump($resultado[0]);
	echo "<br>";
	echo "-----------------------";
	echo "<br>";
	var_dump($resultado[1]);