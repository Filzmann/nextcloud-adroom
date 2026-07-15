<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$info = file_get_contents($root . '/appinfo/info.xml');
$admin = file_get_contents($root . '/lib/Settings/Admin.php');
$section = file_get_contents($root . '/lib/Settings/AdminSection.php');

foreach ([$info, $admin, $section] as $source) {
    if ($source === false) throw new RuntimeException('Admin-Vertragsdatei konnte nicht gelesen werden.');
}

foreach (['<admin>OCA\AdRoom\Settings\Admin</admin>', '<admin-section>OCA\AdRoom\Settings\AdminSection</admin-section>'] as $contract) {
    if (!str_contains($info, $contract)) throw new RuntimeException("Admin-Registrierung fehlt: {$contract}");
}
foreach (['return Application::APP_ID;', "return 'AD Raumplaner';", 'IIconSection'] as $contract) {
    if (!str_contains($admin . $section, $contract)) throw new RuntimeException("Eigener Raumplaner-Adminabschnitt fehlt: {$contract}");
}
if (str_contains($admin, "return 'orgsuite';")) throw new RuntimeException('Raumverwaltung darf nicht im Suite-Adminabschnitt hängen.');

echo "AdminSettingsContractTest: OK\n";
