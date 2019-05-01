<?php
use Screen\Capture;

require_once 'vendor/autoload.php';

$name = $_REQUEST['id'];
$url = $_REQUEST['url'];
//$screenCapture = new Capture('http://docpoke.com');
// or
$screenCapture = new Capture();
$screenCapture->setUrl($url);
$screenCapture->setWidth(1800);
$screenCapture->setClipWidth(1780);
$screenCapture->setClipHeight(800);
$screenCapture->setLeft(10);
$screenCapture->setImageType('jpg');
$fileLocation = '../assets/photo/screenshot/'.$name.'-desktop.'.$screenCapture->getImageType()->getFormat();
$screenCapture->save($fileLocation);
$screenCapture->jobs->clean();
$screenCapture->setWidth(412);
$screenCapture->setClipWidth(412);
$screenCapture->setClipHeight(790);
$screenCapture->setImageType('jpg');
$fileLocation = '../assets/photo/screenshot/'.$name.'-mobile.'. $screenCapture->getImageType()->getFormat();
$screenCapture->save($fileLocation);
$screenCapture->jobs->clean();
$screenCapture->setWidth(768);
$screenCapture->setClipWidth(768);
$screenCapture->setClipHeight(1200);
$screenCapture->setImageType('jpg');

$fileLocation = '../assets/photo/screenshot/'.$name.'-tablet.'. $screenCapture->getImageType()->getFormat();
$screenCapture->save($fileLocation);
