<?php

use ProcGen\HeaterShield;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/vector-lib.php';

ini_set('display_errors', 1);

$id = isset($_GET['id']) ? $_GET['id'] : 0;

mt_srand($id);
$types = [
    HeaterShield::class,
];

$type = $types[mt_rand(0, count($types) - 1)];
$gen = new $type;
$image = $gen->generate($id, $_GET);

header('Content-Type: image/svg+xml');
echo $image;
