<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
$this->title = 'Estructura Organizacional';
// $this->registerJsFile(
// 		'@web/js/pdf.js',
// 		['depends' => [\yii\web\JqueryAsset::className()]]
// 	);
$this->registerJsFile(
    '@web/js/plantillaDatos.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/nomina.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
/*
	$e = [
	        'NOMBRES' => array ('NOMBRE UNO','NOMBRE DOS','NOMBRE TRES','NOMBRE CUATRO','NOMBRE CINCO','NOMBRE SEIS','NOMBRE SIETE','NOMBRE OCHO','NOMBRE NUEVE','NOMBRE DIEZ','NOMBRE ONCE','NOMBRE DOCE','NOMBRE TRECE','NOMBRE CATORCE','NOMBRE QUINCE','NOMBRE DIECISEIS','NOMBRE DIECISIETE','NOMBRE DIECIOCHO','NOMBRE DIECINUEVE','NOMBRE VEINTE','NOMBRE VEINTIUNO','NOMBRE VEINTIDOS','NOMBRE VEINTITRES','NOMBRE VEINITCUATRO','NOMBRE VEINTICINCO','NOMBRE VEINITSEIS','NOMBRE VEINITISIETE','NOMBRE VEINITIOCHO','NOMBRE VEINITINUEVE','NOMBRE TREINTA','NOMBRE TREINTAUNO','NOMBRE TREINTACUATRO','NOMBRE TREINTACINCO','NOMBRE TREINTASEIS','NOMBRE TREINTASIETE','NOMBRE TREINTAOCHO','NOMBRE TREINTANUEVE','NOMBRE CUARENTA','NOMBRE CUARENTAUNO','NOMBRE CUARENTADOS','NOMBRE CUARENTATRES','NOMBRE CUARTENTACUATRO','NOMBRE CUARENTACINCO','NOMBRE CUARENTASEIS','NOMBRE CUARENTASIETE'),
            'CARGO' => array ('001','001','003','005','001','001','002','003','009','002','011','008','007','008','012','011','020','020','021','019','005','011','023','024','021','004','030','030','030','026','026','014','018','018','017','007','005','023','014','014','012','011','010','010','011')
    ];

	$c = [
    'AREA'=> array ('PRIMERA AREA','SEGUNDA AREA','TERCERA AREA','CUARTA AREA','QUINTA AREA', 'SEXTA AREA','SEPTIMA AREA','OCTAVA AREA','NOVENA AREA','DECIMA AREA', 'UNO AREA','DOS AREA','TRES AREA','CUATRO AREA','CINCO AREA', 'SEIS AREA','SIETE AREA','OCHO AREA','NUEVE AREA','DIEZ AREA','ONCE AREA','DOCE AREA','TRECE AREA','CARTORCE AREA','QUINCE AREA', 'DIECISEIS AREA','DIECISIETE AREA','DIECIOCHO AREA','DIECINUEVE AREA','VEINTE AREA'),
    'NIVEL'=> array ('1','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2'),
    'CODIGO' => array('001','002','003','004','005','006','007','008','009','010','011','012','013','014','015','016','017','018','019','020','021','022','023','024','025','026','027','028','029','030'),
    'DEPENDENCIA' => array('0','001','001','002','002','002','002','001','001','001','010','010','010','010','001','020','020','020','020','001','001','021','021','021','030','029','017','029','001','001')
    ];
*/
//$cadenarr[] = utf8_encode($resultado["NOM_OCUP"]);

$e = [
    'NOMBRES' => $empleados["NOMBRE"],
    'CARGO' => $empleados["COD_ESTRUCTURA"]
];
$c = [
    'AREA'=> $resultado["NOM_OCUP"],
    'NIVEL'=> $resultado["GRUPO_SALARIAL"],
    'CODIGO' => $resultado["COD_ESTRUCTURA"],
    'DEPENDENCIA' => $resultado["COD_EST_SUP"]
];
$d = [
    'AREA'=> $resultadofijo["NOM_OCUP"],
    'CODIGO' => $resultadofijo["COD_ESTRUCTURA"]
];

for ($i = 0; $i < count($c["AREA"]); $i++) {

    $areaf[] = utf8_encode($resultado["NOM_OCUP"][$i]);
    $nivelf[] = utf8_encode($resultado["GRUPO_SALARIAL"][$i]);
    $codigof[] = utf8_encode($resultado["COD_ESTRUCTURA"][$i]);
    $dependenciaf[] = utf8_encode($resultado["COD_EST_SUP"][$i]);

}

$g = [
    'AREA'=> $areaf,
    'NIVEL'=> $nivelf,
    'CODIGO' => $codigof,
    'DEPENDENCIA' => $dependenciaf
];

$nomg=[];
$grupog=[];

for ($i = 0; $i < count($e["NOMBRES"]); $i++) {

    $nomg[] = utf8_encode($empleados["NOMBRE"][$i]);
    $grupog[] = utf8_encode($empleados["COD_ESTRUCTURA"][$i]);

}

$k = [
    'NOMBRES' => $nomg,
    'CARGO' => $grupog
];

if(count($c["AREA"]) <= 1){

    array_push($g["AREA"], "NO EXISTE CARGO DEPENDIENTE");
    array_push($g["NIVEL"], $g["NIVEL"][0]);
    array_push($g["CODIGO"], "");
    array_push($g["DEPENDENCIA"], $g["CODIGO"][0]);
}

// $pru = utf8_encode($c["AREA"]);
//var_dump(json_encode($f));
//var_dump($g);
?>
<div class="disp-flex-center" id="parent">
    <div class="flex-2 flex-start mrg__left-25">

        <div class="">
            <a href="#" id="btn-Organigram" class="btn btn-success btn-sm "  data-toggle="modal" data-target="#cargosModal"">
            <img src="../web/img/organigrama-icon.svg" alt=""><span class="text-span">Organigrama</span>
            </a>
            <a href="#" id="btn-Dowload" class="btn btn-success btn-sm" onclick="Downloadpptx()" >
                <img src="../web/img/excel-download.svg" alt=""><span class="text-span">Descargar</span>
            </a>
        </div>

    </div>
</div>

<div id="basicdiagram" style="width: 100%; height: 450px; margin-top:50px; position:absolute"></div>
</div>

<!-- Modal -->
<?php $form = ActiveForm::begin([
    "method" => "POST",
    "id" => "compro-form",
    "enableClientValidation" => false,
    "enableAjaxValidation" => true,
]);
?>
<div class="modal fade" id="cargosModal" tabindex="-1" role="dialog" aria-labelledby="cargosModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cargosModalLabel">*Selecciona el cargo padre desde donde se va a visualizar la estructura organizacional:</h5>
            </div>
            <div class="modal-body">

                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="empleadosel" name="empleadosel" value="empshow"> Mostrar Empleados?
                    </label>
                </div>
                </br>
                <div class="form-group select-m">
                    <label class="control-label" for="compagoSelect">
                        Seleccione Cargo Padre
                    </label>
                    <div class="mad-select" id="cargosele">
                        <ul style="width: 500px; font-size: medium;">
                            <li style="width: 500px;" class="selected" data-value="">Seleccione...</li>
                            <?php
                            for ($i = 0; $i < count($d["AREA"]); $i++) { ?>
                                <li style="width: 500px;" data-value="<?= $d["CODIGO"][$i] ?>"><?= utf8_encode($d["AREA"][$i]) ?></li>
                            <?php } ?>
                        </ul>
                        <input type="hidden" id="cargenv" name="cargenv" value="000000001" class="form-control">
                    </div>
                </div>
                </br>
                </br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                <?= Html::Button('CREAR', ['class' => 'btn btn-raised btn-primary', 'name' => 'enviar-button', 'id' => 'envOrg', 'onclick'=>'Warn();']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<div class="modal modal-organigram" id="modalOrganigram" tabindex="-1" role="dialog" aria-labelledby="nominaLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-box">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeClean()"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title redFont"> Crear organigrama</h3>
                </div>
                <hr class="mrg__top-30 red">
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="col-md-12 font-gray-dark">
                        <span class=subtitle>Selecciona las dependencias o cargos que desea ver</span>
                    </div>
                </div>
                <div id="dependences" class="row mrg__top-30">
                    <div id="contentList" class="col-sm-12 ">

                    </div>

                </div>
                <hr class="mrg__top-30 red">
                <div class="row" id="createModal">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button  class="btn btn-success btn-lg " class="close" data-dismiss="modal" aria-label="Close" onclick="closeClean();getChargeDepedence();">
                                <span class="text-span">CREAR</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-user" id="user" tabindex="-1" role="dialog" aria-labelledby="nominaLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-box">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeClean()"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title " id="nominaLabel"> </h3>
                </div>
                <hr class="mrg__top-30 red">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4" id="photoProfile">
                        <div class="col-md-12 flex-not-ie">
                            <img class="img-responsive" src="../web/img/photos/man.jpg" alt="" id="photo">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-10 mrg__left-15">
                                <div class="col-md-6">
                                    <div class="row">
                                        <h5 class="redFont">Dependencia</h5>
                                    </div>
                                    <div class="row font-gray-dark">
                                        <h4 id="dependenceUser"></h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <h5 class="redFont">Cargo</h5>
                                    </div>
                                    <div class="row font-gray-dark">
                                        <h4 id="charge"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mrg__top-10"></div>
                        <div class="row">
                            <div class="col-md-10 mrg__left-15">
                                <div class="col-md-6">
                                    <div class="row">
                                        <h5 class="redFont">Contrato</h5>
                                    </div>
                                    <div class="row font-gray-dark">
                                        <h4 id="contract"></h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <h5 class="redFont">Salario</h5>
                                    </div>
                                    <div class="row font-gray-dark">
                                        <h4 id="salary"></h4>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <hr class="mrg__top-30 red">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 mrg__left-15">
                                <div class="col-md-3">
                                    <div class="row">
                                        <h5 class="redFont">Dirección</h5>
                                    </div>
                                    <div class="row font-gray-dark">
                                        <h4 id="address"></h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <h5 class="redFont">Número</h5>
                                    </div>
                                    <div class="row font-gray-dark">
                                        <h4 id="number"></h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <h5 class="redFont">Estado Civil</h5>
                                    </div>
                                    <div class="row font-gray-dark">
                                        <h4 id="civil-status"></h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <h5 class="redFont">Edad</h5>
                                    </div>
                                    <div class="row font-gray-dark">
                                        <h4 id="age"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mrg__top-10"></div>
                        <div class="row mrg__top-30">
                            <div class="col-md-12 mrg__left-15">
                                <div class="col-md-3">
                                    <div class="row">
                                        <h5 class="redFont">Fecha Inicio</h5>
                                    </div>
                                    <div class="row font-gray-dark">
                                        <h4 id="date-start"></h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <h5 class="redFont">Fecha Final</h5>
                                    </div>
                                    <div class="row font-gray-dark">
                                        <h4 id="date-end"></h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <h5 class="redFont">Antigüedad</h5>
                                    </div>
                                    <div class="row font-gray-dark">
                                        <h4 id="antiquity"></h4>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <h5 class="redFont">Estado Laboral</h5>
                                    </div>
                                    <div class="row font-gray-dark">
                                        <div class="col-md-2 no-pdg">
                                            <img src="../web/img/icon-status-vacation.svg" alt="" class="width-90" id="icon-status">
                                        </div>
                                        <div class="col-md-10 no-pdg">
                                            <h4 id="working-status"></h4>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <hr class="mrg__top-30 red">
                <div class="row ">
                    <div id="" class="col-md-12 pdg-left-30">
                        <div class="row mrg__top-15">
                            <div class="col-md-1">
                                <img src="../web/img/icon-curse.svg" alt="">
                            </div>
                            <div class="col-md-5">
                                <h4 class="blank-bold redFont">Cursos</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div id="curses" class="col-md-12">
                                <h5 class="mrg__top-30 font-gray-dark">El empleado no se encuentra en ningún curso.</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mrg__top-30 red">
                <div class="row ">
                    <div id="" class="col-md-12 pdg-left-30">
                        <div class="row mrg__top-15">
                            <div class="col-md-1">
                                <img src="../web/img/icon-process-disciplinary.svg" alt="">
                            </div>
                            <div class="col-md-5">
                                <h4 class="blank-bold redFont">Procesos disciplinarios</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div id="disciplinaryProcesses" class="col-md-12">
                                <h5 class="mrg__top-30 font-gray-dark">El empleado no tiene faltas disciplinarias.</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mrg__top-30 red">
                <div class="row">
                    <div id="competences" class="col-md-12 pdg-left-30">
                        <div class="row mrg__top-15">
                            <div class="col-md-1">
                                <img src="../web/img/icon-competences.svg" alt="">
                            </div>
                            <div class="col-md-5">
                                <h4 class="blank-bold redFont">Competencias</h4>
                            </div>
                        </div>
                        <h5 class="mrg__top-30 font-gray-dark">Competencias del empleado</h5>
                        <div id="list" class="font-medium mrg__top-30" >
                        </div>
                    </div>
                </div>
                <hr class="mrg__top-30 red">
                <div class="row" id="competenceGraphics">
                    <div class="col-md-12 pdg-left-30">
                        <div class="row mrg__top-15">
                            <div class="col-md-1">
                                <img src="../web/img/icon-competences-vs.svg" alt="">
                            </div>
                            <div class="col-md-5">
                                <h4 class="blank-bold redFont">Afinidad con el cargo</h4>
                            </div>
                        </div>

                        <h5 class="mrg__top-30 font-gray-dark">Competencias que exige el cargo comparadas con las competencias del empleado</h5>
                        <div class="row">
                            <div class="col-md-12 mrg__top-30" id="competencesCharge">
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mrg__top-30 red">
                <div class="row" id="closeModal">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <a href="#" class="btn btn-success btn-lg " class="close" data-dismiss="modal" aria-label="Close" onclick="closeClean()">
                                <span class="text-span">CERRAR</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade modal-edit" id="edit" tabindex="-1" role="dialog" aria-labelledby="nominaLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="header-box">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetCount()"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title fnt__Bold redFont " id="editLabel"> Modificar Item</h3>
                    </div>
                </div>
                <div class="modal-body">
                    <!-- Tabs Empleado-->
                    <hr class="mrg__top-30 red">
                    <ul class="nav nav-pills col-md-6" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link " id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Empleado</a>
                        </li>
                        <li class="nav-item" id="navDependence">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Dependencia</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Tab Home -->
                        <div class="tab-pane fade in active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12 disp-flex-center">
                                            <img class="img-responsive" src="../web/img/photos/man.jpg" alt="" id="imageEdit">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="btn btn-file btn-block" id="inputImage">
                                                Cambiar imagen... <input type="file" style="display: none;">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group label-floating">
                                                <label class="control-label " for="">Nombre</label>
                                                <input type="text" class="form-control" id="name" value="&nbsp;">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label " for="">Dependencia</label>
                                                <select class="form-control" id="dependence" >
                                                    <option>Administración</option>
                                                    <option>Contaduría</option>
                                                    <option>Gerencia</option>
                                                    <option>Mercadeo</option>
                                                    <option>Tesorería</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mrg__top-10"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label " for="">Cargo</label>
                                                <input type="text" class="form-control" id="charge1" value="&nbsp;">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label " for="">Contrato</label>
                                                <input type="text" class="form-control" id="contract1" value="&nbsp;">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label " for="">Salario</label>
                                                <input type="text" class="form-control" id="salary1" value="&nbsp;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="mrg__top-30 red">
                            <!-- <div class="col-md-12 line"></div> -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label " for="">Dirección</label>
                                                <input type="text" class="form-control" id="address1" value="&nbsp;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label " for="">Número</label>
                                                <input type="text" class="form-control" id="number1" value="&nbsp;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <div class="form-group label-floating">
                                                    <label class="control-label " for="">Estado Civil</label>
                                                    <select class="form-control" id="dependence" >
                                                        <option>Unión libre</option>
                                                        <option>Casado (a)</option>
                                                        <option>Divorciado (a)</option>
                                                        <option>Viudo (a)</option>
                                                        <option>Soltero (a)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label " for="">Edad (años)</label>
                                                <input type="text" class="form-control" id="age1" value="&nbsp;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label " for="">Estado Laboral</label>
                                                <input type="text" class="form-control" id="working-status1" value="&nbsp;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label " for="">Fecha Inicio:</label>
                                                <input type="date" class="form-control" id="date-start1" value="2014-02-09">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label " for="">Fecha Final</label>
                                                <input type="date" class="form-control" id="date-end1" value="2014-02-09">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label " for="">Antigüedad (años)</label>
                                                <input type="text" class="form-control" id="antiquity1" value="&nbsp;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="competencesEdit">

                                <hr class="mrg__top-30 red">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="fnt__Bold redFont height-50">Competencias</h3>
                                    </div>
                                </div>

                                <ul id = "sortable-1"></ul>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-md buttonEdit" onclick=addItem()>
                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Añadir
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="mrg__top-30 red">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="align-middle">
                                        <button type="button" class="btn btn-lg buttonEdit">
                                            <span class="glyphicon glyphicon-save" aria-hidden="true"></span> Guardar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                            <div id="dependencesEdit">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="fnt__Bold redFont height-50">Listado de dependencias</h4>
                                    </div>
                                </div>

                                <ul id="listDependences"></ul>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-md buttonEdit" onclick=addItem()>
                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Añadir
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" id="paginationDependences">

                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination pagination-lg">
                                            <li class="page-item active"><a class="page-link" href="#">Previous</a></li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <hr class="mrg__top-30 red">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="align-middle">
                                        <button type="button" class="btn btn-lg buttonEdit">
                                            <span class="glyphicon glyphicon-save" aria-hidden="true"></span> Guardar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        //evitar heredar un recurso de calendarios
        bandera = 0;
        //CONVIERTO ARRAY PHP A JS PARA TRATAMIENTO DE DATOS
        var js_array =<?= json_encode($g);?>;
        var js_arrayemp =<?= json_encode($k);?>;
        var datosgrap=js_array;
        var datosemp=js_arrayemp;

        //console.log(js_array);

        function Warn() {

            var cargoenv = $( "#cargenv" ).val();

            if(cargoenv !== "000000001"){
                //console.log('bad');
                $.ajax({
                    cache: false,
                    type: 'POST',
                    url: '<?php echo Url::toRoute(['site/nomina']); ?>',
                    data: $("#compro-form").serialize(),

                    success: function(data){

                    },
                    /*  error: function(result) {
                          swal("Ops!", "Parece que tuvimos un problema al crear el organigrama, por favor reportalo con el administrador para darle solución. Gracias!", "error");
                      }*/
                });
            }else{
                swal("Error!", "Debes seleccionar un cargo antes de crearlo.", "warning");
            }
        };

        //CAPTURO VARAIBLE GET QUE VALIDA EMPLEADOS O NO
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }

        var getempleadosel = getParameterByName('empleadosel');
        var getcargenv = getParameterByName('cargenv');

        if(getcargenv.length == 0){
            getcargenv = 1;
        }

        function Downloadpptx(){

            $.ajax({
                cache: false,
                type: 'POST',
                url: '<?php echo Url::toRoute(['site/prueba', 'cargenv' => '']); ?>'+getcargenv,
                //data: $("#compro-form").serialize(),

                success: function(data){

                    setTimeout(function(){
                        //la ruta del archivo a descagar
                        var descargarForm = '<?= Url::toRoute(['site/descargarcppdf']); ?>';

                        //cabecera de la ruta dada
                        var http = new XMLHttpRequest();
                        http.open('HEAD', descargarForm, false);
                        http.send();
                        console.log(http);

                        // si el estado es 404 (no existe o no encontrado)
                        if (http.status == 404) {
                            //mensaje de error
                            swal("Error en la descarga","No se encuentra el archivo, favor comunicar con el administrador.","error");
                        }else{
                            //se descarga el archivo
                            window.location.href = descargarForm;
                            //swal("Descarga en progreso","El archivo ha comenzado a descargarse, revisa en tu carpeta de descargas.","success");
                        }
                    }, 1000);

                },
                error: function(result) {
                    swal("Ops!", "Parece que tuvimos un problema al crear el organigrama, por favor reportalo con el administrador para darle solución. Gracias!", "error");
                }
            });


        }

    </script>