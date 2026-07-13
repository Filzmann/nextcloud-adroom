<?php
script('localbase','api/api-client');
script('localbase','models/model');
script('localbase','ui/ui');
script('orgsuite','suite-navigation');
script('adroom','models/room');
script('adroom','models/booking');
script('adroom','repositories/room-repository');
script('adroom','components/month-calendar');
script('adroom','components/booking-dialog');
script('adroom','components/room-settings');
script('adroom','main');
style('orgsuite','suite-navigation');
style('adroom','style');
?>
<main id="adroom-app" class="adr-app">
    <div class="orgsuite-host" data-orgsuite data-suite="ad" data-current-app="adroom"></div>
    <header class="adr-header">
        <div><h1>AD Raumplaner</h1><p>Räume und Buchungen im Monatsüberblick</p></div>
        <nav class="adr-month-navigation" aria-label="Monat auswählen">
            <button type="button" id="adr-previous">Vorheriger Monat</button>
            <label>Monat <input id="adr-month" type="month"></label>
            <button type="button" id="adr-next">Nächster Monat</button>
        </nav>
    </header>
    <div id="adr-notice" class="adr-notice" role="status" aria-live="polite" hidden></div>
    <nav class="adr-tabs" role="tablist" aria-label="Raumplaner Bereiche">
        <button type="button" id="adr-tab-calendar" role="tab" aria-controls="adr-calendar-view" aria-selected="true">Raumkalender</button>
        <button type="button" id="adr-tab-rooms" role="tab" aria-controls="adr-room-view" aria-selected="false" hidden>Räume verwalten</button>
    </nav>
    <section id="adr-calendar-view" role="tabpanel" aria-labelledby="adr-tab-calendar">
        <div class="adr-table-wrap">
            <table class="adr-calendar">
                <caption>Raumbuchungen des ausgewählten Monats</caption>
                <thead id="adr-calendar-head"></thead>
                <tbody id="adr-calendar-body"><tr><td>Daten werden geladen.</td></tr></tbody>
            </table>
        </div>
    </section>
    <section id="adr-room-view" role="tabpanel" aria-labelledby="adr-tab-rooms" hidden>
        <h2>Räume verwalten</h2>
        <p>Beim Löschen eines Raums werden auch alle zugehörigen Buchungen gelöscht.</p>
        <div class="adr-table-wrap"><table class="adr-room-table"><caption>Vorhandene Räume</caption><thead><tr><th>Name</th><th>Beschreibung</th><th>Reihenfolge</th><th>Aktionen</th></tr></thead><tbody id="adr-room-body"></tbody></table></div>
        <form id="adr-room-form" class="adr-room-form">
            <label>Name <input name="name" required maxlength="255"></label>
            <label>Beschreibung <input name="description" maxlength="500"></label>
            <label>Reihenfolge <input name="sortOrder" type="number" min="0" value="0"></label>
            <button type="submit">Raum anlegen</button>
        </form>
    </section>
    <dialog id="adr-booking-dialog" class="adr-dialog" aria-labelledby="adr-booking-title">
        <form id="adr-booking-form">
            <header><h2 id="adr-booking-title">Raumbuchung</h2><button type="button" class="adr-icon-button" data-dialog-close aria-label="Dialog schließen" title="Schließen"><span aria-hidden="true">×</span></button></header>
            <input name="id" type="hidden">
            <label>Raum <select name="roomId" required></select></label>
            <label>Datum <input name="date" type="date" required></label>
            <div class="adr-time-row">
                <label>Beginn <input name="startTime" type="time" min="06:00" max="21:00" step="900" required></label>
                <label>Ende <input name="endTime" type="time" min="06:00" max="21:00" step="900" required></label>
            </div>
            <label>Zweck <input name="purpose" list="adr-purpose-options" maxlength="255" required></label>
            <datalist id="adr-purpose-options"><option value="AT"><option value="Sitzung"><option value="BQ"><option value="FoBi"></datalist>
            <footer><button type="button" data-dialog-close>Abbrechen</button><button type="submit" class="primary">Speichern</button></footer>
        </form>
    </dialog>
</main>

