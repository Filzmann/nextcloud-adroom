<?php
\OCP\Util::addScript('localbase', 'api/api-client');
\OCP\Util::addScript('localbase', 'models/model');
\OCP\Util::addScript('localbase', 'repositories/repository');
\OCP\Util::addScript('localbase', 'ui/ui');
\OCP\Util::addScript('adroom', 'models/room');
\OCP\Util::addScript('adroom', 'models/booking');
\OCP\Util::addScript('adroom', 'repositories/room-repository');
\OCP\Util::addScript('adroom', 'modules/room-workflow');
\OCP\Util::addScript('adroom', 'components/room-settings');
\OCP\Util::addScript('adroom', 'admin');
\OCP\Util::addStyle('adroom', 'style');
?>
<section id="adroom-admin" class="section adr-admin" aria-labelledby="adr-admin-heading">
    <h2 id="adr-admin-heading">Räume</h2>
    <p>Diese Raumstammdaten gelten organisationsweit im AD Raumplaner. Beim Löschen eines Raums werden auch alle zugehörigen Buchungen gelöscht.</p>
    <div id="adr-admin-notice" class="adr-notice" role="status" aria-live="polite" aria-atomic="true" hidden></div>
    <div class="adr-table-wrap">
        <table class="adr-room-table">
            <caption>Vorhandene Räume</caption>
            <thead><tr><th>Name</th><th>Beschreibung</th><th>Reihenfolge</th><th>Aktionen</th></tr></thead>
            <tbody id="adr-admin-room-body"><tr><td colspan="4">Räume werden geladen.</td></tr></tbody>
        </table>
    </div>
    <form id="adr-admin-room-form" class="adr-room-form">
        <label>Name <input name="name" required maxlength="255"></label>
        <label>Beschreibung <input name="description" maxlength="500"></label>
        <label>Reihenfolge <input name="sortOrder" type="number" min="0" value="0"></label>
        <button type="submit" class="primary">Raum anlegen</button>
    </form>
    <section class="adr-admin-demo" aria-labelledby="adr-demo-heading">
        <h3 id="adr-demo-heading">Demo-Pack</h3>
        <p>Das Pack legt drei neutrale Räume und Beispielbuchungen unter einem synthetischen lokalen Demokonto an. Es wird nicht automatisch installiert und importiert keine Bestandsdaten.</p>
        <p id="adr-demo-notice" class="adr-notice" role="status" aria-live="polite" hidden></p>
        <label class="adr-demo-confirm"><input id="adr-demo-confirm" type="checkbox"> Ich bestätige die Installation synthetischer Demodaten.</label>
        <button id="adr-demo-install" type="button" class="primary" disabled>Raum-Demo-Pack installieren</button>
    </section>
</section>
