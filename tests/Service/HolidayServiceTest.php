<?php

declare(strict_types=1);

require __DIR__.'/../../lib/Service/HolidayService.php';

$service=new OCA\AdRoom\Service\HolidayService();
$march=$service->forMonth(2026,3);
if (($march['2026-03-08']??'')!=='Internationaler Frauentag') throw new RuntimeException('Berliner Feiertag fehlt.');
$april=$service->forMonth(2026,4);
if (($april['2026-04-03']??'')!=='Karfreitag' || ($april['2026-04-06']??'')!=='Ostermontag') throw new RuntimeException('Bewegliche Feiertage sind fehlerhaft.');
echo "AD Raumplaner holiday tests passed\n";

