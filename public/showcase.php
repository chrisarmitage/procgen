<html>
<head>

</head>
<body>
<?php

$ordinariesWithVariations = [
    'bend',
    'cross',
    'pale',
    'fess',
    'saltire',
    'chevron',
];

$ordinariesWithoutVariations = [
    'chief',
    'paly',
    'barry',
    'chequy',
    'bendy',
    'lozengy',
    'chevronny',
    'bordure',
    'orle',
];

$variations = [
    'standard',
    'half',
    'quarter',
    'cotised',
    'double-cotised',
    'twin',
    'triple',
];

$queryStrings = [];
$fieldType = 'ordinary';
foreach ($ordinariesWithVariations as $ordinary) {
    foreach ($variations as $variation) {
        $queryStrings["FieldType: {$fieldType}\nOrdinary: {$ordinary}\nVariation: {$variation}"] = http_build_query(
            [
                'foreground' => 'ff0000',
                'background' => 'f0f0f0',
                'fieldType'  => $fieldType,
                'ordinary'   => $ordinary,
                'variation'  => $variation,
                'addCharge' => 'false',
            ]
        );
    }
    $queryStrings[] = null;
}
?>
<div>
    <?php foreach ($queryStrings as $key => $queryString) : ?>
    <?php if ($queryString === null) : ?>
        </div><div>
    <?php else : ?>
        <img src="shield.php?<?= $queryString; ?>" width="128" height="128" title="<?= $key; ?>"/>
    <?php endif; ?>
    <?php endforeach; ?>
</div>

<hr />

<?php

$queryStrings = [];
$fieldType = 'ordinary';
foreach ($ordinariesWithoutVariations as $ordinary) {
    $queryStrings["FieldType: {$fieldType}\nOrdinary: {$ordinary}\nVariation: {$variation}"] = http_build_query(
        [
            'foreground' => 'ff0000',
            'background' => 'f0f0f0',
            'fieldType'  => $fieldType,
            'ordinary'   => $ordinary,
            'addCharge' => 'false',
        ]
    );
    //$queryStrings[] = null;
}
?>
<div>
    <?php foreach ($queryStrings as $key => $queryString) : ?>
    <?php if ($queryString === null) : ?>
</div><div>
    <?php else : ?>
        <img src="shield.php?<?= $queryString; ?>" width="128" height="128" title="<?= $key; ?>"/>
    <?php endif; ?>
    <?php endforeach; ?>
</div>

<hr />

<?php

$parties = [
    'bend',
    'cross',
    'pale',
    'fess',
    'saltire',
    'chevron',
    'gyronny',
];

$lineVariations = [
    'none',
    'invected',
    'engrailed',
    'embattled',
];

$queryStrings = [];

$fieldType = 'party';
foreach ($parties as $party) {
    foreach ($lineVariations as $lineVariation) {
        $queryStrings["FieldType: {$fieldType}\nParty: {$party}\nLine: {$lineVariation}"] = http_build_query(
            [
                'foreground' => 'ff0000',
                'background' => 'f0f0f0',
                'fieldType'  => $fieldType,
                'party'      => $party,
                'lineVariation' => $lineVariation,
            ]
        );
    }
    $queryStrings[] = null;
}
?>
<div>
    <?php foreach ($queryStrings as $key => $queryString) : ?>
    <?php if ($queryString === null) : ?>
</div><div>
    <?php else : ?>
        <img src="shield.php?<?= $queryString; ?>" width="128" height="128" title="<?= $key; ?>"/>
    <?php endif; ?>
    <?php endforeach; ?>
</div>
</body>
</html>
