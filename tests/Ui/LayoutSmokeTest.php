<?php

declare(strict_types=1);

$template=file_get_contents(__DIR__.'/../../templates/index.php'); $css=file_get_contents(__DIR__.'/../../css/style.css'); $info=file_get_contents(__DIR__.'/../../appinfo/info.xml');
if($template===false||$css===false||$info===false) throw new RuntimeException('UI-Vertragsdatei fehlt.');
foreach (['data-orgsuite data-suite="ad" data-current-app="adroom"','role="tablist"','<caption>Raumbuchungen','id="adr-booking-dialog"','step="900"','aria-live="polite"'] as $contract) if(!str_contains($template,$contract)) throw new RuntimeException("UI-Vertrag fehlt: {$contract}");
foreach (['height: 100%','min-height: 0','overflow-y: auto','overflow-x: hidden','background: var(--color-main-background)','overflow-x:auto','width:max-content','focus'] as $contract) if(!str_contains($css,$contract)) throw new RuntimeException("Layoutvertrag fehlt: {$contract}");
if(!str_contains($info,'<app>orgsuite</app>')||str_contains($info,'<navigations>')) throw new RuntimeException('Suite-Appvertrag fehlt.');
echo "AD Raumplaner layout smoke test passed\n";

