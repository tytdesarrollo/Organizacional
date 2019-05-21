<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcOrganigrama extends Model{	
	
    public function procedimiento($c1)
    {			
		// TNS DE LA BASE DE DATOS
    	$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];	
		//conexion con la base de datos 	
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, "BEGIN TW_PC_ORGANIGRAMA_SIMPLE(:c1,:c2,:c3); END;");
		//SE DECLARAN LOS CURSOR 
		$c2 = oci_new_cursor($conexion);
		$c3 = oci_new_cursor($conexion);
		//SE PASAN COMO PARAMETRO LOS CURSOR 
		oci_bind_by_name($stid, ':c1', $c1, 15);
		oci_bind_by_name($stid, ':c2', $c2, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':c3', $c3, -1, OCI_B_CURSOR);
		//SE EJECUTA  LA SENTENCIA SQL
	    oci_execute($stid);
	    oci_execute($c2, OCI_DEFAULT);
	    oci_execute($c3, OCI_DEFAULT);
		//extrae cada fila de cada cursor de una variable 
	    oci_fetch_all($c2, $cursor1, null, null, OCI_FETCHSTATEMENT_BY_COLUMN);
	    oci_fetch_all($c3, $cursor2, null, null, OCI_FETCHSTATEMENT_BY_ROW);
		//resultado
		return array($cursor1,$cursor2);

	}	
}