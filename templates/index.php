<?php
script('localbase','api/api-client');
script('localbase','models/model');
script('localbase','repositories/repository');
script('localbase','ui/ui');
script('orgsuite','suite-navigation');
script('adroom','models/room');
script('adroom','models/booking');
script('adroom','repositories/room-repository');
script('adroom','modules/booking-timeline');
script('adroom','modules/booking-workflow');
script('adroom','components/month-calendar');
script('adroom','components/booking-dialog');
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
    <section id="adr-calendar-view" aria-label="Raumkalender">
        <div class="adr-table-wrap">
            <table class="adr-calendar">
                <caption>Raumbuchungen des ausgewählten Monats</caption>
                <thead id="adr-calendar-head"></thead>
                <tbody id="adr-calendar-body"><tr><td>Daten werden geladen.</td></tr></tbody>
            </table>
        </div>
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
            <datalist id="adr-purpose-options"><option value="AT"><option value="Sitzung"><option value="BQ"><option value="Fortbildung"><option value="SV"><option value="HB"><option value="LG"></datalist>
            <label>Titel <input name="title" maxlength="255" aria-describedby="adr-title-hint" required></label>
            <small id="adr-title-hint">Zum Beispiel ASN, Gremium oder Thema.</small>
            <footer><button type="button" data-dialog-close>Abbrechen</button><button type="submit" class="primary">Speichern</button></footer>
        </form>
    </dialog>
</main>
