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

var_dump($resultado);

$c = [
    'AREA'=> $resultado["NOM_OCUP_SUP"],
    'NIVEL'=> $resultado["NIVEL"],
    'CODIGO' => $resultado["COD_ESTRUCTURA"],
    'DEPENDENCIA' => $resultado["COD_EST_SUP"]
];

// ELIMINA DUPLICADOS
$cniv = array_unique($c['NIVEL']);
// ORDENA DE MENOR A MAYOR
sort($cniv);
//sort($c['DEPENDENCIA']);
//CONTEO DE ARRAYS PARA LOS FOR
$cantidadniv = count($cniv);
$cantidadv = count($c['AREA']);
//DIMENSIONES
$anchodm = 1300;
$altodm = 900;

//var_dump($c['DEPENDENCIA'][0]);

    if ($cantidadv > 3){

        $anchodmtemp = floor($anchodm * 0..$cantidadv."00");
        $altodmtemp = floor($altodm * 0..$cantidadniv."00");
        $anchodm = $anchodm+$anchodmtemp;
        $altodm = $altodm+$altodmtemp;

    };

//$objPHPPowerPoint->getLayout()->setDocumentLayout(DocumentLayout::LAYOUT_SCREEN_16X9);
$objPHPPowerPoint->getLayout()->setDocumentLayout(['cx' => $anchodm, 'cy' => $altodm], true)
    ->setCX($anchodm, DocumentLayout::UNIT_PIXEL)
    ->setCY($altodm, DocumentLayout::UNIT_PIXEL);
// Create slide0
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
$shape = $currentSlide->createLineShape(60, 30, 60, $altolinea)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);

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
$textRun = $shape->createTextRun( 'ORGANIGRAMA JERÁRQUICO');
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
        ->setHeight(60)
        ->setWidth(60)
        ->setOffsetX(10)
        ->setOffsetY($resultdivtres);
    $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
    $textRun = $shape->createTextRun($cniv[$i]);
    $textRun->getFont()->setBold(true)
        ->setSize(18)
        ->setColor( new Color( 'FF000000' ) );

    if ($i < $cantidadniv-1){
//LINEA HORIZONTAL DE ABAJO
        $shape = $currentSlide->createLineShape(20, $posiciondiv, $ancholinea, $posiciondiv)->getBorder()->setColor(new Color(Color::COLOR_DARKBLUE))->setLineWidth(1);
    }

    //GUARDO LAS POSICIONES DE LOS NIVELES EN Y
    $cnivposic[] = $resultdivtres;
    //var_dump($resultdivtres);
    $posiciondiv = $resultdivuno+$posiciondiv;
    $resultdivtres = floor($resultdivuno+$resultdivtres);

}
//var_dump($cnivpush);
// LOGICA POSICIONES X CUADROS
$anchodmporc = floor($anchodm * 0.07);
$anchodmresult = $anchodm-$anchodmporc;
$resultdivuno = floor($anchodmresult/$cantidadv);
$resultdivdos = floor($resultdivuno/2);

$resultdivunoc = $resultdivdos;
$resultdivdosc = $resultdivdos;
$resultdivtresc = $resultdivdos;
$resultdivcuatroc = $resultdivdos;
$resultdivcincoc = $resultdivdos;

//CICLO PARA AREAS/CARGOS
for ($i = 0; $i < $cantidadv; $i++) {
    //CONTEO DE CARACTERES
    //$caractcont = strlen ($c['DEPENDENCIA'][$i]);
//var_dump($caractcont);

    $clave = array_search($c['NIVEL'][$i], $cniv);
   // var_dump($cnivposic);

    switch ($c['NIVEL'][$i]) {
        case 1:
            // primer cuadro de texto contenido
            $shape = $currentSlide->createRichTextShape()
                ->setHeight(50)
                ->setWidth(100)
                ->setOffsetX($resultdivunoc)
                ->setOffsetY($cnivposic[$clave]);
            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
            $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
            $textRun = $shape->createTextRun($c['AREA'][$i]);
            $textRun->getFont()->setBold(true)
                ->setSize(11)
                ->setColor( new Color( 'FF000000' ) );

            $posicenx[] = $resultdivunoc;
            $posiceny[] = $cnivposic[$clave];
            $resultdivunoc = floor($resultdivuno+$resultdivunoc);
            break;
        case 2:
            // primer cuadro de texto contenido
            $shape = $currentSlide->createRichTextShape()
                ->setHeight(50)
                ->setWidth(100)
                ->setOffsetX($resultdivdosc)
                ->setOffsetY($cnivposic[$clave]);
            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
            $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
            $textRun = $shape->createTextRun($c['AREA'][$i]);
            $textRun->getFont()->setBold(true)
                ->setSize(11)
                ->setColor( new Color( 'FF000000' ) );

            $posicenx[] = $resultdivdosc;
            $posiceny[] = $cnivposic[$clave];
            $resultdivdosc = floor($resultdivuno+$resultdivdosc);
            break;
        case 3:
            // primer cuadro de texto contenido
            $shape = $currentSlide->createRichTextShape()
                ->setHeight(50)
                ->setWidth(100)
                ->setOffsetX($resultdivtresc)
                ->setOffsetY($cnivposic[$clave]);
            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
            $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
            $textRun = $shape->createTextRun($c['AREA'][$i]);
            $textRun->getFont()->setBold(true)
                ->setSize(11)
                ->setColor( new Color( 'FF000000' ) );

            $posicenx[] = $resultdivtresc;
            $posiceny[] = $cnivposic[$clave];
            $resultdivtresc = floor($resultdivuno+$resultdivtresc);
            break;
        case 4:
            // primer cuadro de texto contenido
            $shape = $currentSlide->createRichTextShape()
                ->setHeight(50)
                ->setWidth(100)
                ->setOffsetX($resultdivcuatroc)
                ->setOffsetY($cnivposic[$clave]);
            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
            $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
            $textRun = $shape->createTextRun($c['AREA'][$i]);
            $textRun->getFont()->setBold(true)
                ->setSize(11)
                ->setColor( new Color( 'FF000000' ) );

            $posicenx[] = $resultdivcuatroc;
            $posiceny[] = $cnivposic[$clave];
            $resultdivcuatroc = floor($resultdivuno+$resultdivcuatroc);
            break;
        case 5:
            // primer cuadro de texto contenido
            $shape = $currentSlide->createRichTextShape()
                ->setHeight(50)
                ->setWidth(100)
                ->setOffsetX($resultdivcincoc)
                ->setOffsetY($cnivposic[$clave]);
            $shape->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setDashStyle(Border::DASH_SOLID)->setLineStyle(Border::LINE_SINGLE)->setLineWidth(2);
            $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
            $textRun = $shape->createTextRun($c['AREA'][$i]);
            $textRun->getFont()->setBold(true)
                ->setSize(11)
                ->setColor( new Color( 'FF000000' ) );

            $posicenx[] = $resultdivcincoc;
            $posiceny[] = $cnivposic[$clave];
            $resultdivcincoc = floor($resultdivuno+$resultdivcincoc);
            break;
    }
}

//CICLO PARA PINTAR LAS LINEAS

for ($i = 0; $i < $cantidadv; $i++) {

    for($j = 0; $j < $cantidadv; $j++){
        if($c['CODIGO'][$i] == $c['DEPENDENCIA'][$j]){
            $shape = $currentSlide->createLineShape($posicenx[$i], $posiceny[$i], $posicenx[$j], $posiceny[$j])->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setLineWidth(1);
        }
    }

  //  var_dump($posicenx[$i]);
    //var_dump($cnivposic[$clave]);

}

/*
//SE CREAN LAS LINEAS HASTA LA PRIMER UNIDAD
$shape = $currentSlide->createLineShape(475, 110, 475, 200)->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setLineWidth(1);
$shape = $currentSlide->createLineShape(80, 200, 475, 200)->getBorder()->setColor(new Color(Color::COLOR_BLACK))->setLineWidth(1);
*/
//CREA NUEVA DIAPOSITIVA
//$currentSlide = $objPHPPowerPoint->createSlide();

$oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
$oWriterPPTX->save("../phpoffice/results/organigrama.pptx");

?>