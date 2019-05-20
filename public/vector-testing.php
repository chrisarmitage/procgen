<?php


require __DIR__ . '/../vendor/autoload.php';

use ProcGen\Vector;

$vector = Vector::makeFromPolar(13, 22.6);

var_dump($vector);
var_dump($vector->getCartesian());


$vector = Vector::makeFromCartesian(12, 5);

var_dump($vector);
var_dump($vector->getPolar());


echo '<h3>Adding</h3>';

$v1 = Vector::makeFromCartesian(2, 2);
$v2 = Vector::makeFromCartesian(2, 1);

$v3 = $v1->add($v2);

var_dump($v3->getCartesian());


echo '<h3>Adding</h3>';

$v1 = Vector::makeFromCartesian(4, 2);
$v2 = Vector::makeFromCartesian(2, 1);

$v3 = $v1->subtract($v2);

var_dump($v3->getCartesian());
