<?php

use ProcGen\HeaterShield;

require_once __DIR__ . '/../vendor/autoload.php';

$f = scandir(__DIR__);
error_log('scandir : __DIR__ : ' . implode(' // ', $f));

$f = scandir(__DIR__ . '/../');
error_log('scandir : __DIR__/.. : ' . implode(' // ', $f));

$f = file_get_contents(__DIR__ . '/../vendor/composer/autoload_psr4.php');
error_log('autoload_psr4 : ' . $f);

$f = file_get_contents(__DIR__ . '/../vendor/composer/autoload_static.php');
error_log('autoload_static : ' . $f);

$id = isset($_GET['id']) ? $_GET['id'] : 0;

mt_srand($id);
$types = [
    HeaterShield::class,
];

$type = $types[mt_rand(0, count($types) - 1)];
$gen = new $type;
$image = $gen->generate($id);

header('Content-Type: image/svg+xml');
echo $image;
