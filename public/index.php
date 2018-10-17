<?php

mt_srand();
for ($i = 18; $i > 0; $i--) {
    $id = mt_rand();

    echo '<a href="./shield.php?id=' . $id . '" target="_blank"><img src="./shield.php?id=' . $id . '"></a>';
}
