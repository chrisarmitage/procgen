<?php

mt_srand();
for ($i = 49; $i > 0; $i--) {
    $id = mt_rand();
    $id = $i;

    echo '<a href="./shield.php?id=' . $id . '&' . http_build_query($_GET) . '" target="_blank"><img src="./shield.php?id=' . $id . '&' . http_build_query($_GET) . '" width="128" height="128"></a>';
}
