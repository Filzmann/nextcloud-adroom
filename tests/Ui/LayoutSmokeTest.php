<?php

declare(strict_types=1);

$template=file_get_contents(__DIR__.'/../../templates/index.php'); $admin=file_get_contents(__DIR__.'/../../templates/admin.php'); $css=file_get_contents(__DIR__.'/../../css/style.css'); $info=file_get_contents(__DIR__.'/../../appinfo/info.xml');
if($template===false||$admin===false||$css===false||$info===false) throw new RuntimeException('UI-Vertragsdatei fehlt.');
foreach (['data-orgsuite data-suite="ad" data-current-app="adroom"','id="adr-calendar-view"','<caption>Raumbuchungen','id="adr-booking-dialog"','name="title"','value="SV"','value="HB"','value="LG"','step="900"','aria-live="polite"'] as $contract) if(!str_contains($template,$contract)) throw new RuntimeException("UI-Vertrag fehlt: {$contract}");
foreach(['adr-tab-settings','adr-settings-view','>Einstellungen</button>'] as $removed) if(str_contains($template,$removed)) throw new RuntimeException("Administrative Raumverwaltung liegt noch in der Fachansicht: {$removed}");
foreach(['id="adroom-admin"','id="adr-admin-room-body"','id="adr-admin-room-form"','<h2 id="adr-admin-heading">Räume</h2>'] as $contract) if(!str_contains($admin,$contract)) throw new RuntimeException("Raum-Adminvertrag fehlt: {$contract}");
foreach (['height: 100%','min-height: 0','overflow-y: auto','overflow-x: hidden','background: var(--color-main-background)','overflow-x:auto','width:max-content','focus'] as $contract) if(!str_contains($css,$contract)) throw new RuntimeException("Layoutvertrag fehlt: {$contract}");
if(!str_contains($info,'<app>orgsuite</app>')||!str_contains($info,'<admin>OCA\AdRoom\Settings\Admin</admin>')||str_contains($info,'<navigations>')) throw new RuntimeException('Suite-Appvertrag fehlt.');
echo "AD Raumplaner layout smoke test passed\n";
