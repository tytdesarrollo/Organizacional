<?php

set_time_limit(10);

include_once 'Sample_Header.php';

use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Slide;
use PhpOffice\PhpPresentation\Shape\RichText;

$pptReader = IOFactory::createReader('PowerPoint2007');
$oPHPPresentation = $pptReader->load('resources/Sample_12.pptx');

$oTree = new PhpPptTree($oPHPPresentation);
echo $oTree->display();
if (!CLI) {
	include_once 'Sample_Footer.php';
}
