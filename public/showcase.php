<html>
<head>

</head>
<body>
<?php

$ordinaries = [
    'bend',
    'cross',
    'pale',
    'fess',
    'saltire',
    'chevron',
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
];

$parties = [
    'bend',
    'cross',
    'pale',
    'fess',
    'saltire',
    'chevron',
    'gyronny',
];

$queryStrings = [];
$fieldType = 'ordinary';
foreach ($ordinaries as $ordinary) {
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

$fieldType = 'party';
foreach ($parties as $party) {
    $queryStrings["FieldType: {$fieldType}\nParty: {$party}"] = http_build_query(
        [
            'foreground' => 'ff0000',
            'background' => 'f0f0f0',
            'fieldType'  => $fieldType,
            'party'      => $party,
        ]
    );
}
?>
<div>
    <?php foreach ($queryStrings as $key => $queryString) : ?>
        <img src="shield.php?<?= $queryString; ?>" width="128" height="128" title="<?= $key; ?>"/>
    <?php endforeach; ?>
</div>
</body>
</html>
