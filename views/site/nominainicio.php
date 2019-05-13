<?php

	$this->registerJsFile(
		'@web/js/nominaInicio.js',
		['depends' => [\yii\web\JqueryAsset::className()]]
	);	
	
	$this->registerJsFile(
		'@web/js/plantillaDatos.js',
		['depends' => [\yii\web\JqueryAsset::className()]]
	);

?>

<div id="organigram" class="disp-flex-center">
	<div id="content">	
		<div class="row">
			<div class="col-sm-2 ">
				<img src="../web/img/organigrama-icon.svg" alt="">
			</div>
			<div class="col-sm-6">
				<h3 class="white-font fnt__Bold disp-flex-center mrg__left-70"> Crear organigrama</h3>	
			</div>
		</div>	
		
		<div class="mrg__top-30">
			<span class="white-font subtitle">Selecciona las dependencias o cargos que desea ver</span>
		</div>

		<div id="dependences" class="row mrg__top-30">
			<div id="contentList" class="col-sm-12">				
			</div>			
		</div>
		<div class="row  mrg__top-15" id="createModal">
			<div class="col-md-12">				
				<a class="btn btn-success btn-lg" href="index.php?r=site%2Fnomina" class="close" data-dismiss="modal" aria-label="Close" onclick="">
					<span class="text-span">CREAR</span>
				</a>							
			</div>
		</div>
	</div>
</div>
