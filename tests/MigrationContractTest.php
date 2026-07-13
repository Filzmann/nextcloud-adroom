<?php

declare(strict_types=1);

$initial = file_get_contents(__DIR__ . '/../lib/Migration/Version000001Date202607130001.php');
if ($initial === false) throw new RuntimeException('Initiale Raumplaner-Migration konnte nicht gelesen werden.');
if (!str_contains($initial, "addColumn('title', Types::STRING, ['length' => 255, 'notnull' => true])")) {
    throw new RuntimeException('Buchungstitel ist in der initialen Migration nicht verpflichtend.');
}
if (glob(__DIR__ . '/../lib/Migration/Version000002*.php') !== []) {
    throw new RuntimeException('Nicht benötigte Übergangsmigration ist weiterhin vorhanden.');
}

echo "AD Raumplaner migration contract test passed\n";
