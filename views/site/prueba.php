<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

// with your own install
require_once '../phpoffice/src/PhpPresentation/Autoloader.php';
\PhpOffice\PhpPresentation\Autoloader::register();
require_once '../phpoffice/src/Common/Autoloader.php';
\PhpOffice\Common\Autoloader::register();

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\DocumentLayout;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Border;
use PhpOffice\PhpPresentation\Shape\RichText\Paragraph;
use PhpOffice\PhpPresentation\Style\Bullet;

$objPHPPowerPoint = new PhpPresentation();

$arrayNvlPorc = $cantidadGrupos;

$paginador = 2;
$contempldir = 0;
$contemplservc = 0;

for ($i = 0; $i < count($resultado['SUB']); $i++) {
    if($resultado['SUB'][$i]!=0){
    $result_sub[] = $resultado['SUB'][$i];
    }
     //   $r = array_keys($resultado['COD_ESTRUCTURA'], $resultado['COD_ESTRUCTURA'][$i]);
      //  $p = array_keys($resultado['COD_EST_SUP'], $resultado['COD_ESTRUCTURA'][$i]);
    }


//var_dump(count($cantidadNiveles['NIVEL']));

for ($y = 0; $y < count($result_sub); $y++) {
}
    /*$primernivel = $y+1;
    $segundonivel = $y+2;

    $r = array_keys($resultado['NIVEL'],$primernivel);
    $p = array_keys($resultado['NIVEL'],$segundonivel);
    var_dump($r);*/

        $c = [
            'AREA'=> $resultado["NOM_OCUP"],
            'GRUPO_SALARIAL'=> $resultado["GRUPO_SALARIAL"],
            'CODIGO' => $resultado["COD_ESTRUCTURA"],
            'DEPENDENCIA' => $resultado["COD_EST_SUP"],
            'SUB' => $resultado["SUB"],
            'MODELO' => $resultado["NOM_TIP_OCUP"],
            'NOM_OCUP_SUP' => $resultado["NOM_OCUP_SUP"]
        ];

       // var_dump($c);

// ELIMINA DUPLICADOS
        $cniv = array_unique($c['GRUPO_SALARIAL']);
        //var_dump($cniv);
// ORDENA DE MENOR A MAYOR
        sort($cniv);
        sort($cantidadGrupos['CANTIDAD']);
        sort($cantidadNiveles['NIVEL']);
//var_dump($cantidadGrupos['CANTIDAD'][count($cantidadGrupos['CANTIDAD'])-1]);
//sort($c['DEPENDENCIA']);
//CONTEO DE ARRAYS PARA LOS FOR
        $cantidadniv = count($cniv);
       // var_dump($cantidadniv);
        $cantidadv = $cantidadGrupos['CANTIDAD'][count($cantidadGrupos['CANTIDAD'])-1];
//CANTIDAD DE DIAPOSITIVAS
        $cantidadNivelDos = array_search(2,$cantidadNiveles['NIVEL']);

        if(!$cantidadNivelDos){
            $cantidadNivelDos = 1;
        }else{
            $cantidadNivelDos = $cantidadNiveles['CANTIDAD'][$cantidadNivelDos];
        }
//DIMENSIONES
        $anchodm = 1500;
        $altodm = 1400;

        if ($cantidadv > 3){

            $anchodmtemp = floor($anchodm * 0..$cantidadv."00");
            $altodmtemp = floor($altodm * 0..$cantidadniv."00");
           // $anchodm = 5366.9;//$anchodm+$anchodmtemp;
           // $altodm = $altodm+$altodmtemp;

        };
/*
        if($cantidadGrupos['CANTIDAD'][count($cantidadGrupos['CANTIDAD'])-1] < 30){
            $anchodm = $cantidadGrupos['CANTIDAD'][count($cantidadGrupos['CANTIDAD'])-1] * 255.6;
        }else{
            $anchodm = 5366.9;
        }*/
//$currentSlide = $objPHPPowerPoint->createSlide();
//$objPHPPowerPoint->getLayout()->setDocumentLayout(DocumentLayout::LAYOUT_SCREEN_16X9);
        $objPHPPowerPoint->getLayout()->setDocumentLayout(['cx' => $anchodm, 'cy' => $altodm], true)
            ->setCX($anchodm, DocumentLayout::UNIT_PIXEL)
            ->setCY($altodm, DocumentLayout::UNIT_PIXEL);

        //CREAR DIAPOSITIVA 0
        $currentSlide = $objPHPPowerPoint->getActiveSlide();



// CREAR LOGO DE LA EMPRESA
    $anchologo = $anchodm-200;
    $shape = $currentSlide->createDrawingShape();
    $shape->setName('ECA logo')
        ->setDescription('ECA logo')
        ->setPath('./img/logo_e.png')
        ->setHeight(40)
        ->setOffsetX($anchologo)
        ->setOffsetY(30);

// CREAR COLORES DE LA EMPRESA
    $shape = $currentSlide->createDrawingShape();
    $shape->setName('ECA LATERAL')
        ->setDescription('ECA LATERAL')
        ->setPath('./img/Eca_color.png')
        ->setHeight(600)
        ->setOffsetX(-1)
        ->setOffsetY(-1);

//POSICION LINEA
    $ancholinea = floor($anchodm-20);
    $altolinea = floor($altodm-20);
//LINEA HORIZONTAL ARRIBA - LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
    $shape = $currentSlide->createLineShape(20, 30, $ancholinea, 30)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);
//LINEA HORIZONTAL DE ABAJO
    $shape = $currentSlide->createLineShape(20, $altolinea, $ancholinea, $altolinea)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);
//LINEA VERTICAL IZQUIERDA
    $shape = $currentSlide->createLineShape(20, 30, 20, $altolinea)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);
//LINEA VERTICAL BORDE DERECHO
    $shape = $currentSlide->createLineShape($ancholinea, 30, $ancholinea, $altolinea)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);
//LINEA VERTICAL IZQUIERDA NIVELES
    $shape = $currentSlide->createLineShape(40, 30, 40, $altolinea)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);

//POSICION TITULO
    $anchodmporc01 = floor($anchodm * 0.16);
    $anchodmresult01 = $anchodm-$anchodmporc01;
    $anchotitulo = floor($anchodmresult01/2);
// ASIGNAR POSICIONES DEL RECTANGULO
    $shape = $currentSlide->createRichTextShape()
        ->setHeight(20)
        ->setWidth(800)
        ->setOffsetX($anchotitulo-300)
        ->setOffsetY(4);
    $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
    $textRun = $shape->createTextRun( 'ORGANIGRAMA JERÁRQUICOS '.utf8_encode($c['NOM_OCUP_SUP'][0]));
    $textRun->getFont()->setBold(true)
        ->setSize(16)
        ->setColor( new Color( 'FF000000' ) );

    $shape = $currentSlide->createRichTextShape()
        ->setHeight(40)
        ->setWidth(120)
        ->setOffsetX(1360)
        ->setOffsetY(1348);
    $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $textRun = $shape->createTextRun("Diapositiva #1");
    $textRun->getFont()->setBold(true)
        ->setSize(11)
        ->setColor(new Color('FF000000'));

// LOGICA POSICIONES Y LINEAS
    $resultdivuno = floor($altodm/$cantidadniv);
    $resultdivdos = floor($resultdivuno/2);
    $resultdivtres = $resultdivdos;
    $posiciondiv = $resultdivuno;

//CICLO PARA NIVELES
    for ($i = 0; $i < $cantidadniv; $i++) {

// primer cuadro de texto contenido 50, 30, 50, 880
        $shape = $currentSlide->createRichTextShape()
            ->setHeight(40)
            ->setWidth(40)
            ->setOffsetX(10)
            ->setOffsetY($resultdivtres);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $textRun = $shape->createTextRun($cniv[$i]);
        $textRun->getFont()->setBold(true)
            ->setSize(16)
            ->setColor(new Color('FF000000'));

        if ($i < $cantidadniv - 1) {
//LINEA HORIZONTAL DE ABAJO
            $shape = $currentSlide->createLineShape(20, $posiciondiv, $ancholinea, $posiciondiv)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);
        }

        //GUARDO LAS POSICIONES DE LOS NIVELES EN Y
        $cnivposic[] = $resultdivtres - 90;
        $cnivposicsub[] = $resultdivtres + 31;
        //var_dump($resultdivtres);
        $posiciondiv = $resultdivuno + $posiciondiv;
        $resultdivtres = floor($resultdivuno + $resultdivtres);
   // }
    }

//CICLO PARA AREAS/CARGOS
    for ($i = 0; $i < count($c['GRUPO_SALARIAL']); $i++) {

        // LOGICA POSICIONES X CUADROS
        $anchodmporc = floor($anchodm * 0.07);
        $anchodmresult = $anchodm-$anchodmporc;
        $posicionsig = 126;
        $resultdivunoc = 70;
        $resultdivunocalto = 70;
        $resultdivdosc = 70;
        $resultdivdoscalto = 70;
        $resultdivtresc = 70;
        $resultdivtrescalto = 70;
        $resultdivcuatroc = 70;
        $resultdivcuatrocalto = 70;
        $resultdivcincoc = 70;
        $resultdivcincocalto = 70;


if($i==0){
    $j = [
        'AREA'=> $resultado["NOM_OCUP"],
        'GRUPO_SALARIAL'=> $resultado["GRUPO_SALARIAL"],
        'CODIGO' => $resultado["COD_ESTRUCTURA"],
        'DEPENDENCIA' => $resultado["COD_EST_SUP"],
        'SUB' => $resultado["SUB"],
        'MODELO' => $resultado["NOM_TIP_OCUP"],
        'NOM_OCUP_SUP' => $resultado["NOM_OCUP_SUP"],
    ];
}else{
    $j = [
        'AREA'=> $j["AREA"],
        'GRUPO_SALARIAL'=> $j["GRUPO_SALARIAL"],
        'CODIGO' => $j["CODIGO"],
        'DEPENDENCIA' => $j["DEPENDENCIA"],
        'SUB' => $j["SUB"],
        'MODELO' => $j["MODELO"],
        'NOM_OCUP_SUP' => $j["NOM_OCUP_SUP"]
    ];
}

        $clave = array_search($j['GRUPO_SALARIAL'][$i], $cniv);
        // var_dump($j);

        //if($c['SUB'][$i]!=0 && $i!=0){
        if($c['SUB'][$i]!=0){

            if($i!=0){
                //CREA NUEVA DIAPOSITIVA
                $currentSlide = $objPHPPowerPoint->createSlide();

                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(40)
                    ->setWidth(120)
                    ->setOffsetX(1360)
                    ->setOffsetY(1348);
                $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $textRun = $shape->createTextRun("Diapositiva #".$paginador++);
                $textRun->getFont()->setBold(true)
                    ->setSize(11)
                    ->setColor(new Color('FF000000'));

// CREAR LOGO DE LA EMPRESA
                $anchologo = $anchodm-200;
                $shape = $currentSlide->createDrawingShape();
                $shape->setName('ECA logo')
                    ->setDescription('ECA logo')
                    ->setPath('./img/logo_e.png')
                    ->setHeight(40)
                    ->setOffsetX($anchologo)
                    ->setOffsetY(30);

// CREAR COLORES DE LA EMPRESA
                $shape = $currentSlide->createDrawingShape();
                $shape->setName('ECA LATERAL')
                    ->setDescription('ECA LATERAL')
                    ->setPath('./img/Eca_color.png')
                    ->setHeight(600)
                    ->setOffsetX(-1)
                    ->setOffsetY(-1);

//POSICION LINEA
                $ancholinea = floor($anchodm-20);
                $altolinea = floor($altodm-20);
//LINEA HORIZONTAL ARRIBA - LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                $shape = $currentSlide->createLineShape(20, 30, $ancholinea, 30)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);
//LINEA HORIZONTAL DE ABAJO
                $shape = $currentSlide->createLineShape(20, $altolinea, $ancholinea, $altolinea)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);
//LINEA VERTICAL IZQUIERDA
                $shape = $currentSlide->createLineShape(20, 30, 20, $altolinea)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);
//LINEA VERTICAL BORDE DERECHO
                $shape = $currentSlide->createLineShape($ancholinea, 30, $ancholinea, $altolinea)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);
//LINEA VERTICAL IZQUIERDA NIVELES
                $shape = $currentSlide->createLineShape(40, 30, 40, $altolinea)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);

//POSICION TITULO
                $anchodmporc01 = floor($anchodm * 0.16);
                $anchodmresult01 = $anchodm-$anchodmporc01;
                $anchotitulo = floor($anchodmresult01/2);
// ASIGNAR POSICIONES DEL RECTANGULO
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(20)
                    ->setWidth(800)
                    ->setOffsetX($anchotitulo-300)
                    ->setOffsetY(4);
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun( 'ORGANIGRAMA JERÁRQUICO '.utf8_encode($j['NOM_OCUP_SUP'][$i]));
                $textRun->getFont()->setBold(true)
                    ->setSize(16)
                    ->setColor( new Color( 'FF000000' ) );


// LOGICA POSICIONES Y LINEAS
                $resultdivuno = floor($altodm/$cantidadniv);
                $resultdivdos = floor($resultdivuno/2);
                $resultdivtres = $resultdivdos;
                $posiciondiv = $resultdivuno;

//CICLO PARA NIVELES
                for ($h = 0; $h < $cantidadniv; $h++) {

// primer cuadro de texto contenido 50, 30, 50, 880
                    $shape = $currentSlide->createRichTextShape()
                        ->setHeight(40)
                        ->setWidth(40)
                        ->setOffsetX(10)
                        ->setOffsetY($resultdivtres);
                    $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                    if(empty($cniv[$h])){
                    $textRun = $shape->createTextRun("");
                    }else{
                        $textRun = $shape->createTextRun($cniv[$h]);
                    }
                    $textRun->getFont()->setBold(true)
                        ->setSize(16)
                        ->setColor( new Color( 'FF000000' ) );

                    if ($h < $cantidadniv-1){
//LINEA HORIZONTAL DE ABAJO
                        $shape = $currentSlide->createLineShape(20, $posiciondiv, $ancholinea, $posiciondiv)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);
                    }

                    //var_dump($resultdivtres);
                    $posiciondiv = $resultdivuno+$posiciondiv;
                    $resultdivtres = floor($resultdivuno+$resultdivtres);

                }

            }

            $validapadre = 0;

        switch ($j['GRUPO_SALARIAL'][$i]) {
            case "I":
                $validapadre = 1;
                // primer cuadro de texto contenido
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(80)
                    ->setWidth(130)
                    ->setOffsetX($anchotitulo)
                    ->setOffsetY($cnivposic[$clave]);
                if($j['MODELO'][$i]!="MODELO"){
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_DASH)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }else{
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun(utf8_encode($j['AREA'][$i]));
                $textRun->getFont()->setBold(true)
                    ->setSize(9)
                    ->setColor( new Color( 'FF000000' ) );
                if($empleadosel==1){
                    for ($u = 0; $u < count($cantidadEmpleados['COD_DEPENDENCIA']); $u++) {
                        if ($cantidadEmpleados['COD_DEPENDENCIA'][$u] == $j['CODIGO'][$i]) {
                            $shape->createParagraph()->createTextRun(utf8_encode($cantidadEmpleados['NOMBRE'][$u]))->getFont()->setBold(true)
                                ->setSize(7)
                                ->setColor(new Color(Color::COLOR_BLUE));
                        }
                    }
                }

                    for ($w = 0; $w < count($cantidadEmpleados['COD_DEPENDENCIA']); $w++) {
                        if ($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$i] && $j['MODELO'][$i] == "MODELO") {
                            $contempldir++;
                        }elseif($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$i] && $j['MODELO'][$i] != "MODELO"){
                            $contemplservc++;
                        }
                    }

                //LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                $shape = $currentSlide->createLineShape(60, $cnivposic[$clave]+40, $anchotitulo, $cnivposic[$clave]+40)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);

                $posicenxalt[] = $resultdivunocalto;
                $posicenypad = $cnivposic[$clave]+40;
                $resultdivunocalto = floor($posicionsig+$resultdivunocalto);
                break;
            case "II":
                $validapadre = 1;
                // primer cuadro de texto contenido
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(80)
                    ->setWidth(130)
                    ->setOffsetX($anchotitulo)
                    ->setOffsetY($cnivposic[$clave]-30);
                if($j['MODELO'][$i]!="MODELO"){
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_DASH)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }else{
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun(utf8_encode($j['AREA'][$i]));
                $textRun->getFont()->setBold(true)
                    ->setSize(9)
                    ->setColor( new Color( 'FF000000' ) );
                if($empleadosel==1){
                    for ($u = 0; $u < count($cantidadEmpleados['COD_DEPENDENCIA']); $u++) {
                        if ($cantidadEmpleados['COD_DEPENDENCIA'][$u] == $j['CODIGO'][$i]) {
                            $shape->createParagraph()->createTextRun(utf8_encode($cantidadEmpleados['NOMBRE'][$u]))->getFont()->setBold(true)
                                ->setSize(7)
                                ->setColor(new Color(Color::COLOR_BLUE));
                        }
                    }
                }

                for ($w = 0; $w < count($cantidadEmpleados['COD_DEPENDENCIA']); $w++) {
                    if ($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$i] && $j['MODELO'][$i] == "MODELO") {
                        $contempldir++;
                    }elseif($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$i] && $j['MODELO'][$i] != "MODELO"){
                        $contemplservc++;
                    }
                }

                //LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                $shape = $currentSlide->createLineShape(60, $cnivposic[$clave]+20, $anchotitulo, $cnivposic[$clave]+20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);

                $posicenxalt[] = $resultdivdoscalto;
                $posicenypad = $cnivposic[$clave]+20;

                $resultdivdoscalto = floor($posicionsig+$resultdivdoscalto);
                break;
            case "III":
                $validapadre = 1;
                // primer cuadro de texto contenido
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(80)
                    ->setWidth(130)
                    ->setOffsetX($anchotitulo)
                    ->setOffsetY($cnivposic[$clave]-30);
                if($j['MODELO'][$i]!="MODELO"){
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_DASH)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }else{
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun(utf8_encode($j['AREA'][$i]));
                $textRun->getFont()->setBold(true)
                    ->setSize(9)
                    ->setColor( new Color( 'FF000000' ) );
                if($empleadosel==1){
                    for ($u = 0; $u < count($cantidadEmpleados['COD_DEPENDENCIA']); $u++) {
                        if ($cantidadEmpleados['COD_DEPENDENCIA'][$u] == $j['CODIGO'][$i]) {
                            $shape->createParagraph()->createTextRun(utf8_encode($cantidadEmpleados['NOMBRE'][$u]))->getFont()->setBold(true)
                                ->setSize(7)
                                ->setColor(new Color(Color::COLOR_BLUE));
                        }
                    }
                }

                for ($w = 0; $w < count($cantidadEmpleados['COD_DEPENDENCIA']); $w++) {
                    if ($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$i] && $j['MODELO'][$i] == "MODELO") {
                        $contempldir++;
                    }elseif($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$i] && $j['MODELO'][$i] != "MODELO"){
                        $contemplservc++;
                    }
                }

                //LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                $shape = $currentSlide->createLineShape(60, $cnivposic[$clave]+20, $anchotitulo, $cnivposic[$clave]+20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);

                $posicenxalt[] = $resultdivtrescalto;
                $posicenypad = $cnivposic[$clave]+20;
                $resultdivtrescalto = floor($posicionsig+$resultdivtrescalto);
                break;
            case "IV":
                $validapadre = 1;
                // primer cuadro de texto contenido
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(80)
                    ->setWidth(130)
                    ->setOffsetX($anchotitulo)
                    ->setOffsetY($cnivposic[$clave]-30);
                if($j['MODELO'][$i]!="MODELO"){
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_DASH)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }else{
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun(utf8_encode($j['AREA'][$i]));
                $textRun->getFont()->setBold(true)
                    ->setSize(9)
                    ->setColor( new Color( 'FF000000' ) );
                if($empleadosel==1){
                    for ($u = 0; $u < count($cantidadEmpleados['COD_DEPENDENCIA']); $u++) {
                        if ($cantidadEmpleados['COD_DEPENDENCIA'][$u] == $j['CODIGO'][$i]) {
                            $shape->createParagraph()->createTextRun(utf8_encode($cantidadEmpleados['NOMBRE'][$u]))->getFont()->setBold(true)
                                ->setSize(7)
                                ->setColor(new Color(Color::COLOR_BLUE));
                        }
                    }
                }

                for ($w = 0; $w < count($cantidadEmpleados['COD_DEPENDENCIA']); $w++) {
                    if ($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$i] && $j['MODELO'][$i] == "MODELO") {
                        $contempldir++;
                    }elseif($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$i] && $j['MODELO'][$i] != "MODELO"){
                        $contemplservc++;
                    }
                }

                //LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                $shape = $currentSlide->createLineShape(60, $cnivposic[$clave]+20, $anchotitulo, $cnivposic[$clave]+20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);

                $posicenxalt[] = $resultdivcuatrocalto;
                $posicenypad = $cnivposic[$clave]+20;
                $resultdivcuatrocalto = floor($posicionsig+$resultdivcuatrocalto);
                break;
            case "V":
                $validapadre = 1;
                // primer cuadro de texto contenido
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(80)
                    ->setWidth(130)
                    ->setOffsetX($anchotitulo)
                    ->setOffsetY($cnivposic[$clave]-30);
                if($j['MODELO'][$i]!="MODELO"){
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_DASH)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }else{
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun(utf8_encode($j['AREA'][$i]));
                $textRun->getFont()->setBold(true)
                    ->setSize(9)
                    ->setColor( new Color( 'FF000000' ) );
                if($empleadosel==1){
                    for ($u = 0; $u < count($cantidadEmpleados['COD_DEPENDENCIA']); $u++) {
                        if ($cantidadEmpleados['COD_DEPENDENCIA'][$u] == $j['CODIGO'][$i]) {
                            $shape->createParagraph()->createTextRun(utf8_encode($cantidadEmpleados['NOMBRE'][$u]))->getFont()->setBold(true)
                                ->setSize(7)
                                ->setColor(new Color(Color::COLOR_BLUE));
                        }
                    }
                }

                for ($w = 0; $w < count($cantidadEmpleados['COD_DEPENDENCIA']); $w++) {
                    if ($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$i] && $j['MODELO'][$i] == "MODELO") {
                        $contempldir++;
                    }elseif($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$i] && $j['MODELO'][$i] != "MODELO"){
                        $contemplservc++;
                    }
                }

                //LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                $shape = $currentSlide->createLineShape(60, $cnivposic[$clave]+20, $anchotitulo, $cnivposic[$clave]+20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);

                $posicenxalt[] = $resultdivcincocalto;
                $posicenypad = $cnivposic[$clave]+20;
                $resultdivcincocalto = floor($posicionsig+$resultdivcincocalto);
                break;
            case NULL:
                $validapadre = 1;
                // primer cuadro de texto contenido
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(80)
                    ->setWidth(130)
                    ->setOffsetX($anchotitulo)
                    ->setOffsetY($cnivposic[$clave]+80);
                if($j['MODELO'][$i]!="MODELO"){
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_DASH)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }else{
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun(utf8_encode($j['AREA'][$i]));
                $textRun->getFont()->setBold(true)
                    ->setSize(9)
                    ->setColor( new Color( 'FF000000' ) );
                if($empleadosel==1){
                    for ($u = 0; $u < count($cantidadEmpleados['COD_DEPENDENCIA']); $u++) {
                        if ($cantidadEmpleados['COD_DEPENDENCIA'][$u] == $j['CODIGO'][$i]) {
                            $shape->createParagraph()->createTextRun(utf8_encode($cantidadEmpleados['NOMBRE'][$u]))->getFont()->setBold(true)
                                ->setSize(7)
                                ->setColor(new Color(Color::COLOR_BLUE));
                        }
                    }
                }

                for ($w = 0; $w < count($cantidadEmpleados['COD_DEPENDENCIA']); $w++) {
                    if ($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$i] && $j['MODELO'][$i] == "MODELO") {
                        $contempldir++;
                    }elseif($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$i] && $j['MODELO'][$i] != "MODELO"){
                        $contemplservc++;
                    }
                }

                $posicenxalt[] = $resultdivcincocalto;
                $posiceny[] = $cnivposic[$clave];
                $resultdivcincocalto = floor($posicionsig+$resultdivcincocalto);
                break;
        }



        for ($m = 0; $m < count($j['GRUPO_SALARIAL']); $m++) {

            //var_dump($j);
            if($j['DEPENDENCIA'][$m]==$j['CODIGO'][$i]){

                $clave = array_search($j['GRUPO_SALARIAL'][$m], $cniv);


                switch ($j['GRUPO_SALARIAL'][$m]) {
                    case "I":
                        // primer cuadro de texto contenido
                        $shape = $currentSlide->createRichTextShape()
                            ->setHeight(80)
                            ->setWidth(118)
                            ->setOffsetX($resultdivunoc)
                            ->setOffsetY($cnivposicsub[$clave]);
                        if($j['MODELO'][$m]!="MODELO"){
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_DASH)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }else{
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }
                        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                        $textRun = $shape->createTextRun(utf8_encode($j['AREA'][$m]));
                        $textRun->getFont()->setBold(true)
                            ->setSize(7)
                            ->setColor( new Color( 'FF000000' ) );
                        if($empleadosel==1){
                            for ($u = 0; $u < count($cantidadEmpleados['COD_DEPENDENCIA']); $u++) {
                                if ($cantidadEmpleados['COD_DEPENDENCIA'][$u] == $j['CODIGO'][$m]) {
                                    $shape->createParagraph()->createTextRun(utf8_encode($cantidadEmpleados['NOMBRE'][$u]))->getFont()->setBold(true)
                                        ->setSize(7)
                                        ->setColor(new Color(Color::COLOR_BLUE));
                                }
                            }
                        }

                        for ($w = 0; $w < count($cantidadEmpleados['COD_DEPENDENCIA']); $w++) {
                            if ($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$m] && $j['MODELO'][$m] == "MODELO") {
                                $contempldir++;
                            }elseif($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$m] && $j['MODELO'][$m] != "MODELO"){
                                $contemplservc++;
                            }
                        }
                        //LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                        $shape = $currentSlide->createLineShape($resultdivunoc+60, $cnivposicsub[$clave], $resultdivunoc+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);

                        $posicenx[] = $resultdivunoc;
                        $posicenyhij = $cnivposicsub[$clave]-20;
                        $resultdivunoc = floor($posicionsig+$resultdivunoc);

                        $ultpos = array_pop($posicenx);

//LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                        $shape = $currentSlide->createLineShape(60, $cnivposicsub[$clave]-20, $ultpos+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);
                      //  $shape = $currentSlide->createLineShape(130, $cnivposicsub[$clave]-20, $anchotitulo+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);

                        break;
                    case "II":
                        // primer cuadro de texto contenido
                        $shape = $currentSlide->createRichTextShape()
                            ->setHeight(80)
                            ->setWidth(118)
                            ->setOffsetX($resultdivdosc)
                            ->setOffsetY($cnivposicsub[$clave]);
                        if($j['MODELO'][$m]!="MODELO"){
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_DASH)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }else{
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }
                        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                        $textRun = $shape->createTextRun(utf8_encode($j['AREA'][$m]));
                        $textRun->getFont()->setBold(true)
                            ->setSize(7)
                            ->setColor( new Color( 'FF000000' ) );
                        if($empleadosel==1){
                            for ($u = 0; $u < count($cantidadEmpleados['COD_DEPENDENCIA']); $u++) {
                                if ($cantidadEmpleados['COD_DEPENDENCIA'][$u] == $j['CODIGO'][$m]) {
                                    $shape->createParagraph()->createTextRun(utf8_encode($cantidadEmpleados['NOMBRE'][$u]))->getFont()->setBold(true)
                                        ->setSize(7)
                                        ->setColor(new Color(Color::COLOR_BLUE));
                                }
                            }
                        }

                        for ($w = 0; $w < count($cantidadEmpleados['COD_DEPENDENCIA']); $w++) {
                            if ($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$m] && $j['MODELO'][$m] == "MODELO") {
                                $contempldir++;
                            }elseif($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$m] && $j['MODELO'][$m] != "MODELO"){
                                $contemplservc++;
                            }
                        }
                        //LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                        $shape = $currentSlide->createLineShape($resultdivdosc+60, $cnivposicsub[$clave], $resultdivdosc+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);

                        $posicenx[] = $resultdivdosc;
                        $posicenyhij = $cnivposicsub[$clave]-20;
                        $resultdivdosc = floor($posicionsig+$resultdivdosc);

                        $ultpos = array_pop($posicenx);

//LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                        $shape = $currentSlide->createLineShape(60, $cnivposicsub[$clave]-20, $ultpos+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);
                       // $shape = $currentSlide->createLineShape(130, $cnivposicsub[$clave]-20, $anchotitulo+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);

                        break;
                    case "III":
                        // primer cuadro de texto contenido
                        $shape = $currentSlide->createRichTextShape()
                            ->setHeight(80)
                            ->setWidth(118)
                            ->setOffsetX($resultdivtresc)
                            ->setOffsetY($cnivposicsub[$clave]);
                        if($j['MODELO'][$m]!="MODELO"){
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_DASH)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }else{
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }
                        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                        $textRun = $shape->createTextRun(utf8_encode($j['AREA'][$m]));
                        $textRun->getFont()->setBold(true)
                            ->setSize(7)
                            ->setColor( new Color( 'FF000000' ) );
                        if($empleadosel==1){
                            for ($u = 0; $u < count($cantidadEmpleados['COD_DEPENDENCIA']); $u++) {
                                if ($cantidadEmpleados['COD_DEPENDENCIA'][$u] == $j['CODIGO'][$m]) {
                                    $shape->createParagraph()->createTextRun(utf8_encode($cantidadEmpleados['NOMBRE'][$u]))->getFont()->setBold(true)
                                        ->setSize(7)
                                        ->setColor(new Color(Color::COLOR_BLUE));
                                }
                            }
                        }

                        for ($w = 0; $w < count($cantidadEmpleados['COD_DEPENDENCIA']); $w++) {
                            if ($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$m] && $j['MODELO'][$m] == "MODELO") {
                                $contempldir++;
                            }elseif($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$m] && $j['MODELO'][$m] != "MODELO"){
                                $contemplservc++;
                            }
                        }
                        //LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                        $shape = $currentSlide->createLineShape($resultdivtresc+60, $cnivposicsub[$clave], $resultdivtresc+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);

                        $posicenx[] = $resultdivtresc;
                        $posicenyhij = $cnivposicsub[$clave]-20;
                        $resultdivtresc = floor($posicionsig+$resultdivtresc);

                        $ultpos = array_pop($posicenx);

//LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                        $shape = $currentSlide->createLineShape(60, $cnivposicsub[$clave]-20, $ultpos+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);
                       // $shape = $currentSlide->createLineShape(130, $cnivposicsub[$clave]-20, $anchotitulo+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);

                        break;
                    case "IV":
                        // primer cuadro de texto contenido
                        $shape = $currentSlide->createRichTextShape()
                            ->setHeight(80)
                            ->setWidth(118)
                            ->setOffsetX($resultdivcuatroc)
                            ->setOffsetY($cnivposicsub[$clave]);
                        if($j['MODELO'][$m]!="MODELO"){
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_DASH)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }else{
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }
                        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                        $textRun = $shape->createTextRun(utf8_encode($j['AREA'][$m]));
                        $textRun->getFont()->setBold(true)
                            ->setSize(7)
                            ->setColor( new Color( 'FF000000' ) );
                        if($empleadosel==1){
                            for ($u = 0; $u < count($cantidadEmpleados['COD_DEPENDENCIA']); $u++) {
                                if ($cantidadEmpleados['COD_DEPENDENCIA'][$u] == $j['CODIGO'][$m]) {
                                    $shape->createParagraph()->createTextRun(utf8_encode($cantidadEmpleados['NOMBRE'][$u]))->getFont()->setBold(true)
                                        ->setSize(7)
                                        ->setColor(new Color(Color::COLOR_BLUE));
                                }
                            }
                        }

                        for ($w = 0; $w < count($cantidadEmpleados['COD_DEPENDENCIA']); $w++) {
                            if ($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$m] && $j['MODELO'][$m] == "MODELO") {
                                $contempldir++;
                            }elseif($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$m] && $j['MODELO'][$m] != "MODELO"){
                                $contemplservc++;
                            }
                        }
                        //LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                        $shape = $currentSlide->createLineShape($resultdivcuatroc+60, $cnivposicsub[$clave], $resultdivcuatroc+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);

                        $posicenx[] = $resultdivcuatroc;
                        $posicenyhij = $cnivposicsub[$clave]-20;
                        $resultdivcuatroc = floor($posicionsig+$resultdivcuatroc);

                        $ultpos = array_pop($posicenx);

//LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                        $shape = $currentSlide->createLineShape(60, $cnivposicsub[$clave]-20, $ultpos+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);
                        //$shape = $currentSlide->createLineShape(130, $cnivposicsub[$clave]-20, $anchotitulo+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);

                        break;
                    case "V":
                        // primer cuadro de texto contenido
                        $shape = $currentSlide->createRichTextShape()
                            ->setHeight(80)
                            ->setWidth(118)
                            ->setOffsetX($resultdivcincoc)
                            ->setOffsetY($cnivposicsub[$clave]-20);
                        if($j['MODELO'][$m]!="MODELO"){
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_DASH)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }else{
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }
                        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                        $textRun = $shape->createTextRun(utf8_encode($j['AREA'][$m]));
                        $textRun->getFont()->setBold(true)
                            ->setSize(7)
                            ->setColor( new Color( 'FF000000' ) );
                        if($empleadosel==1){
                            for ($u = 0; $u < count($cantidadEmpleados['COD_DEPENDENCIA']); $u++) {
                                if ($cantidadEmpleados['COD_DEPENDENCIA'][$u] == $j['CODIGO'][$m]) {
                                    $shape->createParagraph()->createTextRun(utf8_encode($cantidadEmpleados['NOMBRE'][$u]))->getFont()->setBold(true)
                                        ->setSize(7)
                                        ->setColor(new Color(Color::COLOR_BLUE));
                                }
                            }
                        }

                        for ($w = 0; $w < count($cantidadEmpleados['COD_DEPENDENCIA']); $w++) {
                            if ($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$m] && $j['MODELO'][$m] == "MODELO") {
                                $contempldir++;
                            }elseif($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$m] && $j['MODELO'][$m] != "MODELO"){
                                $contemplservc++;
                            }
                        }
                        //LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                        $shape = $currentSlide->createLineShape($resultdivcincoc+60, $cnivposicsub[$clave]-20, $resultdivcincoc+60, $cnivposicsub[$clave]-40)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);

                        $posicenx[] = $resultdivcincoc;
                        $posicenyhij = $cnivposicsub[$clave]-40;
                        $resultdivcincoc = floor($posicionsig+$resultdivcincoc);

                        $ultpos = array_pop($posicenx);

//LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                        $shape = $currentSlide->createLineShape(60, $cnivposicsub[$clave]-40, $ultpos+60, $cnivposicsub[$clave]-40)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);
                       // $shape = $currentSlide->createLineShape(130, $cnivposicsub[$clave]-40, $anchotitulo+60, $cnivposicsub[$clave]-40)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);

                        break;
                    case NULL:
                        // primer cuadro de texto contenido
                        $shape = $currentSlide->createRichTextShape()
                            ->setHeight(80)
                            ->setWidth(118)
                            ->setOffsetX($resultdivcincoc)
                            ->setOffsetY($cnivposic[$clave]+80);
                        if($j['MODELO'][$m]!="MODELO"){
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_DASH)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }else{
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }
                        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                        $textRun = $shape->createTextRun(utf8_encode($j['AREA'][$m]));
                        $textRun->getFont()->setBold(true)
                            ->setSize(7)
                            ->setColor( new Color( 'FF000000' ) );
                        if($empleadosel==1){
                            for ($u = 0; $u < count($cantidadEmpleados['COD_DEPENDENCIA']); $u++) {
                                if ($cantidadEmpleados['COD_DEPENDENCIA'][$u] == $j['CODIGO'][$m]) {
                                    $shape->createParagraph()->createTextRun(utf8_encode($cantidadEmpleados['NOMBRE'][$u]))->getFont()->setBold(true)
                                        ->setSize(7)
                                        ->setColor(new Color(Color::COLOR_BLUE));
                                }
                            }
                        }

                        for ($w = 0; $w < count($cantidadEmpleados['COD_DEPENDENCIA']); $w++) {
                            if ($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$m] && $j['MODELO'][$m] == "MODELO") {
                                $contempldir++;
                            }elseif($cantidadEmpleados['COD_DEPENDENCIA'][$w] == $j['CODIGO'][$m] && $j['MODELO'][$m] != "MODELO"){
                                $contemplservc++;
                            }
                        }
                        //LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                        $shape = $currentSlide->createLineShape($resultdivunoc+60, $cnivposicsub[$clave], $resultdivunoc+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);

                        $posicenx[] = $resultdivcincoc;
                        $posiceny[] = $cnivposic[$clave];
                        $resultdivcincoc = floor($posicionsig+$resultdivcincoc);

                        $ultpos = array_pop($posicenx);

//LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
                        $shape = $currentSlide->createLineShape(60, $cnivposicsub[$clave]-20, $ultpos+60, $cnivposicsub[$clave]-20)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);

                        break;
                }

            }

        }

            $shape = $currentSlide->createRichTextShape()
                ->setHeight(30)
                ->setWidth(60)
                ->setOffsetX(1230)
                ->setOffsetY(35);
            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
            $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
            $textRun = $shape->createTextRun($contempldir);
            $textRun->getFont()->setBold(true)
                ->setSize(12)
                ->setColor( new Color( 'FF000000' ) );

            $shape = $currentSlide->createRichTextShape()
                ->setHeight(30)
                ->setWidth(60)
                ->setOffsetX(1230)
                ->setOffsetY(70);
            $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_DASH)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
            $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
            $textRun = $shape->createTextRun($contemplservc);
            $textRun->getFont()->setBold(true)
                ->setSize(12)
                ->setColor( new Color( 'FF000000' ) );

            //LARGO IZQUIERDA, POSICION ALTO IZQUIERDA, LARGO DERECHA, POSICION ALTO DERECHA
            $shape = $currentSlide->createLineShape(60, $posicenyhij, 60, $posicenypad)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(2);
        }
      /*  unset($j['AREA'][$i]);
        unset($j['GRUPO_SALARIAL'][$i]);
        unset($j['CODIGO'][$i]);
        unset($j['DEPENDENCIA'][$i]);*/

        $contempldir = 0;
        $contemplservc = 0;

        $j['CODIGO'][$i]="NADA";
        $j['DEPENDENCIA'][$i]="NADA";

    }


    //FIN DIAPO

$oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
$oWriterPPTX->save("../phpoffice/results/organigrama.pptx");

?>