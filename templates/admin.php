<?php
script('localbase', 'api/api-client');
script('localbase', 'models/model');
script('localbase', 'ui/ui');
script('adroom', 'models/room');
script('adroom', 'repositories/room-repository');
script('adroom', 'components/room-settings');
script('adroom', 'admin');
style('adroom', 'style');
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
</section>
