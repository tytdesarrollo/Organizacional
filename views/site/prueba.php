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
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;

$objPHPPowerPoint = new PhpPresentation();

// Create slide
$currentSlide = $objPHPPowerPoint->getActiveSlide();

// Create a shape (drawing)
$shape = $currentSlide->createDrawingShape();
$shape->setName('PHPPresentation logo')
    ->setDescription('PHPPresentation logo')
    ->setPath('../phpoffice/samples/resources/phppowerpoint_logo.gif')
    ->setHeight(36)
    ->setOffsetX(10)
    ->setOffsetY(10);
$shape->getShadow()->setVisible(true)
    ->setDirection(45)
    ->setDistance(10);

// Create a shape (text)
$shape = $currentSlide->createRichTextShape()
    ->setHeight(300)
    ->setWidth(600)
    ->setOffsetX(170)
    ->setOffsetY(180);
$shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
$textRun = $shape->createTextRun('Thank you for using PHPPresentation!');
$textRun->getFont()->setBold(true)
    ->setSize(60)
    ->setColor( new Color( 'FFE06B20' ) );

$oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
$oWriterPPTX->save("../phpoffice/results/sample.pptx");
//$oWriterODP = IOFactory::createWriter($objPHPPowerPoint, 'ODPresentation');
//$oWriterODP->save("../phpoffice/results/sample.odp");
?>