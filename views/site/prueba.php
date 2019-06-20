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



//CICLO PARA PINTAR LAS LINEAS
/*
for ($n = 0; $n < count($c['GRUPO_SALARIAL']); $n++) {

    for($u = 0; $u < count($c['GRUPO_SALARIAL']); $u++){
        if($c['CODIGO'][$n] == $c['DEPENDENCIA'][$u]){
            $shape = $currentSlide->createLineShape($posicenx[$n], $posiceny[$n], $posicenx[$u], $posiceny[$u])->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setLineWidth(1);
        }
    }

  //  var_dump($posicenx[$i]);
    //var_dump($cnivposic[$clave]);

}*/

/*
//SE CREAN LAS LINEAS HASTA LA PRIMER UNIDAD
$shape = $currentSlide->createLineShape(475, 110, 475, 200)->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setLineWidth(1);
$shape = $currentSlide->createLineShape(80, 200, 475, 200)->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setLineWidth(1);
*/
//$result_sub=array();

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
            'MODELO' => $resultado["NOM_TIP_OCUP"]
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
        ->setWidth(300)
        ->setOffsetX($anchotitulo)
        ->setOffsetY(4);
    $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
    $textRun = $shape->createTextRun( 'ORGANIGRAMA JERÁRQUICOS');
    $textRun->getFont()->setBold(true)
        ->setSize(16)
        ->setColor( new Color( 'FF000000' ) );

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
        $posicionsig = 140;
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
        'MODELO' => $resultado["NOM_TIP_OCUP"]
    ];
}else{
    $j = [
        'AREA'=> $j["AREA"],
        'GRUPO_SALARIAL'=> $j["GRUPO_SALARIAL"],
        'CODIGO' => $j["CODIGO"],
        'DEPENDENCIA' => $j["DEPENDENCIA"],
        'SUB' => $j["SUB"],
        'MODELO' => $j["MODELO"]
    ];
}

        $clave = array_search($j['GRUPO_SALARIAL'][$i], $cniv);
        // var_dump($j);

        //if($c['SUB'][$i]!=0 && $i!=0){
        if($c['SUB'][$i]!=0){

            if($i!=0){
                //CREA NUEVA DIAPOSITIVA
                $currentSlide = $objPHPPowerPoint->createSlide();


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
                    ->setWidth(300)
                    ->setOffsetX($anchotitulo)
                    ->setOffsetY(4);
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun( 'ORGANIGRAMA JERÁRQUICOS');
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

        switch ($j['GRUPO_SALARIAL'][$i]) {
            case "I":
                // primer cuadro de texto contenido
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(80)
                    ->setWidth(130)
                    ->setOffsetX($anchotitulo)
                    ->setOffsetY($cnivposic[$clave]);
                if($j['MODELO'][$i]!="MODELO"){
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }else{
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun($j['AREA'][$i]);
                $textRun->getFont()->setBold(true)
                    ->setSize(9)
                    ->setColor( new Color( 'FF000000' ) );

                $posicenxalt[] = $resultdivunocalto;
                $posiceny[] = $cnivposic[$clave];
                $resultdivunocalto = floor($posicionsig+$resultdivunocalto);
                break;
            case "II":
                // primer cuadro de texto contenido
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(80)
                    ->setWidth(130)
                    ->setOffsetX($anchotitulo)
                    ->setOffsetY($cnivposic[$clave]-30);
                if($j['MODELO'][$i]!="MODELO"){
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }else{
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun($j['AREA'][$i]);
                $textRun->getFont()->setBold(true)
                    ->setSize(9)
                    ->setColor( new Color( 'FF000000' ) );

                $posicenxalt[] = $resultdivdoscalto;
                $posiceny[] = $cnivposic[$clave];

                $resultdivdoscalto = floor($posicionsig+$resultdivdoscalto);
                break;
            case "III":
                // primer cuadro de texto contenido
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(80)
                    ->setWidth(130)
                    ->setOffsetX($anchotitulo)
                    ->setOffsetY($cnivposic[$clave]-30);
                if($j['MODELO'][$i]!="MODELO"){
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }else{
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun($j['AREA'][$i]);
                $textRun->getFont()->setBold(true)
                    ->setSize(9)
                    ->setColor( new Color( 'FF000000' ) );

                $posicenxalt[] = $resultdivtrescalto;
                $posiceny[] = $cnivposic[$clave];
                $resultdivtrescalto = floor($posicionsig+$resultdivtrescalto);
                break;
            case "IV":
                // primer cuadro de texto contenido
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(80)
                    ->setWidth(130)
                    ->setOffsetX($anchotitulo)
                    ->setOffsetY($cnivposic[$clave]-30);
                if($j['MODELO'][$i]!="MODELO"){
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }else{
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun($j['AREA'][$i]);
                $textRun->getFont()->setBold(true)
                    ->setSize(9)
                    ->setColor( new Color( 'FF000000' ) );

                $posicenxalt[] = $resultdivcuatrocalto;
                $posiceny[] = $cnivposic[$clave];
                $resultdivcuatrocalto = floor($posicionsig+$resultdivcuatrocalto);
                break;
            case "V":
                // primer cuadro de texto contenido
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(80)
                    ->setWidth(130)
                    ->setOffsetX($anchotitulo)
                    ->setOffsetY($cnivposic[$clave]-30);
                if($j['MODELO'][$i]!="MODELO"){
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }else{
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun($j['AREA'][$i]);
                $textRun->getFont()->setBold(true)
                    ->setSize(9)
                    ->setColor( new Color( 'FF000000' ) );

                $posicenxalt[] = $resultdivcincocalto;
                $posiceny[] = $cnivposic[$clave];
                $resultdivcincocalto = floor($posicionsig+$resultdivcincocalto);
                break;
            case NULL:
                // primer cuadro de texto contenido
                $shape = $currentSlide->createRichTextShape()
                    ->setHeight(80)
                    ->setWidth(130)
                    ->setOffsetX($anchotitulo)
                    ->setOffsetY($cnivposic[$clave]+80);
                if($j['MODELO'][$i]!="MODELO"){
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }else{
                    $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                }
                $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                $textRun = $shape->createTextRun($j['AREA'][$i]);
                $textRun->getFont()->setBold(true)
                    ->setSize(9)
                    ->setColor( new Color( 'FF000000' ) );

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
                            ->setWidth(130)
                            ->setOffsetX($resultdivunoc)
                            ->setOffsetY($cnivposicsub[$clave]);
                        if($j['MODELO'][$m]!="MODELO"){
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }else{
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }
                        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                        $textRun = $shape->createTextRun($j['AREA'][$m]);
                        $textRun->getFont()->setBold(true)
                            ->setSize(9)
                            ->setColor( new Color( 'FF000000' ) );

                        $posicenx[] = $resultdivunoc;
                        $posiceny[] = $cnivposicsub[$clave];
                        $resultdivunoc = floor($posicionsig+$resultdivunoc);
                        break;
                    case "II":
                        // primer cuadro de texto contenido
                        $shape = $currentSlide->createRichTextShape()
                            ->setHeight(80)
                            ->setWidth(130)
                            ->setOffsetX($resultdivdosc)
                            ->setOffsetY($cnivposicsub[$clave]);
                        if($j['MODELO'][$m]!="MODELO"){
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }else{
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }
                        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                        $textRun = $shape->createTextRun($j['AREA'][$m]);
                        $textRun->getFont()->setBold(true)
                            ->setSize(9)
                            ->setColor( new Color( 'FF000000' ) );

                        $posicenx[] = $resultdivdosc;
                        $posiceny[] = $cnivposicsub[$clave];

                        $resultdivdosc = floor($posicionsig+$resultdivdosc);
                        break;
                    case "III":
                        // primer cuadro de texto contenido
                        $shape = $currentSlide->createRichTextShape()
                            ->setHeight(80)
                            ->setWidth(130)
                            ->setOffsetX($resultdivtresc)
                            ->setOffsetY($cnivposicsub[$clave]);
                        if($j['MODELO'][$m]!="MODELO"){
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }else{
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }
                        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                        $textRun = $shape->createTextRun($j['AREA'][$m]);
                        $textRun->getFont()->setBold(true)
                            ->setSize(7)
                            ->setColor( new Color( 'FF000000' ) );
                        $shape->createParagraph()->createTextRun('Showasdasdsa a family slide show')->getFont()->setBold(true)
                            ->setSize(7)
                            ->setColor( new Color( Color::COLOR_BLUE ) );

                        $posicenx[] = $resultdivtresc;
                        $posiceny[] = $cnivposicsub[$clave];
                        $resultdivtresc = floor($posicionsig+$resultdivtresc);
                        break;
                    case "IV":
                        // primer cuadro de texto contenido
                        $shape = $currentSlide->createRichTextShape()
                            ->setHeight(80)
                            ->setWidth(130)
                            ->setOffsetX($resultdivcuatroc)
                            ->setOffsetY($cnivposicsub[$clave]);
                        if($j['MODELO'][$m]!="MODELO"){
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }else{
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }
                        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                        $textRun = $shape->createTextRun($j['AREA'][$m]);
                        $textRun->getFont()->setBold(true)
                            ->setSize(9)
                            ->setColor( new Color( 'FF000000' ) );

                        $posicenx[] = $resultdivcuatroc;
                        $posiceny[] = $cnivposicsub[$clave];
                        $resultdivcuatroc = floor($posicionsig+$resultdivcuatroc);
                        break;
                    case "V":
                        // primer cuadro de texto contenido
                        $shape = $currentSlide->createRichTextShape()
                            ->setHeight(80)
                            ->setWidth(130)
                            ->setOffsetX($resultdivcincoc)
                            ->setOffsetY($cnivposicsub[$clave]-20);
                        if($j['MODELO'][$m]!="MODELO"){
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }else{
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }
                        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                        $textRun = $shape->createTextRun($j['AREA'][$m]);
                        $textRun->getFont()->setBold(true)
                            ->setSize(9)
                            ->setColor( new Color( 'FF000000' ) );

                        $posicenx[] = $resultdivcincoc;
                        $posiceny[] = $cnivposicsub[$clave];
                        $resultdivcincoc = floor($posicionsig+$resultdivcincoc);
                        break;
                    case NULL:
                        // primer cuadro de texto contenido
                        $shape = $currentSlide->createRichTextShape()
                            ->setHeight(80)
                            ->setWidth(130)
                            ->setOffsetX($resultdivcincoc)
                            ->setOffsetY($cnivposic[$clave]+80);
                        if($j['MODELO'][$m]!="MODELO"){
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLUE))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }else{
                            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
                        }
                        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
                        $textRun = $shape->createTextRun($j['AREA'][$m]);
                        $textRun->getFont()->setBold(true)
                            ->setSize(9)
                            ->setColor( new Color( 'FF000000' ) );

                        $posicenx[] = $resultdivcincoc;
                        $posiceny[] = $cnivposic[$clave];
                        $resultdivcincoc = floor($posicionsig+$resultdivcincoc);
                        break;
                }
            }
        }



        }
      /*  unset($j['AREA'][$i]);
        unset($j['GRUPO_SALARIAL'][$i]);
        unset($j['CODIGO'][$i]);
        unset($j['DEPENDENCIA'][$i]);*/



        $j['CODIGO'][$i]="NADA";
        $j['DEPENDENCIA'][$i]="NADA";

    }
    /*
var_dump($c['AREA'][0]);
unset($c['AREA'][0]);
unset($c['GRUPO_SALARIAL'][0]);
unset($c['CODIGO'][0]);
unset($c['DEPENDENCIA'][0]);
var_dump($c);
*/
    //FIN DIAPO





$oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
$oWriterPPTX->save("../phpoffice/results/organigrama.pptx");

?>